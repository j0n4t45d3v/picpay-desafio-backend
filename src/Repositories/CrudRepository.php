<?php

namespace Desafio\Picpay\Repositories;

interface CrudRepository
{
    function save($entity): array;
    function findAll(): array;
    function findOne(): array;
    function delete($id): array;
    function update($id, $entityUpdated): array;
}