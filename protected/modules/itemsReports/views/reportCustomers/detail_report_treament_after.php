<p class="tt" style="float:left;">Khách hàng gọi sau điều trị</p>
<p style="float: right;"> <?php echo $title; ?></p>

<div class="table table-responsive">
    <table class="table table-hover" id="list_export" style="width: 2000px;">
        <thead class="headertable">
            <tr>
                <td colspan="11" style="display: none; text-align: center; font-size: 20px;">
                    KHÁCH HÀNG GỌI SAU ĐIỀU TRỊ
                </td>
            </tr>
            <tr>
                <td colspan="11" style="display: none; text-align: center;">
                    <?php echo $title; ?>
                </td>
            </tr>

            <tr>
                <th>STT</th>
                <th>KH</th>
                <th>SỐ HS</th>
                <th>HỌ TÊN KH</th>
                <th>NĂM SINH</th>
                <th>PHONE</th>
                <th>CHẨN ĐOÁN</th>
                <th>CHI TIẾT ĐIỀU TRỊ</th>
                <th>BÁC SĨ</th>
                <th>TÌNH TRẠNG</th>
                <th>PHẢN HỒI</th>
                <th>THỐNG KÊ SỐ LƯỢNG CUỘC GỌI</th>
                <th>THỜI GIAN HẸN</th>
                <th>HẸN</th>
                <th>KHUYẾN MÃI - CHẾ ĐỘ</th>
                <th>Tên KH giới thiệu</th>
                <th>ĐT</th>
                <th>SỐ HS</th>
                <th>GHI CHÚ</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($data == 0 || empty($data)) : ?>
                <tr>
                    <td colspan=19>Không có dữ liệu!</td>
                </tr>
            <?php else : ?>
                <?php $idx = 1; ?>

                <?php foreach ($data as $key => $value) : ?>
                    <?php $nextSch = Customer::model()->getNextScheduleTreatment($value['id_schedule'], $value['id_customer'], $value['id_branch']); ?>
                    <?php $mhg = Customer::model()->getMedicalHistory($value['start_time'], $value['id_customer']); ?>
                    <?php $id_mhg = ($mhg) ? $mhg['id'] : 0; ?>

                    <?php $partner = ($mhg) ? CHtml::listData(Customer::model()->getPartner($id_mhg), 'id_invoice', 'name') : array(); ?>

                    <?php $idInvoiceList = array_keys($partner); ?>

                    <?php $diagnostic = ($mhg) ? Customer::model()->getDiagnostic($id_mhg) : array(); ?>
                    <?php $invoiceDetails = ($mhg) ? Customer::model()->getInvoiceDetail(implode(',',$idInvoiceList)) : array(); ?>
                    <?php $treatmentDetail = ($mhg) ? Customer::model()->getTreatmentDetail($id_mhg) : array(); ?>

                    <?php $treatment = array_merge($invoiceDetails, $treatmentDetail); ?>

                    <?php $countDiagnostic = count($diagnostic) > 1 ? count($diagnostic) : 1; ?>
                    <?php $countInvoice = count($invoiceDetails); ?>
                    <?php $countTreatment = count($treatmentDetail); ?>

                    <?php $rowspan = max($countDiagnostic, $countInvoice + $countTreatment); ?>

                    <tr>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo $idx++; ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo $value['service_name']; ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo $value['code_number']; ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo $value['fullname']; ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo date_format(date_create($value['birthdate']), 'd/m/Y'); ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo $value['phone']; ?></td>
                        <td><?php if (isset($diagnostic[0])) echo $diagnostic[0]['tooth_number'] . ': ' . $diagnostic[0]['conclude'] . ' - ' . $diagnostic[0]['assign']; ?></td>
                        <td><?php if (isset($treatment[0])) echo $treatment[0]['teeth'] . ': ' . $treatment[0]['treatment']; ?></td>
                        <td>
                            <?php if (isset($treatment[0])) echo $treatment[0]['user_name']; ?>
                        </td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php if ($nextSch) echo date_format(date_create($nextSch['start_time']), 'H:i d/m/Y'); ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php if ($nextSch) echo $nextSch['length']; ?></td>
                        <td rowspan=<?php echo $rowspan; ?>><?php echo implode(', ', array_filter($partner)); ?></td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                        <td rowspan=<?php echo $rowspan; ?>></td>
                    </tr>

                    <?php if ($rowspan > 1): ?>
                        <?php for ($i = 1; $i < $rowspan; $i++): ?>
                            <tr>
                                <td>
                                    <?php if (isset($diagnostic[$i])): ?>
                                        <?php echo $diagnostic[$i]['tooth_number']; ?>: <?php echo $diagnostic[$i]['conclude']; ?> - <?php echo $diagnostic[$i]['assign']; ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (isset($treatment[$i])): ?>
                                        <?php echo $treatment[$i]['teeth']; ?>: <?php echo $treatment[$i]['treatment']; ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (isset($treatment[$i])): ?>
                                        <?php echo $treatment[$i]['user_name']; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>