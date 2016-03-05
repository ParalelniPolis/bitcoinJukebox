<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class QueueProducer implements MessageComponentInterface {

	protected $clients;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
		echo "created\n";
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach($conn);

		var_dump($conn);
		echo "New connection! ({$conn->resourceId})\n";

		$songsDir = '/bitcoinJukebox/songs';
		$song1 = new \stdClass();
		$song1->name = '11_blutengel-lucifer.mp3';
		$song1->location = $songsDir. '/' . '13b6f480-4703-4380-9dfe-81f968f6a0ca';
		$song2 = new \stdClass();
		$song2->name = '01_blutengel-no_eternity-fwyh.mp3';
		$song2->location = $songsDir. '/' . '73a55de1-5602-4f49-9446-5eb795612efd';
		$songData = [$song1, $song2];
		foreach ($this->clients as $client) {
			$data = json_encode($songData);
			$client->send($data);
			echo "sending: " . $data . PHP_EOL;
		}
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		$numRecv = count($this->clients) - 1;
		echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
			, $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

		$from->send($msg);
		$i = 0;
		while (true) {
			$from->send($i++);
			$from->close();
			echo $i . PHP_EOL;
			sleep(1);
		}

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