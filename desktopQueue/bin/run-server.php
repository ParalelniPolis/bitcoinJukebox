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

//$server = IoServer::factory(
//	new HttpServer(
//		new WsServer(
//			new QueueProducer($host, $dbName, $username, $password)
//		)
//	),
//	8080
//);
//
//$server->run();

$producer = new QueueProducer($host, $dbName, $username, $password);
$producer->songProvider->getRandomSong(1);