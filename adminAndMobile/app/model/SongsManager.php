<?php

namespace App\Model;

use App\Model\Entity\Genre;
use App\Model\Entity\Song;
use Doctrine\DBAL\DBALException;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Http\FileUpload;
use Nette\Object;
use Nette\Utils\Finder;
use Nette\Utils\Strings;
use Tracy\Debugger;

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
		$this->addFunctions();
	}

	private function addFunctions()
	{
		$emConfig = $this->entityManager->getConfiguration();
		$emConfig->addCustomNumericFunction('RAND', 'DoctrineExtensions\Query\Mysql\Rand');
	}

	public function countAllSongs() : int
	{
		return $this->songRepository->countBy([]);
	}

	/**
	 * @return Song[]
	 */
	public function getSongsWithoutGenre() : array
	{
		return $this->songRepository->findBy(['genre' => null]);
	}

	/**
	 * @param int $genreId
	 * @return Entity\Song[]|array
	 */
	public function getSongsByGenreId(int $genreId = null) : array
	{
		return $this->songRepository->findBy(['genre' => $genreId]);
	}

	/**
	 * @param string[] $songIds
	 * @return Song[]
	 */
	public function getSongsWithIds(array $songIds) : array
	{
		return $this->songRepository->findAssoc(['id' => $songIds], 'id');
	}

	/**
	 * @return Song[]
	 */
	public function getAllSongs() : array
	{
		return $this->songRepository->findAll();
	}

	/**
	 * @return string[]
	 */
	public function getSongIds() : array
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('s.id')->from(Song::getClassName(), 's');
		return array_column($qb->getQuery()->getScalarResult(), 'id');
	}

	/**
	 * @return string[]
	 */
	public function getSongAlphaNumericIds() : array
	{
		return array_map(function($id) {return Strings::replace($id, '~-~', '_');}, $this->getSongIds());
	}

	public function addSong(FileUpload $file, string $genreName = null)
	{
		if ($genreName) {
			$genre = $this->genresRepository->findOneBy(['name' => $genreName]);
		} else {
			$genre = null;
		}
		$song = new Song($file->getName(), $genre);
		$this->entityManager->persist($song);
		$this->entityManager->flush($song);
		$file->move($this->songsDirectory . "/" . $song->getId());
	}

	/**
	 * @param string $songId
	 * @return string
	 * @throws CantDeleteException
	 * @throws DBALException
	 */
	public function deleteSong(string $songId) : string
	{
		/** @var Song $song */
		$song = $this->songRepository->find($songId);
		if ($song === null) {
			throw new CantDeleteException('file does not exist');
		}
		$this->entityManager->remove($song);
		$this->entityManager->flush($song);
		if (file_exists($this->songsDirectory . '/' . $song->getId())) {    //deleting of file is after database delete due to exceptions
			unlink($this->songsDirectory . '/' . $song->getId());
		}
		return $song->getName();
	}

	/**
	 * @param string $songId
	 * @return \string[]
	 */
	public function getSongPath(string $songId) : array
	{
		/** @var Song $song */
		$song = $this->songRepository->find($songId);
		$destination = $this->songsDirectory;
		return [$destination . "/" . $song->getId(), $song->getName()];
	}

	public function getRandomSong(Genre $genre) : Song
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('song')
			->from(Song::getClassName(), 'song')
			->where('song.genre = :genre')
			->orderBy('RAND()')
			->setMaxResults(1)
			->setParameters(['genre' => $genre]);
		return $qb->getQuery()->getSingleResult();
	}
}

class CantDeleteException extends \Exception {}