<?php

namespace App\src\core;

use PDO;
use Exception;
use PDOException;
use App\src\core\PdoConnectionFactory;

class Model
{
    protected static $instance = null;

    protected string $table;
    protected string $select = '*';
    protected array $wheres = [];
    protected array $bindings = [];
    protected string $connection;
    protected PDO $pdo;
    protected array $config;

    public function __construct()
    {
        $this->connection = $this->connection ?? env('DATABASE_DEFAULT_CONNECTION');

        if (empty($this->table)) {
            throw new Exception('Model ' . static::class . ' must define $table');
        }

        $allConfigs = DatabaseConfig::getConfig();
        $this->config = $allConfigs[$this->connection];
        $this->pdo = $this->createPdoConnection($this->config);
    }

    protected static function getInstance(): self
    {
        // Always return a fresh instance for chaining
        return new static();
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = static::getInstance();

        if (!method_exists($instance, $method)) {
            throw new Exception("Method {$method} does not exist in " . static::class);
        }

        $result = $instance->$method(...$arguments);

        // Return instance if chaining is intended
        return $result === $instance ? $instance : $result;
    }

    public function all()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->wheres)) {
            $conditions = array_map(fn($w) => "{$w[0]} {$w[1]} ?", $this->wheres);
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        return $this->query($sql)->fetchAll();
    }

    protected function createPdoConnection($config): PDO
    {
        try {
            $factory = PdoConnectionFactory::make($config['driver']);
            return $factory->create($config);
        } catch (PDOException $e) {
            throw new Exception('Database connection error: ' . $e->getMessage());
        }
    }

    protected function query(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        // Reset for next query
        $this->wheres = [];
        $this->bindings = [];

        return $stmt;
    }

    protected function where($column, $operator, $value): self
    {
        $this->wheres[] = [$column, $operator, $value];
        $this->bindings[] = $value;
        return $this;
    }

    protected function select($columns = '*'): self
    {
        $this->select = $columns;
        return $this;
    }

    protected function get()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->wheres)) {
            $conditions = array_map(fn($w) => "{$w[0]} {$w[1]} ?", $this->wheres);
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        return $this->query($sql)->fetchAll();
    }
}
