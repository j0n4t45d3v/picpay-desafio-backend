<?php

namespace Desafio\Picpay;
require_once(__DIR__ . "/../vendor/autoload.php");

use Desafio\Picpay\Factory\{UserControllerFactory, IndexControllerFactory};
use Desafio\Picpay\Lib\Web\Router;

$factories = new class {
    use UserControllerFactory;
    use IndexControllerFactory;
};

$indexController = $factories->createIndexController();
$userController = $factories->createUserController();

$router = new Router("/api");

$router->get("v1", [$indexController, 'index']);
$router->get("v1/users", [$userController, 'findAllUsers']);
$router->get("v1/users/id", [$userController, 'findOneUser']);
$router->post("v1/users/register", [$userController, 'register']);

$router->runRoutes();
