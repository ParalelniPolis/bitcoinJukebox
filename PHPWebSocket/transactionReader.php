<?php

require('vendor/autoload.php');

class TransactionReader {

	/** @var \React\EventLoop\StreamSelectLoop */
	private $loop;

	/** @var \Devristo\Phpws\Client\WebSocket */
	private $client;

	/** @var \Zend\Log\Logger */
	private $logger;

	/** @var string[] */
	private $addresses;

	public function __construct()
	{
		$this->loop = \React\EventLoop\Factory::create();
		$this->logger = new \Zend\Log\Logger();
		$writer = new Zend\Log\Writer\Stream("php://output");
		$this->logger->addWriter($writer);

		$options = [];
		$options['ssl']['local_cert'] = "democert.pem";
		$options['ssl']['allow_self_signed'] = true;
		$options['ssl']['verify_peer'] = false;

		$this->client = new \Devristo\Phpws\Client\WebSocket("wss://ws.blockchain.info/inv", $this->loop, $this->logger, $options);

		$this->addresses = [];
		$this->initClient();
		$this->connectToDatabase();
		$this->loadAddresses();
	}

	private function initClient()
	{
		$this->client->on("connect", function() {
			$this->logger->notice("Connected to websocket.");
			$this->client->send('{"op":"unconfirmed_sub"}');
		});

		$this->client->on("message", function(\Devristo\Phpws\Messaging\WebSocketMessage $message) {
			$data = json_decode($message->getData(), true);
			$output = $data['x']['out'];
			foreach ($output as $receiver) {
				if (!isset($receiver['addr'])) { //some outputs does not have address, dafuq?
					continue;
				}
				$address = $receiver['addr'];
				if (in_array($address, $this->addresses)) {
					$this->transactionReceived($address);
				}
			}
		});
	}

	private function connectToDatabase()
	{
		$host = 'localhost';
		$dbName = 'jukebox';
		$username = 'root';
		$password = '';

		$dsn = 'mysql:dbname=' . $dbName . ';host=' . $host . '';

		try {
			$pdo = new PDO($dsn, $username, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die('Connection failed: ' . $e->getMessage());
		}
	}

	private function transactionReceived(string $address)
	{
		//TODO: implement
	}

	private function loadAddresses()
	{
		//TODO: implement
		for ($i = 0; $i < 1000; $i++) {
			$addresses[] = md5($i);
		}
	}

	public function run()
	{
		$this->client->open();
		$this->loop->run();
	}

}
