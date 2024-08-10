<?php
ini_set("date.timezone","Asia/Saigon");
print($_SERVER['REMOTE_ADDR']);

echo file_get_contents("http://221.132.39.104:8083/brandnamews.asmx?wsdl");
echo file_get_contents("http://221.132.39.111/whoami.php");
die;
