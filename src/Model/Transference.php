<?php

namespace Desafio\Picpay\Model;

class Transference
{
    private int $id;
    private string $userCpfIssurer;
    private string $userCpfDestiny;
    private float $valueTransaction;

    public function __construct(string $userCpfIssurer, string $userCpfDestiny, $valueTransaction)
    {
        $this->userCpfIssurer = $userCpfIssurer;
        $this->userCpfDestiny = $userCpfDestiny;
        $this->valueTransaction = $valueTransaction;
    }

    public function getUserCpfIssurer(): string
    {
        return $this->userCpfIssurer;
    }

    public function setUserCpfIssurer(string $userCpfIssurer): void
    {
        $this->userCpfIssurer = $userCpfIssurer;
    }

    public function getUserCpfDestiny(): string
    {
        return $this->userCpfDestiny;
    }

    public function setUserCpfDestiny(string $userCpfDestiny): void
    {
        $this->userCpfDestiny = $userCpfDestiny;
    }

    public function getValueTransaction(): float
    {
        return $this->valueTransaction;
    }

    public function setValueTransaction(float $valueTransaction): void
    {
        $this->valueTransaction = $valueTransaction;
    }

    public static function serializer(array $bodyJson): static
    {
        extract($bodyJson);
        return new static($user_issurer, $user_destiny, $value_transaction);
    }

}
