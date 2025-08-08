<?php

use App\Business\Services\EncryptorService;

test('Prueba de encryptador, que encripte, sea distinto y desencripte y sea igual.', function () {
    
    $key = 'unaclavesecreta';

    $encryptor = new EncryptorService($key);

    $originalString = 'una cadena de texto';

    $encryptedString = $encryptor->encrypt($originalString);

    expect($encryptedString)->not->toBe($originalString);

    $decryptString = $encryptor->decrypt($encryptedString);

    expect($decryptString)->toBe($originalString);
});

test ("Excepcion cuando la Key sea distinta para desencriptar", function(){

    $key1 = "unaclavesecreta";
    $key2 = 'unaclaveMal';

    $encryptor1 = new EncryptorService($key1);
    $encryptor2 = new EncryptorService($key2);

    $encryptedString = $encryptor1->encrypt('Prueba');

    $this->expectException(Exception::class);
    $encryptor2->decrypt($encryptedString);


});