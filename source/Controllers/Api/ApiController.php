<?php

namespace Source\Controllers\Api;

class ApiController
{

    public static function getDetails($request)
    {
        return [
            'nome' => 'API - Address',
            'versao' => '1.0.0',
            'autor' => 'Felipe Nascimento Alves',
            'email' => 'flpnascimento45@gmail.com',
        ];
    }
}
