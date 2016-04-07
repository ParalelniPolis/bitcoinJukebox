<?php

namespace App\Model;

use App\Model\Entity\Address;
use \BitcoinPHP\BitcoinECDSA\BitcoinECDSA;
use BitWasp\BitcoinLib\BIP32;
use Doctrine\ORM\AbstractQuery;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use PDO;
use PDOException;
use Tracy\Debugger;

class AddressProvider
{

	/** @var double */
	private $occupiedAddressesTreshold;

	/** @var double */
	private $increaseRatio;

	/** @var string */
	private $addressLockTime;

	/** @var string */
	private $masterKey;

	/** @var EntityManager */
	private $entityManager;

	/** @var EntityRepository */
	private $addressRepository;

	public function __construct(EntityManager $entityManager, string $masterKey, string $addressLockTime)
	{
		$this->occupiedAddressesTreshold = 0.9;
		$this->increaseRatio = 0.1;
		$this->addressLockTime = $addressLockTime;
		$this->masterKey = $masterKey;
		$this->entityManager = $entityManager;
		$this->addressRepository = $entityManager->getRepository(Address::getClassName());
	}

	public function getFreeAddress() : Address
	{
		$this->entityManager->beginTransaction();

		$addressMaxAge = new \DateTime($this->addressLockTime);

		$qb = $this->addressRepository->createQueryBuilder('address');
		$qb->addSelect('count(address) as free')
			->where('address.lastUsed IS NULL')
			->orWhere('address.lastUsed < :maxAge')
			->setParameter('maxAge', $addressMaxAge)
			->setMaxResults(1);

		/** @var Address $address */
		$result = $qb->getQuery()->getSingleResult();
		$address = $result[0];
		$free = $result['free'];
		$address->useAddress();
		$this->entityManager->flush($address);

		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('COUNT(address) AS total')
			->from(Address::getClassName(), 'address');

		$total = $qb->getQuery()->getSingleScalarResult();
		$occupied = $total - $free;
		if (($occupied / $total) >= $this->occupiedAddressesTreshold) {
			$this->generateAndPersistNewAddresses(round($total * $this->increaseRatio));
		}

		$this->entityManager->commit();
		return $address;
	}

	private function generateAndPersistNewAddresses(int $count)
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('MAX(address.bip32index)')
			->from(Address::getClassName(), 'address');
		$index = (int) $qb->getQuery()->getSingleScalarResult();
		for ($i = 0; $i < $count; $i++) {
			list($address, $index) = $this->generateNewAddress($index);
			$addressEntity = new Address($address, $index);
			$this->entityManager->persist($addressEntity);
		}
		$this->entityManager->flush();
	}

	private function generateNewAddress(int $lastIndex) : array
	{
		$lastIndex++;
		$master = $this->masterKey;
		$address = BIP32::build_address($master, "m/44'/0'/0'/0/$lastIndex")[0];
		return [$address, $lastIndex];
	}
}
