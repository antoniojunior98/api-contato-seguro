<?php

namespace App\Services\ValidateCnpj\Api;

use App\Services\ValidateCnpj\Api\Interface\ApiCnpjInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiCnpja implements ApiCnpjInterface 
{
    public function __construct () {

    }

    public function request($params)
    {
        try{
            $method = env('HTTP_METHOD_CNPJA', 'GET');
            $url = env('URL_API_CNPJA', 'https://api.cnpja.com/office/');
            $key = env('KEY_API_CNPJA', '274d674d-7bc4-4132-b1b8-8dadd2ffff19-a8e563c5-a353-48a8-802d-bcfa008c5380');
            
            $client = new Client();
            $response = $client->request($method, $url.$params, [
                'headers' => [
                    'Authorization' => $key
                    ]
                ]);
            $body = json_decode($response->getBody());
             
            return $this->response($body);
        } catch (\Exception $e) {
            Log::info("[ValidateCnpj]ApiCnpJa: {$e->getMessage()}");
            return [
                'status' => 429,
                'error' => 'request limit exceeded'
            ];
        }
    }

    public function response(Object $body)
    {     
        return [
            "situation" => $body->status->text,
            "name" => $body->company->name,
            "fantasy" => $body->alias,
            "size" => $body->company->size->text,
            "opening" => $body->founded,
            "main_activity" => $body->mainActivity,
            "secondary_activity" => $body->sideActivities,
            "status" => 200,
        ];
    }
}
