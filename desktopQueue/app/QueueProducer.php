<?php

require_once 'SongProvider.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class QueueProducer implements MessageComponentInterface {

	/**
	 * @var SplObjectStorage|ConnectionInterface[]
	 */
	protected $clients;

	/** @var SongProvider */
	public $songProvider;

	/** @var string */
	private $currentGenreFile;

	public function __construct(string $host, string $dbName, string $username, string $password, string $songsDirectory, string $webSongsDir, int $port) {
		$this->songProvider = new SongProvider($host, $dbName, $username, $password, $songsDirectory, $webSongsDir, $port);
		$this->clients = new \SplObjectStorage;
		$this->currentGenreFile = __DIR__ . '/../../adminAndMobile/app/model/currentGenre.txt';
		echo "created\n";
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach($conn);

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		/** @var \stdClass[] $songData */
		$songData = [];
		if ($msg == 'getSongs') {
			$songData['songs'] = $this->songProvider->readNonProcessedSongs();
			echo "Sending songs data: " . PHP_EOL;
		} else if ($msg == 'emptyQueue') {
			$currentGenreId = file_get_contents($this->currentGenreFile);
			$songData['songs'] = [$this->songProvider->getRandomSong($currentGenreId)];    //abych měl jednoprvkové pole
			echo "Sending random song: " . PHP_EOL;
			//logic for random song picking
		}
		$songData['request'] = $msg;
		$data = \Nette\Utils\Json::encode($songData);
		echo 'data: ' . PHP_EOL;
		echo $data . PHP_EOL;
		$from->send($data);
	}

	public function onClose(ConnectionInterface $conn) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($conn);

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}

}