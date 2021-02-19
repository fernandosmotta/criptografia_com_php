<?php

require_once("Model\Encryption.php");


use Model\Encryption;


$key   = 'lZTp66cwoL9cx2EYJb2FlxzagqJBbC';
$text  = 'Atualização - Cliente: XXXXXXXXXXXXXXXXXXXX - pedido- XXXX';


$crypt = new Encryption;

$crypt->getKey($key);

$texto_criptografado    = $crypt->encryptString($text);
$texto_descriotografado = $crypt->decryptString($texto_criptografado);


// RESULTADO:
echo "<p><b>ORIGINAL: </b>".$text."</p><br>";
echo "<hr>";
echo "<p><b>CRIPTOGRAFADO: </b>".$texto_criptografado."</p><br>";
echo "<p><b>DESCRIPTOGRAFADO: </b>".$texto_descriotografado."</p><br>";