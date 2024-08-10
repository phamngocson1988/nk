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

          if ($customer->findAllByAttributes(array('code_number'=>$code_number))) {
            continue;
          }

          $lastname = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue()); 

          $firstname = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());

          $fullname = trim($lastname).' '.trim($firstname); 

          if (!$fullname) {
          	continue;
          }        

          $gender = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue()) == "F" ? 1 : 0;  

          $cellByColumn5 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue()); 

          if ($cellByColumn5) {   

            $birthdate = date('Y-m-d',strtotime($cellByColumn5));

          } else{

            $birthdate = null;

          }  

          $address = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());          

          if (!$address) {

            $address = null;

          }         

          
          $cellByColumn7 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
       
          if ($cellByColumn7) {

            $phone= $customer->getVnPhone($cellByColumn7);

          }else{

            $phone = null;

          }          
         
          $email = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());

          if (!$email) {

            $email = null;

          }    

          $cellByColumn9 = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());

          if ($cellByColumn9) {
            $createdate = date('Y-m-d H:i:s',strtotime($cellByColumn9));
          }else{
            $createdate = null;
          }  

           

        if ($email) {

          $sql = "INSERT INTO customer(code_number, code_number_old, fullname, address, phone, phone_sms, email, gender, birthdate, createdate) VALUES ('".$code_number."', '".$code_number_old."', '".$fullname."', '".$address."', '".$phone."', '".$phone."', '".$email."', '".$gender."', '".$birthdate."', '".$createdate."')";  
         mysqli_query($connect, $sql);  

        } else {

          $sql = "INSERT INTO customer(code_number, code_number_old, fullname, address, phone, phone_sms, gender, birthdate, createdate) VALUES ('".$code_number."', '".$code_number_old."', '".$fullname."', '".$address."', '".$phone."', '".$phone."', '".$gender."', '".$birthdate."', '".$createdate."')";  
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
Import Excel file into Customer</td></tr>

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