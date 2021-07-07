<?php

namespace App\Helper;

use App\Mail\SendMail;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApiCall {


    public static function get($action, $param = []) {
        return self::callApi('GET', $action, $param);
    }

    public static function post($action, $param = []) {
        return self::callApi('POST', $action, $param);
    }

    public static function callApi($method, $url, $param = []) {
        $client = new Client(['verify' => false]);
        $autharizedUser = session()->get('authenticated');
        $token = $autharizedUser['api_token'] ?? null;
        $uuid = $autharizedUser['uuid'] ?? null;
        $headers = [
            'uuid' => $uuid,
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'content-type' => 'application/json',
        ];
        $options = [
            'headers' => $headers,
            'body' => json_encode($param),
            'exceptions' => false,
        ];
        $portalApi = trim(env('PORTAL_HOST'), '/') . '/' . trim(env('API_VERSION'), '/') . '/' . trim($url, '/');
        try {
            $response = $client->{$method}($portalApi, $options);
            $statusCode = $response->getStatusCode();
            $response = json_decode($response->getBody(), true);
            $getMessage = $response['message'];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            $response = json_decode($responseBodyAsString, true);
            $getMessage = $response['message'];
        }
        if ($statusCode == '422') {
            $error = reset($response['data']);
            $getMessage = $error ?? $response['message'];
        }
        $response['message'] = $getMessage;
        $response['code'] = $statusCode;
        return $response;
    }

}
