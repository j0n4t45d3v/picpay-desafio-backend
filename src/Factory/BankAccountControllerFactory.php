<?php

namespace Desafio\Picpay\Factory;

use Desafio\Picpay\Controllers\BankAccountController;
use Desafio\Picpay\Repositories\Implementations\BankAccountRepository;
use Desafio\Picpay\Service\BankAccountService;

trait BankAccountControllerFactory
{
    use UserControllerFactory;
    public function createBankAccountController(): BankAccountController
    {
        $bankAccountService = $this->createBankAccountService();
        return new BankAccountController($bankAccountService);
    }

    public function createBankAccountService(): BankAccountService
    {
        $bankAccountRepository = new BankAccountRepository;
        return new BankAccountService($bankAccountRepository, $this->createUserService());
    }
}
