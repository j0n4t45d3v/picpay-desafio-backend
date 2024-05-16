<?php

namespace Desafio\Picpay\Model;

use Desafio\Picpay\Model\Interface\BaseModel;

class User implements BaseModel
{
    private string $fullName;
    private string $email;
    private string $password;
    private string $cpf;
    private string $typeUser;

    public function __construct(string $fullName, string $email, string $password, string $cpf, string $typeUser)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->cpf = $cpf;
        $this->typeUser = $typeUser;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getTypeUser(): string
    {
        return $this->typeUser;
    }

    public function setTypeUser(string $typeUser): void
    {
        $this->typeUser = $typeUser;
    }

    public static function serializer(array $bodyJson): static
    {
        extract( $bodyJson);
        return new static($full_name, $email, $password, $cpf, $type_user);
    }

}