<?php

namespace App\src\core\ConnectionDatabaseFactory;

use PDO;
use App\src\core\Interfaces\ConnectionFactoryInterface;

class SqliteConnectionFactory implements ConnectionFactoryInterface {
    public function create(array $config): PDO {
        $dsn = "sqlite:{$config['database']}";
        return new PDO($dsn, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}