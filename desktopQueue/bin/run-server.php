<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/QueueProducer.php';
require __DIR__ . '/../app/TransactionReader.php';

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
$songsDirectory = $config['parameters']['songsDir'];
$webSongsDir = \Nette\Utils\Strings::replace($songsDirectory, '~%wwwDir%/../../~', '');
$songsDirectory = \Nette\Utils\Strings::replace($songsDirectory, '~%wwwDir%~', __DIR__ . '/../../adminAndMobile/www');

echo $songsDirectory . PHP_EOL;
$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new QueueProducer($host, $dbName, $username, $password, $songsDirectory, $webSongsDir)
		)
	),
	8080
);

$server->run();

//$producer = new QueueProducer($host, $dbName, $username, $password);
//$producer->songProvider->getRandomSong(1);