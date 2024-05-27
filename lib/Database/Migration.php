<?php

namespace Desafio\Picpay\Lib\Database;

use Exception;
use PDO;

class Migration
{
    private const STATUS = [
        "failed" => "\033[91m",
        "successful" => "\033[92m",
        "warning" => "\033[93m",
        "normal" => "\033[0m"
    ];

    /**
     * @throws Exception
     */
    public function migrate(string $pathMigration): void
    {
        $con = Connection::getInstance();
        $pdo = $con->getPdoConnection();
        $this->createTableMigrates($con);
        !is_dir($pathMigration) && throw new Exception("ERROR");

        $files = scandir($pathMigration);
        $files = array_filter($files, function ($e) {
            $extension = explode(".", $e)[1];
            return strtolower($extension) == "sql";
        });
        $files = array_unique($files, SORT_REGULAR);
        sort($files);
        foreach ($files as $file) {
            list($filename, $extension) = explode(".", $file);
            $extensionIsSql = strtolower($extension) == 'sql';
            $migrationAlreadyRunning = $this->migrateAlreadyExists($pdo,$filename);

            if(!is_dir($file) and $extensionIsSql and !$migrationAlreadyRunning) {
                $sqlMigration = file_get_contents("{$pathMigration}/{$file}");
                $stmt = $pdo->prepare($sqlMigration);
                $status = $stmt->execute();

                if(!$status) {
                    echo "Fail running migration";
                    return;
                }
                echo self::STATUS['successful'].">>> Create migration {$filename}". PHP_EOL;
                $this->insertMigrate($pdo, $filename);
                continue;
            }
            echo self::STATUS['warning'].">>> Skipping migrate $filename" . PHP_EOL;
        }
    }

    public function createTableMigrates(Connection $con): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
                    migration VARCHAR(100) NOT NULL PRIMARY KEY,
                    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

        $pdo = $con->getPdoConnection();
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute();

        if(!$status) {
            echo "Error";
        }
    }

    private function insertMigrate(PDO $con, string $filename): void
    {
        $sql = "INSERT INTO migrations (migration) VALUES ('$filename')";
        $stmt = $con->prepare($sql);
        $status = $stmt->execute();

        if(!$status) {
            echo "Fail Migration $filename";
        }
    }

    private function migrateAlreadyExists(PDO $con, string $filename): bool
    {
        $sql = "SELECT COUNT(*) AS EXIST FROM migrations WHERE migration = '$filename'";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchObject();
        return $result->exist > 0;
    }
}
