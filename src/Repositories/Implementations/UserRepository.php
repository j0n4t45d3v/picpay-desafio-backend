<?php

namespace Desafio\Picpay\Repositories\Implementations;

use Desafio\Picpay\Lib\Database\Connection;
use Desafio\Picpay\Model\User;
use Desafio\Picpay\Repositories\CrudRepository;

class UserRepository implements CrudRepository
{

    function save($entity): array
    {
        $sql = "INSERT INTO users (full_name, cpf, email, passw, type_user) VALUES
                (:fullName, :cpf, :email, :password, :typeUser)";
        if(!$entity instanceof User) {
            return [false, "Error Class Is Not User Class"];
        }

        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":fullName", $entity->getFullName());
        $stmt->bindValue(":cpf", $entity->getCpf());
        $stmt->bindValue(":email", $entity->getEmail());
        $stmt->bindValue(":password", $entity->getPassword());
        $stmt->bindValue(":typeUser", $entity->getTypeUser());

        $rs = $stmt->execute();

        if(!$rs) return [false, 'Error In Save User'];

        return [true, 'User Saved'];
    }

    function findAll(): array
    {
        $sql = "SELECT * FROM users";
        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function findOne($id): array|bool
    {
        $sql = "SELECT * FROM users u WHERE u.cpf = :cpf";
        $con = Connection::getInstance()->getPdoConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":cpf", $id);

        $status = $stmt->execute();

        if(!$status) return [false, $stmt->errorInfo()];
        return $stmt->fetchObject();
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
