<?php

require_once('vendor/autoload.php');
require_once('TransactionReader.php');

use \BitcoinPHP\BitcoinECDSA\BitcoinECDSA;

$host = 'localhost';
$dbName = 'jukebox';
$username = 'root';
$password = '';

$reader = new TransactionReader($host, $dbName, $username, $password);
//$reader->run();


//temporarily here, generating addresses
//$dsn = 'mysql:dbname=' . $dbName . ';host=' . $host . '';
//try {
//	$connection = new PDO($dsn, $username, $password);
//	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//	throw new Exception('Connection failed: ' . $e->getMessage());
//}
//$stmt = $connection->prepare("INSERT INTO addresses (address, private_key) VALUES (:address, :private_key)");
//
//for ($i = 0; $i < 100; $i++) {
//	$bitcoinECDSA = new BitcoinECDSA();
//	$bitcoinECDSA->generateRandomPrivateKey(md5(rand(0, PHP_INT_MAX)));
//	$stmt->execute([':address' => $bitcoinECDSA->getAddress(), ':private_key' => $bitcoinECDSA->getPrivateKey()]);
//}
