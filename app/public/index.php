<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers/helpers.php';

use App\Models\Customer;

$customer = new Customer();

// echo 'Witam ! </br></br>';
// echo 'Dane konfiguracyjne bazy danych </br></br>';

// dump($customer->getConfig());

// echo 'Nazwa Tabeli</br></br>';

// dump($customer->getTableName());

// echo 'Dane Tabeli</br></br>';

dump($customer->all());