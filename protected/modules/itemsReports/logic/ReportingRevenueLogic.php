<?php
if (!function_exists('array_column')) {
    function array_column($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray)?$subArray->$columnKey: $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray)?$subArray->$indexKey: $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray)?$subArray->$indexKey: $subArray[$indexKey];
                    $result[$index] = is_object($subArray)?$subArray->$columnKey: $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}


class ReportingRevenueLogic extends CFormModel
{
	public $fromtime;
	public $totime;
	public $dentist;


	public function rules()
	{
		return array(
			array('dentist', 'filter', 'filter' => 'trim'),
			array(array('fromtime', 'totime', 'dentist'), 'required'),
		);
	}

	public function getReport()
	{
		if (!$this->validate()) return array();

		$fromtime = $this->fromtime;
		$totime = $this->totime;
		$dentist = $this->dentist;
		$revenue = $this->getRevenue($fromtime, $totime, $dentist);
		$paid = $this->getPaidTransactions($fromtime, $totime, $dentist);
		$debt = $this->getDebtTransactions($fromtime, $totime, $dentist);
		$pkc = $this->getPKCTransactions($fromtime, $totime, $dentist);

		$a = array_keys($revenue);
		$b = array_column($paid, 'id_service_type');
		$c = array_keys($debt);
		$d = array_keys($pkc);
		$serviceTypeIds = array_unique(array_merge($a, $b, $c, $d));
		if (!count($serviceTypeIds)) return array();
		$serviceTypes = $this->getServiceTypes($serviceTypeIds);
		return $this->buildReport($serviceTypes, $revenue, $paid, $debt, $pkc);
	}

	protected function getRevenue($fromtime, $totime, $dentist) {
		$con = Yii::app()->db;
        $sql = "SELECT 
        cs.id_service_type, 
        SUM(d.unit_price * d.qty * (100 - IFNULL(d.percent_change, 0)) / 100) AS revenue_gross, 
        SUM(d.unit_price * d.qty * (100 - IFNULL(d.percent_change, 0)) / 100 * (100 - IFNULL(d.percent_decrease, 0)) / 100) AS revenue_net, 
        SUM(d.unit_price * d.qty * (100 - IFNULL(d.percent_change, 0)) / 100 * IFNULL(d.percent_decrease, 0) / 100) AS discount 
        FROM invoice_detail d
        INNER JOIN invoice i ON i.id = d.id_invoice AND i.confirm = 1
		INNER JOIN cs_service cs ON cs.id = d.id_service
		WHERE d.create_date BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59'
		AND d.id_user IN ($dentist)
		GROUP BY cs.id_service_type
		";
		$list = $con->createCommand($sql)->queryAll();
		return array_column($list, null, 'id_service_type');
	}


	protected function getPaidTransactions($fromtime, $totime, $dentist) {
		$con = Yii::app()->db;
		$debtPaid = TransactionInvoice::ThanhToan;
		$debtRefund = TransactionInvoice::HoanTra;
        $sql = "SELECT cs.id_service_type, r.pay_type, r.is_company, SUM(IF(t.debt = $debtPaid, t.amount, (-1) * t.amount)) AS amount
        FROM transaction_invoice t
        INNER JOIN cs_service cs ON cs.id = t.id_service
        LEFT JOIN receipt r ON t.id_receipt = r.id AND t.id_receipt IS NOT NULL
        WHERE t.pay_date BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59' 
		AND t.id_user IN ($dentist)
        AND t.debt IN ($debtPaid, $debtRefund)
		GROUP BY cs.id_service_type, r.pay_type, r.is_company
        ";
        return $con->createCommand($sql)->queryAll();
	}

	protected function getDebtTransactions($fromtime, $totime, $dentist) {
		$con = Yii::app()->db;
		$debt = TransactionInvoice::ConNo;
        $sql = "SELECT cs.id_service_type, SUM(t.amount) AS amount
        FROM transaction_invoice t
        INNER JOIN cs_service cs ON cs.id = t.id_service
        -- WHERE t.create_date BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59' 
        WHERE t.create_date >= '$fromtime 00:00:00' 
		AND t.id_user IN ($dentist)
        AND t.debt = $debt
		GROUP BY cs.id_service_type
        ";
        $list = $con->createCommand($sql)->queryAll();
        return array_column($list, 'amount', 'id_service_type');
	}

	protected function getPKCTransactions($fromtime, $totime, $dentist) {
		$con = Yii::app()->db;
		$debt = TransactionInvoice::PhongKhamChuyen;
        $sql = "SELECT cs.id_service_type, SUM(t.amount) AS amount
        FROM transaction_invoice t
        INNER JOIN cs_service cs ON cs.id = t.id_service
        WHERE t.pay_date BETWEEN '$fromtime 00:00:00' AND '$totime 23:59:59' 
		AND t.id_user IN ($dentist)
        AND t.debt = $debt
		GROUP BY cs.id_service_type
        ";
        $list = $con->createCommand($sql)->queryAll();
        return array_column($list, 'amount', 'id_service_type');
	}

	protected function getServiceTypes($ids) {
		$con = Yii::app()->db;
		$idsString = implode(",", $ids);
        $sql = "SELECT id, name
        FROM cs_service_type
		WHERE id IN ($idsString)
		";
		$list = $con->createCommand($sql)->queryAll();
		return array_column($list, 'name', 'id');
	}

	protected function buildReport($serviceTypes, $revenues, $paids, $debts, $pkcs) {
		$reportPayTypes = array(1 => 'cash', 2 => 'credit', 3 => 'transfer', 4 => 'insurrance');
		$result = array();
		foreach ($serviceTypes as $serviceTypeId => $serviceTypeName) {
			$reportRow = array();
			$debt = isset($debts[$serviceTypeId]) ? $debts[$serviceTypeId] : 0;
			$pkc = isset($pkcs[$serviceTypeId]) ? $pkcs[$serviceTypeId] : 0;
			$revenue = isset($revenues[$serviceTypeId]) ? $revenues[$serviceTypeId] : array('revenue_gross' => 0, 'revenue_net' => 0, 'discount' => 0);

			// Build paids
			$paidsBySerivce = array_filter($paids, function($row) use ($serviceTypeId) {
				return isset($row['id_service_type']) && $row['id_service_type'] == $serviceTypeId;
			});
			$paid = array();
			foreach ($reportPayTypes as $payType => $payTypeValue) {
				$paidsByType = array_filter($paidsBySerivce, function($row) use ($payType) {
					return $row['pay_type'] == $payType;
				});
				if (in_array($payTypeValue, array('credit', 'transfer'))) {
					$paid[$payTypeValue . '_individual'] = array_sum(array_map(function ($row) {
						return $row['is_company'] ? 0 : $row['amount'];
					}, $paidsByType));
					$paid[$payTypeValue . '_company'] = array_sum(array_map(function ($row) {
						return $row['is_company'] ? $row['amount'] : 0;
					}, $paidsByType));
				} else {
					$paid[$payTypeValue] = array_sum(array_column($paidsByType, 'amount'));
				}
			}

			$reportRow['id'] = $serviceTypeId;
			$reportRow['name'] = $serviceTypeName;
			$reportRow['revenue_gross'] = $revenue['revenue_gross'];
			$reportRow['discount'] = $revenue['discount'];
			$reportRow['revenue_net'] = $revenue['revenue_net'];
			$reportRow['debt'] = $debt;
			$reportRow['pkc'] = $pkc;
			$paidTotal = 0;
			foreach($reportPayTypes as $payTypeValue) {
				if (in_array($payTypeValue, array('credit', 'transfer'))) {
					$reportRow['paid_' . $payTypeValue . '_individual'] = $paid[$payTypeValue . '_individual'];
					$reportRow['paid_' . $payTypeValue . '_company'] = $paid[$payTypeValue . '_company'];
					$paidTotal += (int)$paid[$payTypeValue . '_individual'];
					$paidTotal += (int)$paid[$payTypeValue . '_company'];

				} else {
					$reportRow['paid_' . $payTypeValue] = $paid[$payTypeValue];
					$paidTotal += $payTypeValue === 'insurrance' ? 0 : (int)$paid[$payTypeValue];
				}
			}
			$reportRow['paid'] = $paidTotal;
			$result[] = $reportRow;
		}
		return $result;
	}

	public function getSum($list) {
		return array(
			'revenue_gross' => array_sum(array_column($list, 'revenue_gross')),
			'discount' => array_sum(array_column($list, 'discount')),
			'revenue_net' => array_sum(array_column($list, 'revenue_net')),
			'debt' => array_sum(array_column($list, 'debt')),
			'pkc' => array_sum(array_column($list, 'pkc')),
			'paid' => array_sum(array_column($list, 'paid')),
			'paid_cash' => array_sum(array_column($list, 'paid_cash')),
			'paid_credit_individual' => array_sum(array_column($list, 'paid_credit_individual')),
			'paid_credit_company' => array_sum(array_column($list, 'paid_credit_company')),
			'paid_transfer_individual' => array_sum(array_column($list, 'paid_transfer_individual')),
			'paid_transfer_company' => array_sum(array_column($list, 'paid_transfer_company')),
			'paid_insurrance' => array_sum(array_column($list, 'paid_insurrance')),
		);
	}

}