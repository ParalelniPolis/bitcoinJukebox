<?php

use React\EventLoop\Factory;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use React\EventLoop\StreamSelectLoop;
use Devristo\Phpws\Client\WebSocket;
use Devristo\Phpws\Messaging\WebSocketMessage;

class TransactionReader {

	/** @var StreamSelectLoop */
	private $loop;

	/** @var WebSocket */
	private $client;

	/** @var \Zend\Log\Logger */
	private $logger;

	/** @var string[] */
	private $addresses;

	/** @var PDO */
	private $connection;

	/** @var string */
	private $addressLockTime;

	public function __construct(string $host, string $dbName, string $username, string $password)
	{
		$this->addressLockTime = "- 10 minutes";
		$this->loop = Factory::create();
		$this->logger = new Logger();
		$fileWriter = new Stream("log.txt");
		$this->logger->addWriter($fileWriter);
		$consoleWriter = new Stream('php://output');
		$this->logger->addWriter($consoleWriter);

		$options = [];
		$options['ssl']['local_cert'] = "democert.pem";
		$options['ssl']['allow_self_signed'] = true;
		$options['ssl']['verify_peer'] = false;

		$this->client = new WebSocket("wss://ws.blockchain.info/inv", $this->loop, $this->logger, $options);

		$this->addresses = [];
		$this->initClient();
		$this->connectToDatabase($host, $dbName, $username, $password);
		$this->loadAddresses();
	}

	private function initClient()
	{
		$this->client->on("connect", function() {
			$this->logger->notice("Connected to websocket.");
			$this->client->send('{"op":"unconfirmed_sub"}');
		});

		$this->client->on("message", function(WebSocketMessage $message) {
			$data = json_decode($message->getData(), true);
			$output = $data['x']['out'];
			foreach ($output as $receiver) {
				if (!isset($receiver['addr'])) { //some outputs does not have address, dafuq?
					continue;
				}
				$address = $receiver['addr'];
//				$this->logger->notice($address);
				if (in_array($address, $this->addresses)) {
					$this->transactionReceived($address);
				}
			}
		});
	}

	private function connectToDatabase(string $host, string $dbName, string $username, string $password)
	{
		$dsn = "mysql:dbname=$dbName;host=$host";

		try {
			$this->connection = new PDO($dsn, $username, $password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->logger->notice("Connected to database.");
		} catch (PDOException $e) {
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}

	public function transactionReceived(string $address)
	{
		$this->logger->notice("Received transaction to address $address");
		$stmt = $this->connection->prepare('UPDATE addresses SET last_used = NULL WHERE address = :address');
		$stmt->execute([':address' => $address]);

		//TODO: dohodnout se, zda tu má být taky 10 minut
		$addressMaxAge = new \DateTime("- 10 minutes");

		$stmt = $this->connection->prepare('SELECT id, song FROM queue WHERE address = :address AND ordered > :maxAge');
		$stmt->execute([':address' => $address, ':maxAge' => $addressMaxAge->format("Y-m-d H:i:s")]);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$ids = array_column($result, 'id');
		$songIds = array_column($result, 'song');
		$stmt = $this->connection->prepare('UPDATE queue SET paid = TRUE WHERE id IN('. implode(',', $ids) . ')');
		$stmt->execute();       //na IN nějak nefunguje vkládání parametrů

		$quotedIds = array_map(function($id) {return $this->connection->quote($id);}, $songIds);
		$stmt = $this->connection->prepare('SELECT id, name FROM song WHERE id IN ('. implode(',', $quotedIds) . ')');
		$stmt->execute();

		$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// when address is sent to someone, time of usage will be stored. After transaction received to that address, null
		// shall be set instead of time. So free adresses are without time of usage.
		//TODO: implement pushing songs to websocket, send songs by websocket
	}

	private function loadAddresses()
	{
		/** @var PDOStatement $stmt */
		$stmt = $this->connection->prepare('SELECT address FROM addresses');
		$stmt->execute();
		$this->addresses = $stmt->fetchAll(PDO::FETCH_COLUMN);
	}

	public function run()
	{
		$this->client->open();
		$this->loop->run();
	}

}