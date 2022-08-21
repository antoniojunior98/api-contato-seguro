<?php

namespace App\Services\ValidateCnpj\Api\Interface;

interface ApiCnpjInterface 
{
    public function request(String $params);

    public function response(Object $response);
} 