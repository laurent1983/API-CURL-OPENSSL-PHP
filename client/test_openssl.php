<?php 

require_once('includes/send_API_openssl.php');

$myData = array(
  'fct' => 'getTemp',              
  'city' => 'Lyon'  
);

send_DATA_API($myData);


?>
