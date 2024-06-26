<?php

namespace Desafio\Picpay\Controllers;

use Desafio\Picpay\Lib\Web\Http\Request;
use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;
use Desafio\Picpay\Service\UserService;

class UserController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(string $request): string
    {
        $body = json_decode($request, true);
        $result = $this->userService->register($body);
        $bodyResponse = [
            'message' => $result[1],
            'status' => Code::CREATED->value
        ];
        if(!$result[0]){
            $bodyResponse['error'] = $bodyResponse['message'];
            unset($bodyResponse['message']);
            return Response::status(Code::BAD_REQUEST)->json($bodyResponse);
        }
        return Response::status(Code::CREATED)->json($bodyResponse);
    }

    public function findAllUsers(string $request): string
    {
        $users = $this->userService->findAllUsers();
        return Response::status(Code::OK)->json($users);
    }

    public function findOneUser(string $request): string
    {
        $id = Request::getParam("id");
        $users = $this->userService->findOneUser($id);
        if(!$users) {
            return Response::status(Code::BAD_REQUEST)->json(['message' => "Error In Find User"]);
        }
        return Response::status(Code::OK)->json($users);
    }

}
