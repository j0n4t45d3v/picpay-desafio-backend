<?php

namespace Desafio\Picpay\Factory;

use Desafio\Picpay\Controllers\UserController;
use Desafio\Picpay\Repositories\Implementations\UserRepository;
use Desafio\Picpay\Service\UserService;

trait UserControllerFactory
{
    public function createUserController(): UserController
    {
        $userService = $this->createUserService();
        return new UserController($userService);
    }

    public function createUserService(): UserService
    {
        $userRepository = new UserRepository;
        return new UserService($userRepository);
    }
}
