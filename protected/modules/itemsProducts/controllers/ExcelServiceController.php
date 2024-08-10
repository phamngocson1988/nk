<?php

class ExcelServiceController extends Controller
{
	public $layout='/layouts/main_sup';

	public function actionView(){
		$this->render('importExcelService');
		//$this->render('import_excel_service');
	}
	public function actionView2(){
		$this->render('import_excel_service_type');
	}

	public function actionDvEn(){
		$this->render('import_excel_service_name_en');
	}

	public function actionGetImport(){
		if(isset($_FILES['upExcel']['name']) && $_FILES['upExcel']['name'] != "") {
			$allowedExtensions = array("xls","xlsx");
			$ext = pathinfo($_FILES['upExcel']['name'], PATHINFO_EXTENSION);
			if(in_array($ext, $allowedExtensions)) {
				$file_size = $_FILES['upExcel']['size']/1024;
				if($file_size < 1500){
					require(Yii::app()->basePath.'/extensions/PHPExcel/Classes/PHPExcel.php');
					$inputFileName = $_FILES['upExcel']['tmp_name'];
                    //  Tiến hành đọc file excel
					$objFile = PHPExcel_IOFactory::identify($inputFileName);
					$objData = PHPExcel_IOFactory::createReader($objFile);
                    //Chỉ đọc dữ liệu
					$objData->setReadDataOnly(true);

                    // Load dữ liệu sang dạng đối tượng
					$objPHPExcel = $objData->load($inputFileName);

                    // Lấy sheet hiện tại
					$sheet = $objPHPExcel->setActiveSheetIndex(0);

                    //Lấy ra số dòng cuối cùng
					$Totalrow = $sheet->getHighestRow();
					if($Totalrow > 100){
						echo json_encode(array("status"=>"fail","message"=>"ổng số upload (".$Totalrow.") không lớn hơn 100 ."));
						exit;
					}

                    //Lấy ra tên cột cuối cùng
					$LastColumn = $sheet->getHighestColumn();

                    // Khai báo mảng $rowData chứa dữ liệu

                    //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
					$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

                    //Tạo mảng chứa dữ liệu
					$data = array();
                                        //Tiến hành lặp qua từng ô dữ liệu
                    //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
					for ($i = 2; $i <= $Totalrow; $i++) {

                        //----Lặp cột
						for ($j = 0; $j < $TotalCol; $j++) {

                            // Tiến hành lấy giá trị của từng ô đổ vào mảng
							$data[$i - 2][$j] = (string)$sheet->getCellByColumnAndRow($j, $i)->getValue();

						}

					}
                    //luu để thêm
                    //Yii::app()->user->setState('data_import', $data);
					//move_uploaded_file($_FILES["upExcel"]["tmp_name"],  'upload/excel/service/'.date("Y-m-d-G-i-s")."-".$_FILES['upExcel']['name']);
					$dataError = array();
					$CsServiceType = new CsServiceType();
					$CsService = new CsService();

					foreach ($data as $key => $value) {
						$dataSuccess = array();

						$row = $CsServiceType->searchId(trim($value[7]));
						$id = $row["id"];

						if ($id == 0) {
							array_push($value,"Nhóm dịch vụ không tồn tại");
							array_push($dataError,$value);
						}else if ($value[4] != "VND" && $value[4] != "USD") {
							array_push($value,"Loại tiền phải là VND hoặc USD");
							array_push($dataError,$value);
						} else if (trim($value[0]) == "") {
							array_push($value,"MaDV không có");
							array_push($dataError,$value);
						} else if (trim($value[1]) == "") {
							array_push($value,"Tên dịch vụ không có");
							array_push($dataError,$value);
						} else{
							if ($value[4] == "VND") {
								$flag_price = 1;
							} else {
								$flag_price = 2;
							}
							
							$dataSuccess["code"] = $value[0];
							$dataSuccess["name"] = $value[1];
							$dataSuccess["name_en"] = $value[2];
							$dataSuccess["price"] = $value[3];
							$dataSuccess["flag_price"] = $flag_price;
							$dataSuccess["priority_pay"] = $value[5];
							$dataSuccess["description"] = $value[6];
							$dataSuccess["id_service_type"] = $id;
							$kq = $CsService->AddService($dataSuccess);
						}
					}
					echo json_encode(array("status"=>"successful","data"=>$dataError));
					exit;
				}else{
					echo json_encode(array("status"=>"fail","message"=>"Kích thước file không được lớn hơn 1.5MB."));
					exit;
				}
			}else{
				echo json_encode(array("status"=>"fail","message"=>"Định dạng file không hợp lệ."));
				exit;
			}
		}else{
			echo json_encode(array("status"=>"fail","message"=>"Không tìm thấy file upload."));
			exit;
		}
	}
}