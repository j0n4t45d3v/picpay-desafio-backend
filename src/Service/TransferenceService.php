<?php

namespace Desafio\Picpay\Service;

use Desafio\Picpay\Lib\Web\Http\Response;
use Desafio\Picpay\Lib\Web\Http\Status\Code;
use Desafio\Picpay\Model\BankAccount;
use Desafio\Picpay\Model\Transference;
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

    public function createTransaction(array $request): array
    {
        $transference = Transference::serializer($request);

        list($successIssue, $issuerExist) = $this->userService->findOneUser($transference->getUserCpfIssuer());
        list($successDestiny, $destinyExist) = $this->userService->findOneUser($transference->getUserCpfDestiny());

        if(!$successIssue) return [false, "User issuer not found"];
        if(!$successDestiny) return [false, "User destiny not found"];

        list($statusIssuer, $accountIssue) = $this->accountService->findOneByCpfUser($issuerExist->cpf);
        list($statusDestiny, $accountDestiny) = $this->accountService->findOneByCpfUser($destinyExist->cpf);
        if(!$statusIssuer or !$statusDestiny) return [false, "Error in find account"];
        if($transference->getValueTransaction() > $accountIssue->balance) return [false, "Insufficient balance"];

        $issueNewBalance = $accountIssue->balance - $transference->getValueTransaction();
        $destinyNewBalance = $accountDestiny->balance + $transference->getValueTransaction();

        $updatedBalanceIssuer = ['user_cpf' => $accountIssue->user_cpf, 'balance' => $issueNewBalance];
        $updatedBalanceDestiny = ['user_cpf' => $accountDestiny->user_cpf, 'balance' => $destinyNewBalance];

        list($statusUpdateIssuer, $resultIssuer) =
            $this->accountService->updateAccount($accountIssue->id, $updatedBalanceIssuer);
        list($statusUpdateDestiny, $resultDestiny) =
            $this->accountService->updateAccount($accountDestiny->id, $updatedBalanceDestiny);


        $this->repository->save($transference);

        $formatteValue = number_format($transference->getValueTransaction(), 2, ',');
        return [true, "Transaction value of R$ {$transference->getValueTransaction()} to $destinyExist->full_name"];
    }
}
