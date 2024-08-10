<?php

class ReportingTreatmentAfterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '/layouts/main_sup';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return parent::accessRules();
	}

	public function actionView()
	{
		$this->render('view');
	}

	public function actionCheckExistData() {
		$create_date = isset($_POST['create_date'])?$_POST['create_date']:false;
		if ($create_date) {
			echo AfterTreatmentNote::model()->countByAttributes(array('create_date' => $create_date));
		} else {
			echo -1;
		}
	}

	public function actionSaveTreatment() {
		$create_date = isset($_POST['create_date'])?$_POST['create_date']:false;
		if ($create_date) {
			// xoa data note cu
			$noteList = AfterTreatmentNote::model()->findAllByAttributes(array('create_date' => $create_date));	
			foreach ($noteList as $key => $value) {
				$value->delete();
			}

			// lay danh sach KH theo lich hen
			// $customer_list = Customer::model()->getListCustomerTreatmentAfter(1, $create_date);
			// lay danh sach tu chi tiet hoa don
			$invoiceDetail = new InvoiceDetail();
			$customer_list = $invoiceDetail->showDetailDieuTriCSKH($create_date);
			if ($customer_list) {
				foreach ($customer_list as $key => $value) {
					$cs = array(
						'id_customer' => $value['id_customer'],
						'customer_fullname' => $value['fullname'],
						'code_number' => $value['code_number'],
						'create_date' => $create_date,
						//'service_code' => $value['code_service'],
						'service_code' => '',
						'treatment' => $value['treatment'],
						'treatment_doctor' => $value['treatment_doctor'],
						'cs_time' => '',
						'feedback' => '',
						'quality' => '',
						'appointment' => '',
						'next_schedule' => '0000-00-00 00:00:00',
						'next_schedule_time' => '',
						'ref_customer' => '',
						'ref_customer_code' => '',
						'note' => ''
					);

					$code = Yii::app()->db->createCommand()
						->select('cs_service.code')
						->from('cs_service')
						->join('cs_schedule', 'cs_schedule.id_service = cs_service.id')
						->where('cs_schedule.id_customer=:id_customer', array(':id_customer' => $value['id_customer']))
						->andWhere('date(cs_schedule.start_time)=:create_date', array(':create_date' => $create_date))
						->queryScalar();
					if ($code) {
						$cs['service_code'] = $code;
					}
					// lay thong tin kh
					// $customer = Customer::model()->findByPk($value['id_customer']);
					// if ($customer) {
					// 	$cs['customer_fullname'] = $customer->fullname;
					// 	$cs['code_number'] = $customer->code_number;
					// } else {
					// 	$cs['customer_fullname'] = '';
					// 	$cs['code_number'] = '';
					// }

					$cs['diagnose'] = $cs['diagnose_doctor'] = $cs['no_treament'] = $cs['no_treament_doctor'] = $cs['partner'] = array();

					// lay danh sach chuan doan
					$concludeList = Yii::app()->db->createCommand()
				       ->select('conclude, id_user')   
				       ->from('tooth_conclude')
				       ->where('tooth_conclude.id_customer=:id_customer', array(':id_customer'=>$value['id_customer']))
				       ->queryAll();
				    if ($concludeList) {
				    	// lay ten bs chuan doan
				    	foreach ($concludeList as $conclude) {
				    		$userConclude = GpUsers::model()->findByPk($conclude['id_user']);
				    		$cs['diagnose'][] = $conclude['conclude'];
				    		$cs['diagnose_doctor'][] = $userConclude?$userConclude->name:'';
				    	}
				    }
				 //    // lay danh sach dieu tri
				 //    $mhg = Customer::model()->getMedicalHistory($create_date, $value['id_customer']);
				 //    $treatmentList = Customer::model()->getListTreatmentWork($mhg['id'], '', $value['id_customer']);
				 //    if ($treatmentList) {
				 //    	foreach ($treatmentList as $treatment) {
				 //    		$userTreatment = GpUsers::model()->findByPk($treatment['id_dentist']);
				 //    		$cs['treatment'][] = $treatment['treatment_work'];
				 //    		$cs['treatment_doctor'][] = $userTreatment?$userTreatment->name:'';
				 //    	}
				 //    }
				 //    // lay danh sach ko dieu tri
				    $noTreatmentList = VQuotationDetail::model()->searchQuotationDetail("status = 0 and id_customer = ".$value['id_customer']);
				    if ($noTreatmentList) {
				    	foreach ($noTreatmentList as $noTreatment) {
				    		$userNoTreatment = GpUsers::model()->findByPk($noTreatment['id_user']);
				    		$user_no_treatment = '';
				    		if ($userNoTreatment) {
				    			$user_no_treatment = $userNoTreatment->name;
				    		}
				    		$cs['no_treament'][] = $noTreatment['code_service'];
				    		$cs['no_treament_doctor'][] = $userNoTreatment?$userNoTreatment->name:'';
				    	}
				    }
				    // lay danh sach doi tac
				    $insuranceList = Yii::app()->db->createCommand()
						->select('partnerID')
						->from('invoice')
						->where('id_customer=:id_customer', array(':id_customer' => $value['id_customer']))
						->andWhere('date(create_date)=:create_date', array(':create_date' => $create_date))
						->andWhere('confirm=1')
						->queryAll();
					if ($insuranceList) {
						foreach ($insuranceList as $insurance) {
							if ($insurance['partnerID'])
								$cs['partner'][] = $insurance['partnerID'];
						}
					}
					//$cs['service_code'] = str_replace(',', '<br>', $cs['service_code']);
					$cs['diagnose'] = $cs['diagnose']?implode($cs['diagnose'], '<br>'):"";
					$cs['diagnose_doctor'] = $cs['diagnose_doctor']?implode($cs['diagnose_doctor'], '<br>'):'';
					$cs['treatment'] = str_replace(',', '<br>', $cs['treatment']);
					$cs['treatment_doctor'] = str_replace(',', '<br>', $cs['treatment_doctor']);
					$cs['no_treament'] = $cs['no_treament']?implode($cs['no_treament'], '<br>'):"";
					$cs['no_treament_doctor'] = $cs['no_treament_doctor']?implode($cs['no_treament_doctor'], '<br>'):"";
					$cs['partner'] = $cs['partner']?implode($cs['partner'], '<br>'):"";
					
					$afterTreatmentNoteModel = new AfterTreatmentNote();
					$afterTreatmentNoteModel->attributes = $cs;//var_dump($cs);
					if ($afterTreatmentNoteModel->validate() && $afterTreatmentNoteModel->save()) {
						//save success
					}
				}
			}
			echo 1;
		}
		echo -1;
	}

	public function actionUpdateScheduleTime() {
		$start_time = isset($_POST['start_time'])?$_POST['start_time']: false;
		$end_time = isset($_POST['end_time'])?$_POST['end_time']: false;
		if ($start_time && $end_time) {
			$noteList = AfterTreatmentNote::model()->findAll(array('select' => '*','condition' => ' date(`create_date`) between \''.$start_time.'\' AND \''.$end_time.'\''));
			if ($noteList) {
				foreach ($noteList as $key => $value) {
					$schedule = CsSchedule::model()->find(array('select' => 'start_time, lenght','condition' => 'id_customer = '.$value['id_customer'].' AND status = 1 AND active = 1 AND date(start_time) > date("'.$value['create_date'].'")'));
					$value->next_schedule = '';
					$value->next_schedule_time = '';
					if ($schedule) {
						$value->next_schedule = $schedule->start_time;
						$value->next_schedule_time = $schedule->lenght;
						if ($value->validate() && $value->save()) {
							// ssave next schedule
						}
					}	
				}
			}
			echo 1;
		} else {
			echo -1;
		}
	}

	public function actionLoadUpdateNote() {
		$id = isset($_POST['id'])?$_POST['id']:false;
		if ($id) {
			$model = AfterTreatmentNote::model()->findByPk($id);
			$this->renderPartial('update_treatment_note', array(
				'model'     => $model
			), false, false);
		}
	}

	public function actionUpdateNote() {
		$id = isset($_POST['id'])?$_POST['id']: false;
		$service_code =  isset($_POST['service_code'])?$_POST['service_code']: false;
		$cs_time =  isset($_POST['cs_time'])?$_POST['cs_time']: false;
		$feedback =  isset($_POST['feedback'])?$_POST['feedback']: false;
		$quality =  isset($_POST['quality'])?$_POST['quality']: false;
		$appointment =  isset($_POST['appointment'])?$_POST['appointment']: false;
		$next_schedule =  isset($_POST['next_schedule'])?$_POST['next_schedule']: false;
		$next_schedule_time =  isset($_POST['next_schedule_time'])?$_POST['next_schedule_time']: false;
		$ref_customer =  isset($_POST['ref_customer'])?$_POST['ref_customer']: false;
		$ref_customer_code =  isset($_POST['ref_customer_code'])?$_POST['ref_customer_code']: false;
		$note =  isset($_POST['note'])?$_POST['note']: false;
		$code_number =  isset($_POST['code_number'])?$_POST['code_number']: false;
		$customer_fullname =  isset($_POST['customer_fullname'])?$_POST['customer_fullname']: false;
		$diagnose =  isset($_POST['diagnose'])?$_POST['diagnose']: false;
		$diagnose_doctor =  isset($_POST['diagnose_doctor'])?$_POST['diagnose_doctor']: false;
		$treatment =  isset($_POST['treatment'])?$_POST['treatment']: false;
		$treatment_doctor =  isset($_POST['treatment_doctor'])?$_POST['treatment_doctor']: false;
		$no_treatment =  isset($_POST['no_treatment'])?$_POST['no_treatment']: false;
		$no_treatment_doctor =  isset($_POST[''])?$_POST['no_treatment_doctor']: false;
		$partner =  isset($_POST['partner'])?$_POST['partner']: false;
		if ($id) {
			echo AfterTreatmentNote::model()->updateNote($id, $service_code, $cs_time, $feedback, $quality, $appointment, $next_schedule, $next_schedule_time, $ref_customer, $ref_customer_code, $note, $code_number, $customer_fullname, $diagnose, $diagnose_doctor, $treatment, $treatment_doctor, $no_treatment, $no_treatment_doctor, $partner);
		} else {
			echo -1;
		}
	}

	public function actionSearchTreatment() {
		$data = array();
		$start_time = isset($_POST['start_time'])?$_POST['start_time']: false;
		$end_time = isset($_POST['end_time'])?$_POST['end_time']: false;
		$title = 'Khách hàng sau điều trị từ '.$start_time.' đến '.$end_time;
		if ($start_time && $end_time) {
			$data = AfterTreatmentNote::model()->findAll(array('select' => '*','condition' => ' date(`create_date`) between \''.$start_time.'\' AND \''.$end_time.'\''));
		}
		$this->renderPartial('detail_treatment', array('cs' => $data, 'title' => $title));
	}

	public function actionSumarize() {
		$start_time = isset($_POST['start_time'])?$_POST['start_time']: false;
		$end_time = isset($_POST['end_time'])?$_POST['end_time']: false;

		$count_cs = $count_treatment = $count_customer = $count_partner = array();

		if ($start_time && $end_time) {
			$model = new AfterTreatmentNote;
			$count_cs = Yii::app()->db->createCommand()
				->select('quality, count(quality) as total')
				->from('after_treatment_note')
				->where('after_treatment_note.quality is not null')
				->andWhere('after_treatment_note.quality <> \'\'')
				->andWhere('after_treatment_note.create_date between \''.$start_time.'\' and \''.$end_time
					.'\'')
				->group('after_treatment_note.quality')
				->queryAll();
			$count_treatment = Yii::app()->db->createCommand()
				->select('appointment, count(appointment) as total')
				->from('after_treatment_note')
				->where('after_treatment_note.appointment is not null')
				->andWhere('after_treatment_note.appointment <> \'\'')
				->andWhere('after_treatment_note.create_date between \''.$start_time.'\' and \''.$end_time
					.'\'')
				->group('after_treatment_note.appointment')
				->queryAll();
			$count_customer = Yii::app()->db->createCommand()
				->select('service_code, count(service_code) as total')
				->from('after_treatment_note')
				->where('after_treatment_note.service_code is not null')
				->andWhere('after_treatment_note.service_code <> \'\'')
				->andWhere('after_treatment_note.create_date between \''.$start_time.'\' and \''.$end_time
					.'\'')
				->group('after_treatment_note.service_code')
				->queryAll();
			$partner_list = Partner::model()->findAllByAttributes(array('status' => 1));
			foreach ($partner_list as $key => $value) {
				$count = Yii::app()->db->createCommand()
					->select('count(*)')
					->from('after_treatment_note')
					->where('after_treatment_note.partner like \'%'.$value['id'].'%\'')
					->andWhere('after_treatment_note.create_date between \''.$start_time.'\' and \''.$end_time
						.'\'')
					->queryScalar();
				$count_partner[] = array('code' => $value['code'], 'name' => $value['name'], 'count' => $count);	
			}
			
		}
		$this->renderPartial('sumarize_treatment', array('count_cs' => $count_cs, 'count_treatment' => $count_treatment, 'count_customer' => $count_customer, 'count_partner' => $count_partner));
	}

}