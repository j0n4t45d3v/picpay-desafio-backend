<?php

namespace Desafio\Picpay\Factory;

use Desafio\Picpay\Controllers\TransferenceController;
use Desafio\Picpay\Repositories\Implementations\TransferenceRepository;
use Desafio\Picpay\Service\TransferenceService;

trait TransferenceControllerFactory
{
    use UserControllerFactory;
    use BankAccountControllerFactory;
    public function createTransferenceController(): TransferenceController
    {
        $accountService = $this->createBankAccountService();
        $userService = $this->createUserService();
        $transferenceRepository = new TransferenceRepository;
        $transferenceService =
            new TransferenceService($transferenceRepository, $accountService, $userService);
        return new TransferenceController($transferenceService);
    }
}
