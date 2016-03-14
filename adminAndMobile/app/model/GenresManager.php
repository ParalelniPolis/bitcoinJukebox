<?php

namespace App\Model;

use App\Model\Entity\Genre;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Object;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;
use Tracy\Debugger;

class GenresManager extends Object
{

	/** @var string */
	private $songsDirectory;

	/** @var EntityManager */
	private $entityManager;

	/** @var EntityRepository */
	private $genreRepository;

	public function __construct(EntityManager $entityManager, string $songsDirectory)
	{
		$this->entityManager = $entityManager;
		$this->songsDirectory = $songsDirectory;
		$this->genreRepository = $entityManager->getRepository(Genre::getClassName());
	}

	public function countAllGenres() : int
	{
		return $this->genreRepository->countBy([]);
	}

	/**
	 * @return Genre[]
	 */
	public function getAllGenres() : array
	{
		return $this->genreRepository->findAll();
	}

	/**
	 * @return string[]
	 */
	public function getAllGenreNames() : array
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('g.name')->from(Genre::getClassName(), 'g');
		return array_column($qb->getQuery()->getScalarResult(), 'name');
	}

	/**
	 * @return string[]
	 */
	public function getAllGenreIdsAndNames() : array
	{
		return $this->genreRepository->findPairs([], 'name');
	}

	public function addGenre(string $name)
	{
		$genre = new Genre($name);
		$this->entityManager->persist($genre);
		$this->entityManager->flush($genre);
	}

	public function getGenre(int $id) : Genre
	{
		return $this->genreRepository->find($id);
	}
}