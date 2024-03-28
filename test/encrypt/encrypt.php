<?php

    $key = 'hrd@CSCRO6';

    // Plain text to be encrypted
    $plaintext = json_decode(file_get_contents('php://input'), true)['data'];

    // Initialization vector (IV) - 16 bytes for AES-128, 24 bytes for AES-192, 32 bytes for AES-256
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encrypt the plaintext using AES-256-CBC algorithm
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

    // Encrypted data (ciphertext) and IV should be stored securely for decryption

    // echo "Encrypted Text: " . base64_encode($ciphertext) . "<br>";
    // echo "Initialization Vector (IV): " . base64_encode($iv) . "<br>";
    $base64encoded = base64_encode($ciphertext) ."::". base64_encode($iv);
    echo $base64encoded;
?>
