<?php

require_once("encrypt.php");
require_once("decrypt.php");

/*
 * Tutorial
 * https://riptutorial.com/php/example/25499/symmetric-encryption-and-decryption-of-large-files-with-openssl
 */

$fileName = __DIR__.'/manual.pdf';

$extensao = substr($fileName, -3);
$arquivo  = explode(".", $fileName);

$key = 'key123456789';

$nameFileEncrypt = $arquivo[0].'_encrypt_.'.$extensao;
encryptFile($fileName, $key, $nameFileEncrypt);

$nameFileDecrypt = $arquivo[0].'_decrypt_.'.$extensao;
decryptFile($nameFileEncrypt, $key, $nameFileDecrypt);


//decryptFile(__DIR__ . '/file_enc.txt', $key, $fileName . '_novo.dec');




/* ----------------------------------------
 *
$fileName = __DIR__.'/testfile.txt';
$key = 'my secret key';
file_put_contents($fileName, 'Hello World, here I am.');
encryptFile($fileName, $key, $fileName . '.enc');
decryptFile($fileName . '.enc', $key, $fileName . '.dec');
*
* ---------------------------------------- */