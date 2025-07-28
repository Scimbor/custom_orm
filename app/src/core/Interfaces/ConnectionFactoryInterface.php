<?php

namespace App\src\core\Interfaces;

use PDO;

interface ConnectionFactoryInterface {
    public function create(array $config): PDO;
}