<?php

namespace Src\Database\Managers;

use App\Models\Model;
use Src\Database\Crammers\MySQLCrammer;
use Src\Database\Managers\Contract\DatabaseManager;

class MySQLManager implements DatabaseManager
{
    protected static $instance;
    public function connect(): \PDO
    {
        try {
            if (! self::$instance) {
                self::$instance = \PDO::connect(config('database.DB_DRIVER') . ':host=' . config('database.DB_HOST') . ';dbname=' . config('database.DB_NAME') . ';charset=' . config('database.DB_CHARSET'), config('database.DB_USERNAME'), config('database.DB_PASSWORD'));
            }
        } catch (\PDOException $e) {
            echo 'Error Connect Database : ' . $e->getMessage();
            exit();
        }
        return self::$instance;
    }


    public function create(array $data)
    {
        $query = MySQLCrammer::buildInsertQuery(array_keys($data));
        $stmt = self::$instance->prepare($query);

        for ($i = 1; $i <= count($values = array_values($data)); $i++) {
            $stmt->bindValue($i, $values[$i - 1]);
        }
        return $stmt->execute();
    }


    public function delete(int $id)
    {
        $query = MySQLCrammer::buildDeleteQuery();
        $stmt = self::$instance->prepare($query);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function like(string $column, string $search)
    {
        $query = MySQLCrammer::buildLikeQuery($column);
        $stmt = self::$instance->prepare($query);
        $stmt->bindValue(1, $search, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }


    public function limit(int $limit)
    {
        $query = MySQLCrammer::buildLimitQuery();
        $stmt = self::$instance->prepare($query);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }


    public function query(string $query, array $values = [])
    {
        $stmt = self::$instance->prepare($query);

        for ($i = 1; $i <= count($values); $i++) {
            $stmt->bindValue($i, $values[$i - 1], \PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }


    public function read(array|string $columns = '*', array|null $filter = null)
    {
        $query = MySQLCrammer::buildSelectQuery($columns, $filter);
        $stmt = self::$instance->prepare($query);

        if ($filter) {
            $stmt->bindValue(1, $filter[2], \PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }


    public function update(int $id, array $data)
    {
        $query = MySQLCrammer::buildUpdateQuery(array_keys($data));
        $stmt = self::$instance->prepare($query);

        for ($i = 1; $i <= count($values = array_values($data)); $i++) {
            $stmt->bindValue($i, $values[$i - 1], \PDO::PARAM_STR);
            if ($i === count($values)) {
                $stmt->bindValue($i + 1, $id);
            }
        }

        return $stmt->execute();
    }
}
