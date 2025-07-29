<?php

namespace App\Models;

use App\src\core\Model;

class Customer extends Model {
    protected $connection = 'mysql';
    protected $table = 'customer';
}