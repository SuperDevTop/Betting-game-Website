<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getEncryptionValue($value)
    {     
        $ciphering = "AES-128-CTR";
        $encryption_iv = '1234567891011121';
        $encryption_key = "GeeksforGeeks";
        $encryption = openssl_encrypt($value, $ciphering,
                    $encryption_key, 0, $encryption_iv);
        
        return $encryption==""?0:$encryption;
    }
    public function getDecryptionValue($value)
    {
        $ciphering = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $decryption_key = "GeeksforGeeks";
        $decryption=openssl_decrypt ($value, $ciphering, 
                $decryption_key, 0, $decryption_iv);
          
        return $decryption==""?0:$decryption;
    }
}
