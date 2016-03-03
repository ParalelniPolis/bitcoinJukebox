<?php

namespace App\Model;

use Nette\Object;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;

class GenresManager extends Object
{

	/** @var string */
	private $songsDirectory;

	public function __construct(string $songsDirectory)
	{
		$this->songsDirectory = $songsDirectory;
	}

	public function countAllGenres() : int
	{
		return Finder::findDirectories('*')->from($this->songsDirectory)->count();
	}

	/**
	 * @return string[]
	 */
	public function getAllGenres() : array
	{
		$genres = [];
		/** @var \SplFileInfo $directory */
		foreach (Finder::findDirectories('*')->from($this->songsDirectory) as $directory) {
			$genres[] = $directory->getBasename();
		}
		return $genres;
	}

	public function addGenre(string $name)
	{
		FileSystem::createDir($this->songsDirectory . "/$name");
	}

}