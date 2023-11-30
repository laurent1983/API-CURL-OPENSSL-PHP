# API-CURL-OPENSSL-PHP
API calls between 2 webservers in PHP using OPENSSL electronic signature for security

# Generate Keys
Generate new keys using the script generate_keys_openssl.php

Private key is for client to sign message
Public key is for server to verify the signature 

Add Private key to /client/send_API_openssl.php
Add Public key to /server/api.php

Do not disclose those keys, otherwise your security is compromised

# nonceAPI.php
Add read/write rights for this file so api.php can update the nonce
=> You can read/write this value using a database if you prefer

# call the API

an exemple of call in /client/test_openssl.php

# Logic of the API

You need to add the code of the API function in /server/api.php
