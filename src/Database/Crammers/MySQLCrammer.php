<?php

namespace Src\Database\Crammers;

use App\Models\Model;

class MySQLCrammer
{
    public static function buildSelectQuery(string|array $columns = "*", array $filter = null)
    {
        if (is_array($columns)) {
            $columns = '`' . implode("`, `", $columns) . '`';
        }

        $query = "SELECT $columns FROM " . config('database.DB_NAME') . '.' . Model::getTableName();

        if ($filter) {
            $query .= " WHERE $filter[0] $filter[1] ? ";
        }

        return $query;
    }

    public static function buildInsertQuery($keys)
    {
        $values = '';
        for ($i = 1; $i <= count($keys); $i++) {
            $values .= '?, ';
        }
        return "INSERT INTO " . config('database.DB_NAME') . "." . Model::getTableName() . ' (`' . implode('`,`', $keys) . '`)' . ' VALUES(' . rtrim($values, ', ') . ')';
    }

    public static function buildDeleteQuery()
    {
        return "DELETE FROM " . config('database.DB_NAME') . '.' . Model::getTableName() . ' WHERE ID = ?';
    }


    public static function buildUpdateQuery($keys)
    {
        $query = "UPDATE " . config('database.DB_NAME') . "." . Model::getTableName() . ' SET ';

        foreach ($keys as $key) {
            $query .= '`' . $key . '`' . ' = ?, ';
        }

        $query = rtrim($query, ', ') . ' WHERE ID = ?';
        return $query;
    }


    public static function buildLimitQuery()
    {
        return "SELECT * FROM " . config('database.DB_NAME') . '.' . Model::getTableName() . ' LIMIT ?';
    }


    public static function buildLikeQuery(string $column)
    {
        return "SELECT * FROM " . config('database.DB_NAME') . '.' . Model::getTableName() . " WHERE $column LIKE ?";
    }
}
