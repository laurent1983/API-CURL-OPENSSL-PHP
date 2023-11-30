<?php 

require_once('send_API_openssl.php');

$myData = array(
  'fct' => 'getTemp',              
  'city' => 'Lyon'  
);

send_DATA_API($myData);


?>
