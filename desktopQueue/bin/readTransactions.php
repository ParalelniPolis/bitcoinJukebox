<?php

require_once '../vendor/autoload.php';
require_once '../app/TransactionReader.php';

$config1 = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.neon'));
$config2 = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.local.neon'));
$config = \Nette\Utils\Arrays::mergeTree($config1, $config2);

$host = $config['parameters']['host'];
$dbName = $config['parameters']['dbname'];
$username = $config['parameters']['user'];
$password = $config['parameters']['password'] ?? '';
$addressLockTime = $config['parameters']['addressLockTime'];

$reader = new TransactionReader($host, $dbName, $username, $password, $addressLockTime);
$reader->run();
//$reader->transactionReceived('12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ');
