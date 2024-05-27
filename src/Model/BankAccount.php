<?php

namespace Desafio\Picpay\Model;

use Desafio\Picpay\Model\Interface\BaseModel;

class BankAccount implements BaseModel
{
    private ?string $accountNumber;
    private ?string $userCpf;
    private ?float $balance;

    public function __construct(?string $accountNumber, ?string $userCpf, ?float $balance)
    {
        $this->accountNumber = $accountNumber ?? null;
        $this->userCpf = $userCpf;
        $this->balance = $balance;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): void
    {
        $this->accountNumber = $accountNumber;
    }

    public function getUserCpf(): ?string
    {
        return $this->userCpf;
    }

    public function setUserCpf(string $userCpf): void
    {
        $this->userCpf = $userCpf;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public static function serializer(array $bodyJson): static
    {
        extract($bodyJson);
        return new static($account_number, $user_cpf, $balance);
    }
}
