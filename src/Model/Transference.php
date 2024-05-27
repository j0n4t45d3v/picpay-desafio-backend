<?php

namespace Desafio\Picpay\Model;

class Transference
{
    private int $id;
    private string $userCpfIssuer;
    private string $userCpfDestiny;
    private float $valueTransaction;

    public function __construct(string $userCpfIssuer, string $userCpfDestiny, $valueTransaction)
    {
        $this->userCpfIssuer = $userCpfIssuer;
        $this->userCpfDestiny = $userCpfDestiny;
        $this->valueTransaction = $valueTransaction;
    }

    public function getUserCpfIssuer(): string
    {
        return $this->userCpfIssuer;
    }

    public function setUserCpfIssuer(string $userCpfIssuer): void
    {
        $this->userCpfIssuer = $userCpfIssuer;
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
        return new static($user_issuer, $user_destiny, $value_transaction);
    }

}
