<?php

set_time_limit(999999999);

$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {

//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else {
if (file_exists($_FILES["file"]["name"])) {
unlink($_FILES["file"]["name"]);
}

move_uploaded_file($_FILES["file"]["tmp_name"],  Yii::getPathOfAlias('webroot').'/protected/uploads/excel/'.$_FILES['file']['name']);

switch ($_SERVER['SERVER_NAME']) {
  case 'hhh.nhakhoa2000.com':
    $connect = mysqli_connect(Yii::app()->params->db_hhh['domain'], Yii::app()->params->db_hhh['username'], Yii::app()->params->db_hhh['password'], Yii::app()->params->db_hhh['db_name']);  
    break;
  case 'ngt.nhakhoa2000.com':
    $connect = mysqli_connect(Yii::app()->params->db_ngt['domain'], Yii::app()->params->db_ngt['username'], Yii::app()->params->db_ngt['password'], Yii::app()->params->db_ngt['db_name']);
  default:
    echo "Domain not found";
    exit();
    break;
}

$connect->set_charset("utf8");

include ("PHPExcel/IOFactory.php");  

$html="<table border='1'>"; 

$objPHPExcel = PHPExcel_IOFactory::load(Yii::getPathOfAlias('webroot').'/protected/uploads/excel/'.$_FILES['file']['name']);

$customer = new Customer;

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {  

      $highestRow = $worksheet->getHighestRow();  
      for ($row=2; $row<=$highestRow; $row++) {  

          $html.="<tr>";      

          $code_service = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
          $name_en      = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());

          if ($code_service) {

            $sql="UPDATE cs_service SET name_en='$name_en' WHERE code='$code_service'";
           mysqli_query($connect, $sql);  

          }      
      }  

 } 



$uploadedStatus = 1;
}
} else {
echo "No file selected <br />";
}
}

?>

<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:10px;">

<form action="" method="post" enctype="multipart/form-data">

<tr><td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
Import Excel file into name service en</td></tr>

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

<?php if($uploadedStatus==1){

$this->redirect('admin');

}?>



</form>



<script type="text/javascript">
  

$(document).ready(function()
{ 

  $('.cal-loading').fadeOut('slow');  

});

</script>