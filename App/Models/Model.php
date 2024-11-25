<?php

namespace App\Models;

use Src\Support\Str;

abstract class Model
{
    protected static $instance;

    public static function all()
    {
        self::$instance = static::class;
        return app()->db->read();
    }

    public static function query(string $query, array $values = [])
    {
        self::$instance = static::class;
        return app()->db->query($query, $values);
    }

    public static function findById(int $id)
    {
        self::$instance = static::class;
        return app()->db->read('*', ['id', '=', $id]);
    }

    public static function read(string|array $columns = "*", array $filter = null)
    {
        self::$instance = static::class;
        return app()->db->read($columns, $filter);
    }

    public static function create(array $data)
    {
        self::$instance = static::class;
        return app()->db->create($data);
    }

    public static function update(int $id, array $data)
    {
        self::$instance = static::class;
        return app()->db->update($id, $data);
    }

    public static function delete(int $id)
    {
        self::$instance = static::class;
        return app()->db->delete($id);
    }

    public static function limit(int $limit)
    {
        self::$instance = static::class;
        return app()->db->limit($limit);
    }

    public static function like(string $column, string $search)
    {
        self::$instance = static::class;
        return app()->db->like($column, $search);
    }

    public static function getModel()
    {
        return self::$instance;
    }

    public static function getTableName()
    {
        return Str::lower(Str::plural(basename(str_replace('\\', '/', self::$instance))));
    }
}
