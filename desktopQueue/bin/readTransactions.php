<?php

require_once '../vendor/autoload.php';
require_once '../app/TransactionReader.php';

$host = 'localhost';
$dbName = 'jukebox';
$username = 'root';
$password = '';

//$reader = new TransactionReader($host, $dbName, $username, $password);
//$reader->run();
//$reader->transactionReceived('13ngDv9EgzAug92hheRgT3GGduZonXRqpW');

//$thread = new TransactionReadingThread();
//
//$thread->setTransactionObtainedCallback('hello');
//
//function hello(string $songName, string $songId) {
//	echo "hello, song name is $songName and song id is $songId " . PHP_EOL;
//}
//
//$thread->start();

$handle = popen('php readTransactions.php  2>&1', 'r');
echo "'$handle'; " . gettype($handle) . PHP_EOL;
$read = fread($handle, 2096);
echo $read . PHP_EOL;
pclose($handle);