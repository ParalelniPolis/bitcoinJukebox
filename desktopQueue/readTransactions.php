<?php

require_once('vendor/autoload.php');
require_once('TransactionReader.php');
require_once('../adminAndMobile/app/model/AddressProvider.php');

use App\Model;

$start = microtime(true);

$host = 'localhost';
$dbName = 'jukebox';
$username = 'root';
$password = '';

$reader = new TransactionReader($host, $dbName, $username, $password);
//$reader->run();
$reader->transactionReceived('13ngDv9EgzAug92hheRgT3GGduZonXRqpW');

echo "duration: " . (microtime(true) - $start)*1000 . ' miliseconds'. PHP_EOL;
