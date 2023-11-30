<?php 

// You can use RSA or EC keys

// I prefer EC keys because they are smaller and faster and i am a Bitcoin fan boy
// secp256k1 <3

// $configargs = array( 
//   "private_key_bits" => 4096, 
//   "private_key_type" => OPENSSL_KEYTYPE_RSA, 
// );

$configargs = array( 
  "curve_name" => "secp256k1", 
  "private_key_type" => OPENSSL_KEYTYPE_EC, 
);

// Create a new pair of private and public key 
$private_key_rsa = openssl_pkey_new($configargs); 

openssl_pkey_export($private_key_rsa, $privKey, NULL, $configargs);
$details = openssl_pkey_get_details($private_key_rsa); 

echo $privKey; // private key
echo $details['key']; // public key
  
  
?>
