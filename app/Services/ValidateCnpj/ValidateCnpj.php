<?php

namespace App\Services\ValidateCnpj;

use App\Services\ValidateCnpj\Api\Interface\ApiCnpjInterface;
use App\Services\ValidateCnpj\Api\{ ApiReceitaWs, ApiCnpjWs, ApiCnpja };

class ValidateCnpj
{
    protected $api = [
        'ApiReceitaWs',
        'ApiCnpjWs',
        'ApiCnpja'
    ];

    public function checkCnpj(String $cnpj)
    {
        foreach($this->api as $api){ 
            $class = $this->findApi($api);
            $response = $this->response($class, $cnpj);
            if($response && $response['status'] == 200){
                break;
            }
        }

        return $response;
    }

    private function findApi($api)
    {
        switch ($api) {
            case 'ApiCnpjWs':
                $class = new ApiCnpjWs();
                break;
            case 'ApiCnpja':
                $class = new ApiCnpja();
                break;
            default:
                $class = new ApiReceitaWs();
                break;
        }
        return $class;
    }

    public function response(ApiCnpjInterface $api, String $cnpj)
    {
        return $api->request($cnpj);
    }
}