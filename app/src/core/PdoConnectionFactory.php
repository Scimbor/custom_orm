<?php

namespace App\src\core;

use Exception;
use App\src\core\Interfaces\ConnectionFactoryInterface;
use App\src\core\ConnectionDatabaseFactory\MysqlConnectionFactory;
use App\src\core\ConnectionDatabaseFactory\PgsqlConnectionFactory;
use App\src\core\ConnectionDatabaseFactory\SqliteConnectionFactory;

class PdoConnectionFactory {
    public static function make($driver): ConnectionFactoryInterface {
        return match ($driver) {
            'mysql' => new MysqlConnectionFactory(),
            'sqlite' => new SqliteConnectionFactory(),
            'pgsql' => new PgsqlConnectionFactory(),

            default => throw new Exception("Nieobsługiwany sterownik: $driver"),
        };
    }
}