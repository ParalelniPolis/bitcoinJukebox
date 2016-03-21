<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/QueueProducer.php';
require __DIR__ . '/../app/TransactionReader.php';

$config1 = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.neon'));
$config2 = \Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.local.neon'));
$config = \Nette\Utils\Arrays::mergeTree($config1, $config2);

$host = $config['parameters']['host'];
$dbName = $config['parameters']['dbname'];
$username = $config['parameters']['user'];
$password = $config['parameters']['password'] ?? '';

$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new QueueProducer($host, $dbName, $username, $password)
		)
	),
	8080
);

$server->run();

//$producer = new QueueProducer($host, $dbName, $username, $password);
//$producer->songProvider->getRandomSong(1);