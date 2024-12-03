<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;


class Operacoes
{
    public static function decryptId($value)
    {
        try {
            $value = Crypt::decrypt($value); //desencriptação do id
        } catch (DecryptException $e) {
            return null; 
        }

        return $value;
    }
}