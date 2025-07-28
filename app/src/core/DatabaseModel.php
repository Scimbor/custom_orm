<?php

namespace App\src\core;

use Exception;
use PDOException;
use App\src\core\PdoConnectionFactory;

abstract class DatabaseModel{
    protected $connection;
    protected $config;
    protected $table = null;
    protected $pdo;

    public function __construct()
    {
          // Sprawdź, czy klasa potomna ma ustawioną właściwość $connection
        if (!isset($this->connection)) {
            $this->connection = env('DATABASE_DEFAULT_CONNECTION');
        }

        if (empty($this->table)) {
            throw new \Exception('Model ' . get_class($this) . ' have to define $table');
        }

        $this->table = $this->table;
        
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
            die('Błąd połączenia z bazą: ' . $e->getMessage());
        }
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getConnectionName()
    {
        return $this->connection;
    }

    public function getTableName()
    {
        return $this->table;
    }
}