<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/QueueProducer.php';
require __DIR__ . '/../app/TransactionReader.php';


$host = 'localhost';
$dbName = 'jukebox';
$username = 'root';
$password = '';

//$reader = new TransactionReader($host, $dbName, $username, $password);
//$reader->run();


$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new QueueProducer()
		)
	),
	8080
);

$server->run();



$reader->transactionReceived('13ngDv9EgzAug92hheRgT3GGduZonXRqpW');