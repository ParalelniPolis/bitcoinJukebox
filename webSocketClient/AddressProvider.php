<?php

use \BitcoinPHP\BitcoinECDSA\BitcoinECDSA;

class AddressProvider
{

	/** @var PDO */
	private $connection;

	/** @var double */
	private $occupiedAddressesTreshold;

	/** @var double */
	private $increaseRatio;

	/** @var string */
	private $addressLockTime;

	public function __construct(string $host, string $dbName, string $username, string $password)
	{
		$this->occupiedAddressesTreshold = 0.9;
		$this->increaseRatio = 0.3;
		$this->addressLockTime = "- 10 minutes";
		$this->connectToDatabase($host, $dbName, $username, $password);
	}

	private function connectToDatabase(string $host, string $dbName, string $username, string $password)
	{
		$dsn = "mysql:dbname=$dbName;host=$host";

		try {
			$this->connection = new PDO($dsn, $username, $password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}

	public function getFreeAddress()
	{
		$addressMaxAge = new DateTime("- 10 minutes");
		$stmt = $this->connection->prepare('SELECT address FROM addresses WHERE NOT(last_used IS NOT NULL AND last_used > :time) LIMIT 1');
		$stmt->execute([':time' => $addressMaxAge->format("Y-m-d H:i:s")]);
		$address = $stmt->fetch(PDO::FETCH_COLUMN);
		$stmt = $this->connection->prepare('UPDATE addresses SET last_used = NOW() WHERE address = :address');
		$stmt->execute([':address' => $address]);
		$stmt = $this->connection->prepare('SELECT SUM(last_used IS NOT NULL AND last_used > :time) AS occupied, COUNT(*) AS total FROM addresses');  //query returning ratio of used addresses
		$stmt->execute([':time' => $addressMaxAge->format("Y-m-d H:i:s")]);
		list($occupied, $total) = $stmt->fetch(PDO::FETCH_BOTH);
		if (($occupied / $total) >= $this->occupiedAddressesTreshold) {
			$this->generateNewAddresses(round($total * $this->increaseRatio));
		}
		return $address;
	}

	private function generateNewAddresses(int $count)
	{
		$stmt = $this->connection->prepare("INSERT INTO addresses (address, private_key) VALUES (:address, :private_key)");

		for ($i = 0; $i < $count; $i++) {
			$address = new BitcoinECDSA();
			$address->generateRandomPrivateKey(md5(rand(0, PHP_INT_MAX)));
			$stmt->execute([':address' => $address->getAddress(), ':private_key' => $address->getPrivateKey()]);
		}

	}

}