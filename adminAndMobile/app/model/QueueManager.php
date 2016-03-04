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

	/** @var SongsManager */
	private $songsManager;

	public function __construct(EntityManager $entityManager, SongsManager $songsManager)
	{
		$this->entityManager = $entityManager;
		$this->songsManager = $songsManager;
	}

	public function addSongs(array $songIds, Address $address)
	{
		$songEntities = [];
		$songs = $this->songsManager->getSongsWithIds($songIds);
		foreach ($songIds as $songId) {
			$songEntity = new QueueSong($songs[$songId], $address);
			$this->entityManager->persist($songEntity);
			$songEntities[] = $songEntity;
		}
		$this->entityManager->flush($songEntities);
	}

}
