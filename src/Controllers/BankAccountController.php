<?php

namespace Desafio\Picpay\Controllers;

use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;
use Desafio\Picpay\Service\UserService;

class BankAccountController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(string $request): string
    {
//        $body = json_decode($request, true);
//        $result = $this->userService->register($body);
//        $bodyResponse = [
//            'message' => $result[1],
//            'status' => Code::CREATED->value
//        ];
//        if(!$result[0]){
//            $bodyResponse['error'] = $bodyResponse['message'];
//            unset($bodyResponse['message']);
//            return Response::status(Code::BAD_REQUEST)->json($bodyResponse);
//        }
        return Response::status(Code::CREATED)->json(["message" => "test"]);
    }

}
