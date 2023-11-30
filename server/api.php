<?php 
// Do not use this key, Generate one. This one is just to show an example
$publicKey = "-----BEGIN PUBLIC KEY-----
MFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAEuRJWbO/3Bl8pfvxAxguDhUrJw9cx3N1z
AHe7nsj+gyyKvE/B9G2cypUG0Kx5+YX2ZNEPiOal4F+jDdhh4SMA1g==
-----END PUBLIC KEY-----";


// Function to verify the signature
function verifySignature($data, $receivedSignature, $publicKey)
{
    // Base64 decode the received signature
    $decodedSignature = base64_decode($receivedSignature);

    // Verify the signature using openssl_verify
    $result = openssl_verify($data, $decodedSignature, $publicKey, OPENSSL_ALGO_SHA256);

    return $result === 1; // Return true if the signature is valid
}

// Get the raw POST data
$postData = file_get_contents("php://input");

// Get the received signature from the headers
$receivedSignature = isset($_SERVER['HTTP_SIGNATURE']) ? $_SERVER['HTTP_SIGNATURE'] : '';

// Verify the signature
if (verifySignature($postData, $receivedSignature, $publicKey)) {
    // Signature is valid, process the data

    // Decode JSON data
    $decodedData = json_decode($postData, true);

    // You should check if the nonce is valid to avoid replay attacks. 
    // It should be greater than the previous one (this check is enough since we used microtime(true)*1000 as nonce)
    // get the previous one from database or a file and compare it with the current one
    // store the current one if correct
    // echo $decodedData['nonce'];

    include('nonceAPI.php');
    //echo "Your Integer Value: " . $nonceAPI;

    $myNonce = $decodedData['nonce'];

    if($myNonce <= $nonceAPI) {
      $response = array('status' => 'error', 'message' => 'Nonce too low');
      echo json_encode($response);
      exit();
    }

    $pathto = '';
    $res = file_put_contents($pathto.'nonceAPI.php', "<?php\n\$nonceAPI = ".$myNonce.";\n?>", LOCK_EX );

    if($res === false)
    {
      $response = array('status' => 'error', 'message' => 'Nonce not saved');
      echo json_encode($response);
      exit();
    }

    // Your processing logic goes here
    // For example, you can access data using $decodedData['param1'], $decodedData['param2']
    // It's likely a good idea to include an other file if your API lgic code is not super small
    // var_dump($decodedData);

    // Respond with a success message
    $response = array('status' => 'success', 'message' => 'Data processed successfully');
    echo json_encode($response);
} else {
    // Signature is invalid, respond with an error
    $response = array('status' => 'error', 'message' => 'Invalid signature');
    echo json_encode($response);
}

?>
