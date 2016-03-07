<?php

namespace App\Model;
 
use App\Model\Entity\Address;
use App\Model\Entity\Order;
use App\Model\Entity\QueueSong;
use Kdyby\Doctrine\EntityManager;
use Nette;
 
class QueueManager extends Nette\Object
{

	/** @var EntityManager */
	private $entityManager;

	/** @var SongsManager */
	private $songsManager;

	public function __construct(EntityManager $entityManager, SongsManager $songsManager)
	{
		$this->entityManager = $entityManager;
		$this->songsManager = $songsManager;
	}

	public function orderSongs(array $songIds, float $price, Address $address)
	{
		$songEntities = [];
		$order = new Order($price, $address);
		$songEntities[] = $order;
		$this->entityManager->persist($order);
		$songs = $this->songsManager->getSongsWithIds($songIds);
		foreach ($songIds as $songId) {
			$songEntity = new QueueSong($songs[$songId], $order);
			$this->entityManager->persist($songEntity);
			$songEntities[] = $songEntity;
		}
		$this->entityManager->flush($songEntities);
	}

	public function orderGenre(string $genreId, float $price, Address $address)
	{
		//TODO: implementovat objednávku žánru
//		$songEntities = [];
//		$order = new Order($price, $address);
//		$songEntities[] = $order;
//		$this->entityManager->persist($order);
//		$songs = $this->songsManager->getSongsWithIds($songIds);
//		foreach ($songIds as $songId) {
//			$songEntity = new QueueSong($songs[$songId], $order);
//			$this->entityManager->persist($songEntity);
//			$songEntities[] = $songEntity;
//		}
//		$this->entityManager->flush($songEntities);
	}

}
