<?php

namespace App\Models;

use App\src\core\Model;

class Customer extends Model {
    protected string $connection = 'mysql';
    protected string $table = 'customer';
}