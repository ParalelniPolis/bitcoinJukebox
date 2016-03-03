<?php

namespace App\Model;

use \BitcoinPHP\BitcoinECDSA\BitcoinECDSA;
use BitWasp\BitcoinLib\BIP32;
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

	/** @var string */
	private $masterKey;

	/** @var string */
	private $lastIndexFile;

	public function __construct(Context $database, $masterKey, $lastIndexFile)
	{
		$this->occupiedAddressesTreshold = 0.9;
		$this->increaseRatio = 0.1;
		$this->addressLockTime = "- 10 minutes";
		$this->database = $database;
		$this->masterKey = $masterKey;
		$this->lastIndexFile = $lastIndexFile;
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
			$this->generateAndPersistNewAddresses(round($total * $this->increaseRatio));
		}
		return $address;
	}

	private function generateAndPersistNewAddresses(int $count)
	{
		$return = $this->database->table('addresses')->select('MAX(bip32index) AS maxIndex')->fetch();
		$index = $return['maxIndex'];
		for ($i = 0; $i < $count; $i++) {
			list($address, $index) = $this->generateNewAddress($index);
			$this->database->getConnection()->query('INSERT INTO addresses', [
				'address' => $address,
				'bip32index' => $index
			]);
		}
	}

	private function generateNewAddress(int $lastIndex) : array
	{
		$lastIndex++;
		$master = $this->masterKey;
		$address = BIP32::build_address($master, $lastIndex)[0];
		return [$address, $lastIndex];
	}
}
