<?php

namespace Desafio\Picpay\Lib\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?Connection $instance = null;
    private PDO $pdoConnection;

    private function __construct()
    {
        try {
            $dnsDatabase = DB_DRIVE . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->pdoConnection = new PDO($dnsDatabase, DB_USER, DB_PASS);
            $this->pdoConnection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdoConnection->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
            $this->pdoConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error Connect Database; Cause: {$error->getMessage()}";
        }
    }

    public static function getInstance(): Connection
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getPdoConnection(): PDO
    {
        return self::$instance->pdoConnection;
    }

}