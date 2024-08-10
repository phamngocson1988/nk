<?php

set_time_limit(999999999);

$uploadedStatus = 2;
$bien = "";
if (isset($_POST["submit"])){
if (isset($_FILES["file"])){

	//if there was an error uploading the file
	if ($_FILES["file"]["error"] > 0) {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}else{
		if (file_exists($_FILES["file"]["name"])){
			unlink($_FILES["file"]["name"]);
		}
		move_uploaded_file($_FILES["file"]["tmp_name"],  Yii::getPathOfAlias('webroot').'/protected/uploads/excel/'.$_FILES['file']['name']);

		switch ($_SERVER['SERVER_NAME']) {
		  case 'hhh.nhakhoa2000.com':
		    $connect = mysqli_connect(Yii::app()->params->db_hhh['domain'], Yii::app()->params->db_hhh['username'], Yii::app()->params->db_hhh['password'], Yii::app()->params->db_hhh['db_name']);  
		    break;
		  case 'ngt.nhakhoa2000.com':
		    $connect = mysqli_connect(Yii::app()->params->db_ngt['domain'], Yii::app()->params->db_ngt['username'], Yii::app()->params->db_ngt['password'], Yii::app()->params->db_ngt['db_name']);
		    break;
		  default:
		    echo "Domain not found";
		    exit();
		    break;
		}

		$connect->set_charset("utf8");

		include("PHPExcel/IOFactory.php");   
		
		$html="<table border='1'>"; 

		$objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot').'/protected/uploads/excel/'.$_FILES['file']['name']);
		//echo 'aaaa';
		//exit;
		//$CsService = new CsService;
        $uploadedStatus = 1;
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {  


    $highestRow = $worksheet->getHighestRow();  

    for ($row=2; $row<=$highestRow; $row++) {  

        $html.="<tr>";      

        $code = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());

		if(!$code){
			$code = null;
		}  
        
        $service = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
        if(!$service){
			$service = null;
		}

		$price = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
        if(!$price){
			$price = null;
		}

        $service_type = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
        if(!$service_type){
			$service_type = null; 
		}
		
		$service_type_arr =CsServiceType::model()->findAll("code = '".trim($service_type)."'");
        $service_arr = CsService::model()->findAll("code = '".trim($code)."'");		
		if(count($service_type_arr) > 0 && count($service_arr) <= 0){ 
			$sql = "INSERT INTO cs_service(id_service_type ,code, name, price) VALUES ('".trim($service_type_arr[0]['id'])."', '".trim($code)."', '".trim($service)."', '".trim($price)."')";  
			mysqli_query($connect, $sql);
		}else{
			$bien .= '<tr><td>'.$code."</td><td>".$service."</td><td>".$price."</td><td>".$service_type.'</td></tr>';
		    $uploadedStatus = 0;
		}      
    }  
} 

//echo $bien;


}
	}else{
	echo "No file selected <br />";
	}
}

?>

<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:10px;">

<form action="" method="post" enctype="multipart/form-data">

<tr><td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
Import Excel file into Sevice</td></tr>

<tr><td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Data Uploading System</td></tr>

<tr>

<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>

<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>

</tr>

<tr>

<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>

<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>

</tr>

</table>
 




</form>
<?php if($bien != ""){?>
<div class="container">
  <h2>Các dòng nhập không được</h2>         
  <table class="table table-hover">
    <tbody>
        <?php echo $bien;?>
    </tbody>
  </table>
</div>
<?php }?>

<script type="text/javascript">
  

$(document).ready(function(){ 
<?php 
if($uploadedStatus==1){?>
	alert('Thành công ! Xem lại dữ liệu trước khi Input thêm.');
<?php }else if($uploadedStatus==0){?>
    alert('Chỉ thêm được 1 số dòng ! Xem các dữ liệu chưa input được dưới đây.');
<?php }?>
});

</script>
<script type="text/javascript">
  

$(document).ready(function(){ 
	$('.cal-loading').fadeOut('slow');
	$('#mn_nav').css("background-color", "#f1f5f7");
});

</script>