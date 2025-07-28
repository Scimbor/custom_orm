<?php

namespace App\src\core\ConnectionDatabaseFactory;

use PDO;
use App\src\core\Interfaces\ConnectionFactoryInterface;

class PgsqlConnectionFactory implements ConnectionFactoryInterface {
    public function create(array $config): PDO {
        $dsn = "pgsql:host={$config['host']};dbname={$config['database']}";
        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}