<?php

namespace Desafio\Picpay\Lib\Web\Http;

class Request
{
    public static function getBodyJson(): string|false
    {
        $bodyRequest = self::getBody();
        if(!$bodyRequest) return false;
        return json_decode($bodyRequest);
    }

    public static function getBody(): string|false
    {
        return file_get_contents('php://input');
    }
}