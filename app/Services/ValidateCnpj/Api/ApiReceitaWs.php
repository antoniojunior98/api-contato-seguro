<?php

namespace App\Services\ValidateCnpj\Api;

use App\Services\ValidateCnpj\Api\Interface\ApiCnpjInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiReceitaWs implements ApiCnpjInterface 
{
    public function __construct () {

    }

    public function request($params)
    {
        try{
            $method = env('HTTP_METHOD_RECEITAWS', 'GET');
            $url = env('URL_API_RECEITAWS', 'https://receitaws.com.br/v1/cnpj/');

            $client = new Client();
            $response = $client->request($method, $url.$params);
            $body = json_decode($response->getBody());
            
            return $this->response($body);
        } catch (\Exception $e) {
            Log::info("[ValidateCnpj]ApiReceitaWs: {$e->getMessage()}");
            return [
                'status' => 429,
                'error' => 'request limit exceeded'
            ];
        }
    }

    public function response(Object $body)
    {
        return [
            "situation" => $body->situacao,
            "name" => $body->nome,
            "fantasy" => $body->fantasia,
            "size" => $body->porte,
            "opening" => $body->abertura,
            "main_activity" => $body->atividade_principal,
            "secondary_activity" => $body->atividades_secundarias,
            "status" => 200,
        ];
    }
}
