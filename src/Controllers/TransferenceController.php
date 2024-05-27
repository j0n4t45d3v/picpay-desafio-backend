<?php

namespace Desafio\Picpay\Controllers;

use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Service\BankAccountService;
use Desafio\Picpay\Service\TransferenceService;
use Desafio\Picpay\Service\UserService;

class TransferenceController
{
    private TransferenceService $service;

    public function __construct(TransferenceService $service)
    {
        $this->service = $service;
    }


    public function createTransference(string $request): string
    {
        $body = json_decode($request, true);
        list($success, $result) = $this->service->createTransaction($body);

        if(!$success) return Response::status(400)->errorJson($result);

        return Response::status(201)->json($result);
    }
}
