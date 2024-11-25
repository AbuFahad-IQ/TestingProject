<?php

namespace Src\Database;

use Src\Database\Connects\ConnectTo;
use Src\Database\Managers\Contract\DatabaseManager;

class DB
{
    protected DatabaseManager $manager;
    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }

    public function connect()
    {
        ConnectTo::connect($this->manager);
    }

    public function query(string $query, array $values = [])
    {
        return $this->manager->query($query, $values);
    }

    public function read(string|array $columns = "*", array $filter = null)
    {
        return $this->manager->read($columns, $filter);
    }

    public function create(array $data)
    {
        return $this->manager->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->manager->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->manager->delete($id);
    }

    public function limit(int $limit)
    {
        return $this->manager->limit($limit);
    }

    public function like(string $column, string $search)
    {
        return $this->manager->like($column, $search);
    }
}
