<?php

namespace Desafio\Picpay\Controllers;

use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;

class Controller
{
    public function index($request): string
    {
        $response = [
            "name" => "Minimums pic pay",
            "description" => "Minimal pic-pay API that simulates pic-pay bank transactions",
            "version" => "1.0.0-BETA"
        ];
        return Response::status(Code::OK)->json($response);
    }
}