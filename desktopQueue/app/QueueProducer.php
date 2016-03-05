<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class QueueProducer implements MessageComponentInterface {

	/**
	 * @var SplObjectStorage|ConnectionInterface[]
	 */
	protected $clients;

	/** @var PDO */
	private $connection;

	public function __construct(string $host, string $dbName, string $username, string $password) {
		$this->connectToDatabase($host, $dbName, $username, $password);
		$this->clients = new \SplObjectStorage;
		echo "created\n";
	}

	private function connectToDatabase(string $host, string $dbName, string $username, string $password)
	{
		$dsn = "mysql:dbname=$dbName;host=$host";

		try {
			$this->connection = new PDO($dsn, $username, $password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			echo "Connected to database." . PHP_EOL;
		} catch (PDOException $e) {
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach($conn);

		var_dump($conn);
		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		$numRecv = count($this->clients) - 1;
		echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
			, $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

		$songData = $this->readNonProcessedSongs();
		$data = \Nette\Utils\Json::encode($songData);
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

	private function readNonProcessedSongs() : array
	{
		$songsDir = '/bitcoinJukebox/songs';

		$stmt = $this->connection->prepare('SELECT song.id, song.name, queue.id AS queueId FROM song JOIN queue ON song.id = queue.song WHERE queue.paid = TRUE AND queue.proceeded = FALSE');
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		var_dump($result);

		$queueIds = array_column($result, 'queueId');

		$data = [];
		foreach ($result as $songData) {
			$song = new \stdClass();
			$song->name = \Nette\Utils\Strings::fixEncoding($songData['name']);
			$song->location = $songsDir. '/' . $songData['id'];
			$data[] = $song;
		}

		var_dump($data);

		if (count($queueIds) > 0) {
			$quotedIds = array_map(function($id) {return $this->connection->quote($id);}, $queueIds);
			$stmt = $this->connection->prepare('UPDATE queue SET proceeded = TRUE WHERE id IN ('. implode(',', $quotedIds) . ')');
			echo $stmt->queryString . PHP_EOL;
			$stmt->execute();
		}

		return $data;
	}
}