<?php

namespace App\Services\ValidateCnpj\Api;

use App\Services\ValidateCnpj\Api\Interface\ApiCnpjInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiCnpjWs implements ApiCnpjInterface 
{
    public function __construct () {

    }

    public function request($params)
    {
        try{
            $method = env('HTTP_METHOD_CNPJWS', 'GET');
            $url = env('URL_API_CNPJWS', 'https://publica.cnpj.ws/cnpj/');
            
            $client = new Client();
            $response = $client->request($method, $url.$params);
            $body = json_decode($response->getBody());
            
            return $this->response($body);
        } catch (\Exception $e) {
            Log::info("[ValidateCnpj]ApiCnpjWs: {$e->getMessage()}");
            return [
                'status' => 429,
                'error' => 'request limit exceeded'
            ];
        }
    }

    public function response(Object $body)
    {     
        $main_activity = [];
        foreach(array($body->estabelecimento->atividade_principal) as $activity){
            array_push($main_activity, [
                'text' => $activity->descricao
            ]);
        }
        $secondary_activity = [];
        foreach($body->estabelecimento->atividades_secundarias as $sActivity){
            array_push($secondary_activity, [
                'text' => $sActivity->descricao
            ]);
        }
        
        
        return [
            "situation" => $body->estabelecimento->situacao_cadastral,
            "name" => $body->razao_social,
            "fantasy" => $body->estabelecimento->nome_fantasia,
            "size" => $body->porte->descricao,
            "opening" => $body->estabelecimento->data_inicio_atividade,
            "main_activity" => $main_activity,
            "secondary_activity" => $secondary_activity,
            "status" => 200,
        ];
    }
}
