<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/TransactionReader.php';

if (!file_exists(__DIR__ . '/../../adminAndMobile/app/config/config.local.neon')) {
	die('Configuration file config.local.neon is missing!');
}

if (!file_exists(__DIR__ . '/../../adminAndMobile/app/config/config.neon')) {
	die('Configuration file config.neon is missing!');
}

$config1 = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.neon'));
$config2 = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.local.neon'));
$config = \Nette\Utils\Arrays::mergeTree($config1, $config2);

$host = $config['parameters']['host'];
$dbName = $config['parameters']['dbname'];
$username = $config['parameters']['user'];
$password = $config['parameters']['password'] ?? '';
$addressLockTime = $config['parameters']['addressLockTime'];
$port = $config['doctrine']['port'];

$reader = new TransactionReader($host, $dbName, $username, $password, $addressLockTime, $port);
$reader->run();
//$reader->transactionReceived('12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ');
