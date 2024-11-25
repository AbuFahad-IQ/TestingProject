<?php

namespace Src\Database\Managers\Contract;

interface DatabaseManager
{
    public function connect(): \PDO;
    public function query(string $query, array $values = []);
    public function read(string|array $columns = "*", array $filter = null);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function limit(int $limit);
    public function like(string $column, string $search);
}
