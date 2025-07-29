<?php

namespace App\src\core;

use Exception;
use PDOException;
use App\src\core\PdoConnectionFactory;

abstract class AbstractModel
{
    protected $connection;
    protected $config;
    protected $table = null;
    protected $pdo;

    protected $wheres = [];
    protected $bindings = [];

    public function __construct()
    {
        if (!isset($this->connection)) {
            $this->connection = env('DATABASE_DEFAULT_CONNECTION');
        }

        if (empty($this->table)) {
            throw new \Exception('Model ' . get_class($this) . ' have to define $table');
        }

        $allConfigs = DatabaseConfig::getConfig();
        $this->config = $allConfigs[$this->connection];

        $this->pdo = $this->createPdoConnection($this->config);
    }

    protected function createPdoConnection($config)
    {
        try {
            $factory = PdoConnectionFactory::make($config['driver']);

            return $factory->create($config);
        } catch (PDOException $e) {
            throw new Exception('Błąd połączenia z bazą: ' . $e->getMessage());
        }
    }

    protected function query(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        $this->wheres = [];
        $this->bindings = [];

        return $stmt;
    }

    protected function buildWhereClause(): string
    {
        if (empty($this->wheres)) {
            return '';
        }

        $conditions = [];

        foreach ($this->wheres as $index => $where) {
            $prefix = $index === 0 ? '' : $where['boolean'] . ' ';
            $conditions[] = $prefix . "{$where['column']} {$where['operator']} ?";
        }

        return ' WHERE ' . implode(' ', $conditions);
    }
}