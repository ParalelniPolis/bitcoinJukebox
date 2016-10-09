<?php

use Nette\Neon\Neon;
use Nette\Utils\Arrays;
use Nette\Utils\Json;
use Zend\Log\Writer\Stream;
use \Zend\Log\Logger;
use \Nette\Utils\JsonException;
use Carbon\Carbon;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/SongProvider.php';

if (!file_exists(__DIR__ . '/../../adminAndMobile/app/config/config.local.neon')) {
	die('Configuration file config.local.neon is missing!');
}

if (!file_exists(__DIR__ . '/../../adminAndMobile/app/config/config.neon')) {
	die('Configuration file config.neon is missing!');
}

$config1 = Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.neon'));
$config2 = Neon::decode(file_get_contents(__DIR__ . '/../../adminAndMobile/app/config/config.local.neon'));
$config = Arrays::mergeTree($config1, $config2);

$host = $config['parameters']['host'];
$dbName = $config['parameters']['dbname'];
$username = $config['parameters']['user'];
$password = $config['parameters']['password'] ?? '';
$songsDirectory = $config['parameters']['songsDir'];
$port = $config['doctrine']['port'];
$webSongsDir = \Nette\Utils\Strings::replace($songsDirectory, '~%wwwDir%/../../~', '');
$songsDirectory = \Nette\Utils\Strings::replace($songsDirectory, '~%wwwDir%~', __DIR__ . '/../../adminAndMobile/www');
$currentGenreFile = __DIR__ . '/../../adminAndMobile/app/model/currentGenre.txt';
$sessionFile = __DIR__ . '/../../adminAndMobile/app/model/session.txt';

//session id reading, security check
$storedData = Json::decode(file_get_contents($sessionFile), Json::FORCE_ARRAY);
session_start();
$sessionId = session_id();
if ($storedData === []) {
	//save new session id
	$storedData['sessionId'] = $sessionId;
	$storedData['datetime'] = Carbon::now()->toAtomString();
} else {
	//security check, checking only to recent connection
	 $isSessionRecent = Carbon::now()->subHour()->lt(new Carbon($storedData['datetime']));
	if ($storedData['sessionId'] !== $sessionId && $isSessionRecent) {
		exit;
	}
	$storedData['sessionId'] = $sessionId;
	$storedData['datetime'] = Carbon::now()->toAtomString();
}

file_put_contents($sessionFile, Json::encode($storedData));
//end of security check

$songProvider = new SongProvider($host, $dbName, $username, $password, $songsDirectory, $webSongsDir, $port);
$msg = $_GET['request'];
if ($msg == 'getSongs') {
	$songData['songs'] = $songProvider->readNonProcessedSongs();
} else if ($msg == 'emptyQueue') {
	$currentGenreId = file_get_contents($currentGenreFile);
	$songData['songs'] = [$songProvider->getRandomSong($currentGenreId)];    //abych měl jednoprvkové pole
}
$songData['request'] = $msg;

$data = null;
try {
	$data = Json::encode($songData);
} catch(JsonException $e) {
//	$songs = $songData['songs'];
//	$songsString = '';
//	/** @var Song $song */
//	foreach ($songs as $song) {
//		$songData
//	}
	$logger = new Logger();
	$fileWriter = new Stream("log.txt");
	$logger->addWriter($fileWriter);
	$logger->err("Json encoding failed: reason:" . $e->getMessage());
	$logger->err('data: ' . implode(', ', Arrays::flatten($songData)));
}
echo $data;
