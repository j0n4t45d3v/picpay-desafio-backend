<?php

namespace Desafio\Picpay\Repositories\Implementations;

use Desafio\Picpay\Lib\Database\Connection;
use Desafio\Picpay\Model\BankAccount;
use Desafio\Picpay\Repositories\CrudRepository;

class BankAccountRepository implements CrudRepository
{
    function save($entity): array
    {
        if(!$entity instanceof BankAccount) return [false, 'Request body is not entity BankAccount'];

        $sql = "INSERT INTO account_banks (account_number, user_cpf, balance) VALUES (:account_number, :user_cpf, :balance)";
        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":account_number", $entity->getAccountNumber());
        $stmt->bindValue(":user_cpf", $entity->getUserCpf());
        $stmt->bindValue(":balance", $entity->getBalance());
        $status = $stmt->execute();
        if(!$status) return [false, 'Error on create account'];
        return [true, 'Account created'];
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
        return [true, $stmt->fetchAll()];
    }

    function delete($id): array
    {
        // TODO: Implement delete() method.
        return [];
    }

    function update($id, $entityUpdated): array
    {
        $sql = "UPDATE account_banks SET";
        if(!$entityUpdated instanceof BankAccount){
            return [false, "Entity not is BankAccount entity"];
        }

        if($entityUpdated->getUserCpf() != null) {
            $sql .= " user_cpf = :user_cpf ,";
        }

        if($entityUpdated->getBalance() != null) {
            $sql .= " balance = :balance ";
        }

        $sql .= " WHERE id = :id";

        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);

        if($entityUpdated->getUserCpf() != null) {
            $stmt->bindValue(":user_cpf", $entityUpdated->getUserCpf());
        }

        if($entityUpdated->getBalance() != null) {
            $stmt->bindValue(":balance", $entityUpdated->getBalance());
        }
        $stmt->bindValue(":id", $id);

        $stmt->execute();

        return [true, "Account updated"];
    }
}
