<?php

namespace Desafio\Picpay\Repositories\Implementations;

use Desafio\Picpay\Lib\Database\Connection;
use Desafio\Picpay\Model\BankAccount;
use Desafio\Picpay\Model\Transference;
use Desafio\Picpay\Repositories\CrudRepository;

class TransferenceRepository implements CrudRepository
{
    function save($entity): array
    {
        if(!$entity instanceof Transference) return [false, 'Request body is not entity Transference'];

        $sql = "INSERT INTO transference (user_issuer, user_destiny, value_transaction)
                VALUES (:user_issuer, :user_destiny, :value_transaction)";
        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":user_issuer", $entity->getUserCpfIssuer());
        $stmt->bindValue(":user_destiny", $entity->getUserCpfDestiny());
        $stmt->bindValue(":value_transaction", $entity->getValueTransaction());
        $status = $stmt->execute();
        if(!$status) return [false, 'Error on create transaction'];
        return [true, 'Traference created'];
    }

    function findAll(): array
    {
        $sql = "SELECT * FROM account_banks";
        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function findOne($id): array|bool
    {
        $sql = "SELECT * FROM account_banks ab WHERE ab.id = :id";

        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findAccountByCpfUser(string $cpfUser): array
    {
        $sql = "SELECT * FROM account_banks ab WHERE ab.user_cpf = :user_cpf";

        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":user_cpf", $cpfUser);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function delete($id): array
    {
        // TODO: Implement delete() method.
        return [];
    }

    function update($id, $entityUpdated): array
    {
        // TODO: Implement update() method.
        return [];
    }
}
