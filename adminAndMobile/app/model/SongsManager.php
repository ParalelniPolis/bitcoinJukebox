<?php

namespace App\Model;

use App\Model\Entity\Genre;
use App\Model\Entity\Song;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Http\FileUpload;
use Nette\Object;
use Nette\Utils\Finder;

class SongsManager extends Object
{

	/** @var string */
	private $songsDirectory;

	/** @var EntityManager */
	private $entityManager;

	/** @var EntityRepository */
	private $songRepository;

	/** @var EntityRepository */
	private $genresRepository;

	public function __construct(EntityManager $entityManager, string $songsDirectory)
	{
		$this->entityManager = $entityManager;
		$this->songsDirectory = $songsDirectory;
		$this->songRepository = $entityManager->getRepository(Song::getClassName());
		$this->genresRepository = $entityManager->getRepository(Genre::getClassName());
	}

	public function countAllSongs() : int
	{
		return $this->songRepository->countBy([]);
	}

	/**
	 * @param string|null $genre
	 * @return Song[]
	 */
	public function getSongs(string $genre = null) : array
	{
		return $this->songRepository->findBy(['genre' => $genre]);
	}

	/**
	 * @return Song[]
	 */
	public function getAllSongs() : array
	{
		return $this->songRepository->findAll();
	}

	/**
	 * @return int[]
	 */
	public function getSongIds() : array
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('s.id')->from(Song::getClassName(), 's');
		return array_column($qb->getQuery()->getScalarResult(), 'id');
	}

	public function addSong(FileUpload $file, string $genreName = null)
	{
		if ($genreName) {
			$genre = $this->genresRepository->find($genreName);
		} else {
			$genre = null;
		}
		$song = new Song($file->getName(), $genre);
		$this->entityManager->persist($song);
		$this->entityManager->flush($song);
		$file->move($this->songsDirectory . "/" . $song->getHash());
	}

	public function deleteSong(string $songId) : string
	{
		/** @var Song $song */
		$song = $this->songRepository->find($songId);
		if (file_exists($this->songsDirectory . '/' . $song->getHash())) {
			unlink($this->songsDirectory . '/' . $song->getHash());
		}
		$this->entityManager->remove($song);
		$this->entityManager->flush($song);
		return $song->getName();
	}

	/**
	 * @param string $songId
	 * @return string[]
	 */
	public function getSongPath(string $songId) : array
	{
		/** @var Song $song */
		$song = $this->songRepository->find($songId);
		$destination = $this->songsDirectory;
		return [$destination . "/" . $song->getHash(), $song->getName()];
	}
}