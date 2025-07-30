<?php

namespace App\Business\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptorService {

    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function encrypt (string $data): string {

        return base64_encode($this->key.":".Crypt::encryptString($data)); // base64 es una funcion de laravel
    }

    public function decrypt (string $data): string {
        
        $decodeData = base64_decode($data);

        [$key, $encrypted] = explode(":", $decodeData, 2);
        // Validacion 
        if ($key !== $this->key){
            throw new \Exception('Clave Incorrecta.');
        }
        // Se envia info desencriptada
        return Crypt::decryptString($encrypted);
    }
}