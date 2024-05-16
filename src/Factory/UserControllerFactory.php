<?php

namespace Desafio\Picpay\Factory;

use Desafio\Picpay\Controllers\UserController;
use Desafio\Picpay\Repositories\Implementations\UserRepository;
use Desafio\Picpay\Service\UserService;

trait UserControllerFactory
{
    public function createUserController(): UserController
    {
        $userRepository = new UserRepository;
        $userService = new UserService($userRepository);
        return new UserController($userService);
    }
}