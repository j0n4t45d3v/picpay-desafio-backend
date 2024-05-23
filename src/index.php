<?php

namespace Desafio\Picpay;
require_once(__DIR__ . "/../vendor/autoload.php");

use Desafio\Picpay\Factory\{BankAccountControllerFactory,
    IndexControllerFactory,
    TransferenceControllerFactory,
    UserControllerFactory
};
use Desafio\Picpay\Documentation\Swagger;
use Desafio\Picpay\Lib\Web\Router;

$factories = new class {
    use IndexControllerFactory;
    use UserControllerFactory;
    use BankAccountControllerFactory;
    use TransferenceControllerFactory;
};

$indexController = $factories->createIndexController();
$userController = $factories->createUserController();
$bankAccountController = $factories->createBankAccountController();
$transferenceController = $factories->createTransferenceController();

$router = new Router("/api");
$swagger = new Swagger;
$swagger->createDocumentationSwagger($router);

$router->get("v1", [$indexController, 'index']);

$router->get("v1", [$indexController, 'index']);
$router->get("v1/users", [$userController, 'findAllUsers']);
$router->get("v1/users/id", [$userController, 'findOneUser']);
$router->post("v1/users/register", [$userController, 'register']);

$router->get("v1/accounts", [$bankAccountController, 'findAllAccounts']);
$router->get("v1/accounts/id", [$bankAccountController, 'findOneAccount']);
$router->post("v1/accounts", [$bankAccountController, 'create']);
$router->patch("v1/accounts", [$bankAccountController, 'updateAccount']);

$router->post("v1/transactions", [$transferenceController, 'createTransference']);

$router->runRoutes();
