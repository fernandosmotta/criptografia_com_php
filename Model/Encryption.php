<?php

/** 
 * NOTE: Class responsavel para criptografar e descriptografar de arquivos e string
 * 
 * @author  Fernando Soares
 * @url     http://www.ti-ideal.com
 * @date    2021-02-18 17:30
 */

namespace Model;

class Encryption
{
    /**
     * @const cryptMethod - O método utilizado de criptografia
     */
    const cryptMethod    = 'AES-128-CBC';
    
    /**
     * @const cryptSizeBlock - Defina o número de blocos que devem ser lidos do arquivo origem para cada pedaço.
     */
    const cryptSizeBlock = 10000;
    
    private $File;
    private $key;


    /**
     * @param string $key - A chave utilizada para a criptografia
     */
    public function getKey($key) {
        $this->key = substr(sha1($key, true), 0, 16);
    }

    /**
     * @param string $filename - Caminho do arquivo de origem que deve ser criptografado ou descriptografado
     */ 
    public function loadFile($filename) {
        $this->File = $filename;
    }


    /** 
     * Criptografa o arquivo enviado e salva o resultado em um novo arquivo
     * 
     * @param string $saveFile - Caminho onde o arquivo criptografado deve ser gravado.
     * @return string|false  Retorna o nome do arquivo que foi gravado ou FALSE se ocorrer um ERRO
     */
    public function encryptFile($saveFile)
    {
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($saveFile, 'w')) 
        {
            // Inicializa o vetor no inicio do arquivo de origem
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($this->File, 'rb')) 
            {
                while (!feof($fpIn)) 
                {
                    $plaintext  = fread($fpIn, 16 * self::cryptSizeBlock);
                    $ciphertext = openssl_encrypt($plaintext, self::cryptMethod, $this->key, OPENSSL_RAW_DATA, $iv);

                    // Usa os primeiros 16 bytes do texto cifrado como o próximo vetor de inicialização
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $saveFile;
    }


    /** 
     * Descriptografa o arquivo e salva o resultado em um novo arquivo
     * 
     * @param string $saveFile - Caminho onde o arquivo criptografado deve ser gravado.
     * @return string|false  Retorna o nome do arquivo que foi gravado ou FALSE se ocorrer um ERRO
     */
    public function decryptFile($saveFile)
    {
        $error = false;
        if ($fpOut = fopen($saveFile, 'w')) 
        {
            if ($fpIn = fopen($this->File, 'rb')) 
            {
                // Inicializa o vetor no inicio do arquivo de origem
                $iv = fread($fpIn, 16);
                while (!feof($fpIn)) 
                {
                    // é preciso ler um bloco a mais para descriptografar do que criptografar
                    $ciphertext = fread($fpIn, 16 * (self::cryptSizeBlock + 1)); 
                    $plaintext  = openssl_decrypt($ciphertext, self::cryptMethod, $this->key, OPENSSL_RAW_DATA, $iv);

                    // Usa os primeiros 16 bytes do texto cifrado como o próximo vetor de inicialização
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $plaintext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $saveFile;
    }



    /** -------------------------------------------------------------------------------
     * CRIPTOGRAFIA DE TEXTOS (STRING)
     * -------------------------------------------------------------------------------*/

    /**
     * Criptografa uma string (texto)
     * @param string $string - Texto que será criptografado
     */
    public function encryptString($string)
    {
        return openssl_encrypt($string, self::cryptMethod, $this->key, OPENSSL_RAW_DATA, $this->key);
    }


    /**
     * Descriptografa uma string (texto) que foi criptograda pelo sistema
     *  @param string $string - Texto que será descriptografado
     */
    public function decryptString($string)
    {
        return openssl_decrypt($string, self::cryptMethod, $this->key, OPENSSL_RAW_DATA, $this->key);
    }

}