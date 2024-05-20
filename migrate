#!/usr/bin/php
<?php

require_once __DIR__ . "/vendor/autoload.php";
use Desafio\Picpay\Lib\Database\Migration;

$migration = new Migration;

try {
    $path = __DIR__."/migration";
    $migration->migrate($path);
} catch (Exception $e) {
    echo $e->getMessage();
}
