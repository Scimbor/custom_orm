<?php

namespace App\src\core;

class DatabaseConfig {
    public static function getConfig()
    {
        return require __DIR__ . '/../../config/database.php';
    }
}