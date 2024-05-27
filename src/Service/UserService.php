<?php

namespace Desafio\Picpay\Service;

use Desafio\Picpay\Model\User;
use Desafio\Picpay\Repositories\CrudRepository;

class UserService
{
    private CrudRepository $repository;

    public function __construct(CrudRepository $repository)
    {
        $this->repository = $repository;
    }


    public function register($requestBody): array
    {
        $user = User::serializer($requestBody);
        return $this->repository->save($user);
    }

    public function findAllUsers(): array
    {
        return $this->repository->findAll();
    }

    public function findOneUser($requestId): array
    {
        return $this->repository->findOne($requestId);
    }
}
