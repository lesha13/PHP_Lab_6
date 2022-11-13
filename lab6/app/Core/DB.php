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

    public static function arrayToList($array = [], $mask = "%s", $separator = ","): string
    {
        return implode($separator, array_map( "sprintf", array_fill(0, count ($array), $mask), $array ));
    }

    public function createEntity(DbModelInterface $model, $values = [])
    {
        $dbh = $this->getConnection();
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s);",
            $model->getTableName(),
            DB::arrayToList(array_keys($values), "%s"),
            DB::arrayToList($values, "?")
        );
        $statement = $dbh->prepare($sql);

        if ($statement->execute(array_values($values))) {
            $sql = sprintf(
                "SELECT %s FROM %s ORDER BY %s DESC LIMIT 1; ",
                $model->getPrimaryKeyName(),
                $model->getTableName(),
                $model->getPrimaryKeyName()
            );
            $result = $this->query($sql);
            if ($result){
                return $result[0][$model->getPrimaryKeyName()];
            }
        }
        return false;
    }

    public function updateEntity(DbModelInterface $model, $id, $values = [])
    {
        $dbh = $this->getConnection();
        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = ?;",
            $model->getTableName(),
            DB::arrayToList(array_keys($values), "%s = ?"),
            $model->getPrimaryKeyName()
        );

        $statement = $dbh->prepare($sql);

        $parameters = array_merge(array_values($values), array($id));

        return $statement->execute($parameters);
    }

    public function deleteEntity(DbModelInterface $model, $id)
    {
        $dbh = $this->getConnection();
        $sql = sprintf("DELETE FROM %s WHERE %s = %s",
            $model->getTableName(),
            $model->getPrimaryKeyName(),
            $id
        );
        $statement = $dbh->prepare($sql);

        return $statement->execute();
    }
}
