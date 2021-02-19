<?php

require_once("Model\Encryption.php");


use Model\Encryption;


$key  = 'lZTp66cwoL9cx2EYJb2FlxzagqJBbC';
$file = __DIR__.'/manual.pdf';


$crypt = new Encryption;

$crypt->getKey($key);
$crypt->loadFile($file);
$crypt->encryptFile(__DIR__.'/Temp/manual_criptografado.pdf');

