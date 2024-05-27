<?php

namespace Desafio\Picpay\Controllers;

use Desafio\Picpay\Lib\Web\Http\Request;
use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;
use Desafio\Picpay\Service\BankAccountService;
use Desafio\Picpay\Service\UserService;

class BankAccountController
{
    private BankAccountService $bankAccountService;
    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    public function create(string $request): string
    {
        $body = json_decode($request, true);
        $result = $this->bankAccountService->create($body);

        if(!$result[0]){
            return Response::status($result['status'])->errorJson( $result[1]);
        }
        return Response::status(Code::CREATED)->json(['message' => $result[1]]);
    }

    public function findAllAccounts(string $request): string
    {
        $accounts = $this->bankAccountService->findAllAccounts();
        return Response::status(Code::OK)->json($accounts);
    }

    public function findOneAccount(string $request): string
    {
        $id = Request::getParam("id");
        $accounts = $this->bankAccountService->findOneAccount($id);
        return Response::status(Code::OK)->json($accounts);
    }

    public function updateAccount(string $request): string
    {
        $id = Request::getParam("id");
        $body = json_decode($request, true);
        list($success, $message) = $this->bankAccountService->updateAccount($id, $body);

        if(!$success) return Response::status(400)->errorJson($message);

        return Response::status(Code::OK)->json($message);
    }

}
