<?php 
// $postData must be an array of data, you can use one parameter for the fct name of the API and some other for parameter :
/* 
$postData = array(
    'fct' => 'getTemp',              
    'city' => 'Lyon'  
); 
*/
function send_DATA_API($postData) {

// DO not use this key, Generate one. This one is just to show an example
$privateKey = "-----BEGIN EC PRIVATE KEY-----
MHQCAQEEIBYEoEQVQnVPX5y9XNIbh+cxigdyh5BX8ksr2BqEExJ9oAcGBSuBBAAK
oUQDQgAEuRJWbO/3Bl8pfvxAxguDhUrJw9cx3N1zAHe7nsj+gyyKvE/B9G2cypUG
0Kx5+YX2ZNEPiOal4F+jDdhh4SMA1g==
-----END EC PRIVATE KEY-----";


// always use a nonce to avoid replay attacks
$nonce = intval(microtime(true)*1000);
$postData['nonce'] = intval(microtime(true)*1000);

// Convert the data to a JSON string 
$jsonData = json_encode($postData);

// Sign the data using openssl_sign
openssl_sign($jsonData, $signature, $privateKey, OPENSSL_ALGO_SHA256);

// Base64 encode the signature
$base64Signature = base64_encode($signature);

// URL of the remote server
$remoteUrl = 'https://exemple.com/api.php';

// Initialize cURL session
$ch = curl_init($remoteUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// Set headers, including the signature
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Signature: ' . $base64Signature
));

// Execute cURL session and get the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Process the response
echo $response;

}

?>
