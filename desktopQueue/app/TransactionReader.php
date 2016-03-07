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
		$this->addressLockTime = "- 20 minutes";
//		$this->addressLockTime = "- 10 days";            //for testing purposes
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
		$addressMaxAge = new \DateTime($this->addressLockTime);

		$stmt = $this->connection->prepare('SELECT id FROM orders WHERE address = :address AND ordered > :maxAge AND paid = FALSE');
		$stmt->execute([':address' => $address, ':maxAge' => $addressMaxAge->format("Y-m-d H:i:s")]);
		$orderId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

		//TODO: dohodnout se, zda zde má být kontrola zaplacení správné částky a co se stane, pokud je částka menší
		$stmt = $this->connection->prepare('UPDATE orders SET paid = TRUE WHERE address = :address AND ordered > :maxAge AND paid = FALSE');
		$stmt->execute([':address' => $address, ':maxAge' => $addressMaxAge->format("Y-m-d H:i:s")]);


		echo $orderId . PHP_EOL;
		$stmt = $this->connection->prepare('UPDATE queue SET paid = TRUE WHERE order_id = :id');
		$stmt->execute([':id' => $orderId]);
	}

	private function loadAddresses()
	{
		//TODO: dohodnout se, zda načítat jen rezervované platby nebo všechny
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