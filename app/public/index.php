<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers/helpers.php';

use App\Models\Customer;


// echo 'Hello ! </br></br>';
// echo 'Database configuration </br></br>';

// dump($customer->getConfig());

// echo 'Table name</br></br>';

// dump($customer->getTableName());

// echo 'Table data</br></br>';
dump(Customer::get());
dump(Customer::where('address_id', '=', 6)->all());

// // Usage pagination and where and select
// dump($customer->select('customer_id, first_name, last_name')->where('store_id', '=', 2)->paginate(1, 2));