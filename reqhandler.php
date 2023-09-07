<?php

// Initialize GnuPG - Make sure to update this to your corresponding setup, use the setup script as reference.
putenv("GNUPGHOME=/var/www/.gnupg");
$gpg = new gnupg();

// If using the setup script, copy/paste your public key into a directory with proper permissions. 
// Import the public key
$public_key = file_get_contents("/path/to/public-key.asc");
$info = $gpg->import($public_key);

// Check User-Agent and Authorization header
if ($_SERVER['HTTP_USER_AGENT'] == "SPECIAL-AGENT-KEY" && $_SERVER['HTTP_AUTHORIZATION'] == "SPECIAL-HEADER-KEY") {
    
    // Check POST data
    if (isset($_POST['data'])) {
        // Sanitization methods are reccomended 
      
        // Decrypt and verify the message
        $decrypted = $gpg->decryptverify($_POST['data'], $info);
        
        // Your own logic here
        echo "Decrypted data: " . $decrypted['plaintext'];
        
    } else {
        echo "No data received.";
    }

} else {
    echo "Unauthorized request.";
}

?>
