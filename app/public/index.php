<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers/helpers.php';

use App\Models\Customer;


// echo 'Witam ! </br></br>';
// echo 'Dane konfiguracyjne bazy danych </br></br>';

// dump($customer->getConfig());

// echo 'Nazwa Tabeli</br></br>';

// dump($customer->getTableName());

// echo 'Dane Tabeli</br></br>';
$customer = new Customer();

dump($customer->where('address_id', '=', 6)->all());
dump($customer->where('address_id', '=', 44)->where('store_id', '=', 2)->all());