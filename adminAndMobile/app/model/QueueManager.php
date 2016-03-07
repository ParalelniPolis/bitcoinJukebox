<?php

namespace App\Model;
 
use App\Model\Entity\Address;
use App\Model\Entity\Order;
use App\Model\Entity\QueueSong;
use App\Model\Entity\Song;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class QueueManager extends Nette\Object
{

	/** @var EntityManager */
	private $entityManager;

	/** @var SongsManager */
	private $songsManager;

	/** @var GenresManager */
	private $genresManager;

	/** @var string */
	private $currentGenreFile;

	public function __construct(EntityManager $entityManager, SongsManager $songsManager, GenresManager $genresManager, string $currentGenreFile)
	{
		$this->entityManager = $entityManager;
		$this->songsManager = $songsManager;
		$this->genresManager = $genresManager;
		$this->currentGenreFile = $currentGenreFile;
	}

	public function orderSongs(array $songIds, float $price, Address $address)
	{
		$songEntities = [];
		$order = new Order($price, $address);
		$songEntities[] = $order;
		$this->entityManager->persist($order);
		$songs = $this->songsManager->getSongsWithIds($songIds);
		foreach ($songIds as $songId) {
			$songEntity = $this->orderSong($songs[$songId], $order);
			$songEntities[] = $songEntity;
		}
		$this->entityManager->flush($songEntities);
	}

	public function orderGenre(string $genreId, float $price, Address $address)
	{
		$songEntities = [];
		//genre order is order of random song from given genre and setting of given genre as genre to be played when queue is empty
		//current genre is saved as genreId in file, because it is simple and fast
		$order = new Order($price, $address);
		$this->entityManager->persist($order);
		$songEntities[] = $order;
		$genre = $this->genresManager->getGenre($genreId);
		$song = $this->songsManager->getRandomSong($genre);
		$songEntities[] = $this->orderSong($song, $order);
		$this->entityManager->flush($songEntities);
		file_put_contents($this->currentGenreFile, $genreId);
	}

	private function orderSong(Song $song, Order $order) : QueueSong
	{
		$songEntity = new QueueSong($song, $order);
		$this->entityManager->persist($songEntity);
		return $songEntity;
	}
}
