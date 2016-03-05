<?php

require_once '../vendor/autoload.php';
require_once '../app/TransactionReader.php';

$host = 'localhost';
$dbName = 'jukebox';
$username = 'root';
$password = '';

$reader = new TransactionReader($host, $dbName, $username, $password);
//$reader->run();
$reader->transactionReceived('12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ');
