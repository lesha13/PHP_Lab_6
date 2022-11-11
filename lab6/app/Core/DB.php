<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

/**
 * Class DB
 */
class DB
{

    /**
     * @var PDO
     */
    private static $pdo;

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=' . MYSQL_HOST . ';port=' . MYSQL_PORT . ';dbname=' . DB_NAME . ';charset=utf8';
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            try {
                self::$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit(); // this is a bad way how to handle PDO exception
            }
        }

        return self::$pdo;
    }

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return array|bool
     */
    public function query(string $sql, array $parameters = [])
    {
        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $result = $stmt->execute($parameters);

        if ($result !== false) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * Delete provided entity
     * 
     * @param DbModelInterface $model
     * @return bool
     */
    public function deleteEntity(DbModelInterface $model): bool
    {
        $dbh = $this->getConnection();
        $sql = sprintf("DELETE FROM %s WHERE %s = ?",
                $model->getTableName(),
                $model->getPrimaryKeyName()
        );
        $statement = $dbh->prepare($sql);

        return $statement->execute($model->getId());
    }

}
