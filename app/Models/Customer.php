<?php

namespace App\Models;

use App\src\core\DatabaseModel;

class Customer extends DatabaseModel {
    protected $connection = 'sqlite';
    protected $table = 'customer';
}