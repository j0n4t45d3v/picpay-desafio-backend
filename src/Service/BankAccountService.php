<?php

namespace Desafio\Picpay\Service;

use Desafio\Picpay\Lib\Web\Http\Request;
use Desafio\Picpay\Model\BankAccount;
use Desafio\Picpay\Repositories\CrudRepository;
use Desafio\Picpay\Repositories\Implementations\BankAccountRepository;

class BankAccountService
{
    private CrudRepository $repository;
    private UserService $userService;

    public function __construct(CrudRepository $repository, UserService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    public function create($requestBody): array
    {
        $account = BankAccount::serializer($requestBody);
        list($success, $userAlreadyExists) = $this->userService->findOneUser($account->getUserCpf());

        if($this->repository instanceof BankAccountRepository) {
            list($status, $accountAlreadyExists) = $this->repository->findAccountByCpfUser($account->getUserCpf());
            if ($accountAlreadyExists) {
                return [false, "Already exist account for user", 'status' => 400];
            }
        }
        if(!$success)
            return [false, "User not found", 'status' => 404];
        return $this->repository->save($account);
    }

    public function findAllAccounts(): array
    {
        return $this->repository->findAll();
    }

    public function findOneAccount($requestId): array
    {
        return $this->repository->findOne($requestId);
    }

    public function findOneByCpfUser($userCpf): array
    {
        if(!$this->repository instanceof BankAccountRepository){
            return [false, "Repository not is BankAccountRepository "];
        }
        return $this->repository->findAccountByCpfUser($userCpf);
    }

    public  function updateAccount(string $requestId, array $body): array
    {
        $bodyAccount = BankAccount::serializer($body);
        return $this->repository->update($requestId, $bodyAccount);
    }
}
