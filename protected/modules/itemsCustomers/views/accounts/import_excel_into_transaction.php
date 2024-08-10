<?php

set_time_limit(999999999);

$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {

//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}else {

$file_up = Yii::getPathOfAlias('webroot').'/protected/uploads/excel/'.$_FILES['file']['name'];

if (file_exists($file_up)) {
  unlink($file_up);
}

move_uploaded_file($_FILES["file"]["tmp_name"],  $file_up);

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

include ("PHPExcel/IOFactory.php");  

$html="<table border='1'>"; 

$objPHPExcel = PHPExcel_IOFactory::load($file_up);

$customer = new Customer;

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {  


      $highestRow = $worksheet->getHighestRow();  

      for ($row=2; $row<=$highestRow; $row++) {  

          $html.="<tr>";      

          $code_number_old = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue()); 

          if (!$code_number_old) {
            $code_number_old = null;
          }  

          $code_number = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue()); 

          if (!$code_number) {
            continue;
          }

          // if (!is_numeric($code_number)) {
          //   continue;
          // }

          // if (strlen($code_number) != 10) {
          //   continue;
          // }   

          $billing_number = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue()); 

          if (!$billing_number) {

            $billing_number = null;

          } 

          $cellByColumn3 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); 

          if ($cellByColumn3) {

            // $dateTimeObject = PHPExcel_Shared_Date::ExcelToPHPObject($cellByColumn3);

            // $date = $dateTimeObject->format('Y-m-d');

            $date = date('Y-m-d',strtotime($cellByColumn3));

          } else {

            $date = null;

          }   

                       

          $tooth = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue()); 

          if (!$tooth) {

            $tooth = null;

          }

          $account_code = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());

          if (!$account_code) {

            $account_code = null;

          }

          $description = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());  

          if (!$description) {

            $description = null;

          }

          $fee = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue()); 

          if (!$fee) {

            $fee = null;

          }

          $provider_code = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue()); 

          if (!$provider_code) {

            $provider_code = null;

          }

          $payment_number = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());  

          if (!$payment_number) {

            $payment_number = null;

          }          

          $sql = "INSERT INTO transaction(code_number, code_number_old, billing_number, date, tooth, account_code, description, fee, provider_code, payment_number) VALUES ('".$code_number."', '".$code_number_old."', '".$billing_number."', '".$date."', '".$tooth."', '".$account_code."', '".$description."', '".$fee."', '".$provider_code."', '".$payment_number."')";  
         mysqli_query($connect, $sql);    

         

      }  



 } 

 
if (file_exists($file_up)) {
  unlink($file_up);
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
Import Excel file into Transaction</td></tr>

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