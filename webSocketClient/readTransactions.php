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
$reader->run();

//$provider = new AddressProvider($host, $dbName, $username, $password);
//for ($i = 0; $i < 20; $i++) {
//	echo $provider->getFreeAddress() . PHP_EOL;
//}

echo "duration: " . (microtime(true) - $start)*1000 . ' miliseconds'. PHP_EOL;
