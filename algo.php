<?php
namespace algo;

class process
{
    private $key;
    private $iv;

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setIV($iv)
    {
        $this->iv = $iv;
    }

    public function process($plaintext)
    {
        $ciphertext = '';
        $key_length = strlen($this->key);
        for ($i = 0; $i < strlen($plaintext); $i++)
        {
            $ciphertext .= chr(ord($plaintext[$i]) ^ ord($this->key[$i % $key_length]));
        }
        return $ciphertext;
    }
}
?>
