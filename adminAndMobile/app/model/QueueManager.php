<?php

namespace App\Model;
 
use App\Model\Entity\Address;
use App\Model\Entity\QueueSong;
use Kdyby\Doctrine\EntityManager;
use Nette;
 
class QueueManager extends Nette\Object
{

	/** @var EntityManager */
	private $entityManager;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function addSongs(array $songs, Address $address)
	{
		$songEntities = [];
		foreach ($songs as $song) {
			$songEntity = new QueueSong($song, $address);
			$this->entityManager->persist($songEntity);
			$songEntities[] = $songEntity;
		}
		$this->entityManager->flush($songEntities);
	}

}
