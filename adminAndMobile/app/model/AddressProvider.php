<?php

namespace App\Model;

use \BitcoinPHP\BitcoinECDSA\BitcoinECDSA;
use Nette\Database\Context;
use Nette\Database\SqlLiteral;
use PDO;
use PDOException;
use Tracy\Debugger;

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

	/** @var Context */
	private $database;

	public function __construct(Context $database)
	{
		$this->occupiedAddressesTreshold = 0.9;
		$this->increaseRatio = 0.1;
		$this->addressLockTime = "- 10 minutes";
		$this->database = $database;
	}

	public function getFreeAddress()
	{
		$addressMaxAge = new \DateTime("- 10 minutes");
		$address = $this->database->table('addresses')->where('NOT(last_used IS NOT NULL AND last_used > ?)', $addressMaxAge->format("Y-m-d H:i:s"))->limit(1)->fetchField('address');
		Debugger::barDump($address, 'address');
		$this->database->table('addresses')->where('address = ?', $address)->update(['last_used' => new SqlLiteral('NOW()')]);
		$res = $this->database->table('addresses')->select(new SqlLiteral('SUM(last_used IS NOT NULL AND last_used > ?) AS occupied, COUNT(*) AS total'), $addressMaxAge->format("Y-m-d H:i:s"))->fetch();
		$occupied = $res['occupied'];
		$total = $res['total'];
		if (($occupied / $total) >= $this->occupiedAddressesTreshold) {
//			$this->generateNewAddresses(round($total * $this->increaseRatio));
		}
		return $address;
	}

	private function generateNewAddresses(int $count)
	{
		//TODO: generate only addresses without private keys, using BIP32
//		$stmt = $this->connection->prepare("INSERT INTO addresses (address, private_key) VALUES (:address, :private_key)");
//
//		for ($i = 0; $i < $count; $i++) {
//			$address = new BitcoinECDSA();
//			$address->generateRandomPrivateKey(md5(rand(0, PHP_INT_MAX)));
//			$stmt->execute([':address' => $address->getAddress(), ':private_key' => $address->getPrivateKey()]);
//		}

	}

}