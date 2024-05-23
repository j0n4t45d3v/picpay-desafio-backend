<?php

namespace Desafio\Picpay\Service;

use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;
use Desafio\Picpay\Repositories\CrudRepository;

class TransferenceService
{
    private CrudRepository $repository;
    private BankAccountService $accountService;
    private UserService $userService;

    public function __construct(CrudRepository $repository, BankAccountService $accountService, UserService $userService)
    {
        $this->repository = $repository;
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    public function createTransaction(mixed $request): array
    {
        return [true, "OKAY"];
    }
}
