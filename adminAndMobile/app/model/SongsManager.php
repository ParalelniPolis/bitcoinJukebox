<?php

namespace App\Model;

require_once 'C:\xampp\htdocs\bitcoinJukebox\adminAndMobile\vendor\james-heinrich\getid3\getid3\getid3.php';
require_once 'C:\xampp\htdocs\bitcoinJukebox\adminAndMobile\vendor\james-heinrich\getid3\getid3\write.php';

use App\Model\Entity\File;
use App\Model\Entity\Genre;
use App\Model\Entity\Song;
use Doctrine\DBAL\DBALException;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Http\FileUpload;
use Nette\InvalidStateException;
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

	/** @var AlbumCoverProvider */
	private $albumCoverProvider;

	public function __construct(EntityManager $entityManager, AlbumCoverProvider $albumCoverProvider, string $songsDirectory)
	{
		$this->entityManager = $entityManager;
		$this->songsDirectory = $songsDirectory;
		$this->albumCoverProvider = $albumCoverProvider;
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
		$songs = $this->songRepository->findAll();
		foreach ($songs as $song) {
			$this->processSong($song);
		}
		$this->entityManager->flush();
		return $songs;
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

	/**
	 * @param File $file
	 * @param string|null $genreId
	 * @param bool $copy
	 * @return bool returns true if file already exists
	 * @throws \Exception
	 */
	private function addSong(File $file, string $genreId = null, $copy = false) : bool
	{
		if ($this->songExists($file->getDestination())) {
			return true;
		}

		$albumURL = $this->albumCoverProvider->getAlbumCoverURL($file->getDestination());
		if ($genreId) {
			$genre = $this->genresRepository->find($genreId);
		} else {
			$genre = null;
		}
		$song = new Song($file->getName(), $albumURL, $genre);
		$this->entityManager->persist($song);
		$this->entityManager->flush($song);
		$destination = $this->getSongPath($song->getId());
		if ($copy) {
			$file->copy($destination);
		} else {
			$file->move($destination);
		}

		$this->processSong($song);
		return false;
	}

	public function addSongFromHTTP(FileUpload $file, string $genreId = null) : bool
	{
		return $this->addSong(File::fromFileUpload($file), $genreId);
	}

	public function addSongFromCLI(\SplFileInfo $file, string  $genreName = null)
	{
		$genreId = $this->genresRepository->findOneBy(['name' => $genreName])->getId();
		$this->addSong(File::fromSplFileInfo($file), $genreId, true);
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
		if (file_exists($this->getSongPath($song->getId()))) {    //deleting of file is after database delete due to exceptions
			unlink($this->getSongPath($song->getId()));
		}
		return $song->getName();
	}

	/**
	 * @param string $songId
	 * @return \string[]
	 */
	public function getSongPathAndName(string $songId) : array
	{
		/** @var Song $song */
		$song = $this->songRepository->find($songId);
		return [$this->getSongPath($songId), $song->getName()];
	}

	private function getSongPath(string $songId) : string
	{
		return "$this->songsDirectory/$songId";
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

	private function songExists(string $filename) : bool
	{
		//todo: možná v budoucnu ukládat hash do databáze
		$hash = md5_file($filename);
		/** @var \SplFileInfo $song */
		foreach (Finder::findFiles('*')->from($this->songsDirectory) as $song) {
			if (md5_file($song->getRealPath()) === $hash) {
				return true;
			}
		}
		return false;
	}

	private function addSongMetadata(Song $song)
	{
		$songReader = new \SongReader($this->getSongPath($song->getId()));
		$song->loadMetadata($songReader);
	}

	private function processSong(Song $song)
	{
		//format name
		$name = $song->getName();
		//remove starting dot
		if (Strings::startsWith($name, '.')) {
			$name = Strings::substring($name, 1);
		}
		if (Strings::startsWith($name, ' ')) {
			$name = Strings::substring($name, 1);
		}
		//change underscore to space
		if (Strings::contains($name, '_-_')) {
			$name = Strings::replace($name, '~_-_~', '-');
		}
		$name = Strings::replace($name, '~_~', ' ');
		//end of format name

		$song->setName($name);
		//load metadata from name
		if (!$song->hasMetadata()) {
			$this->addGetID3tags($song);
			$this->addSongMetadata($song);
		}
	}

	private function addGetID3tags(Song $song)
	{
		preg_match('~(?P<artist>.+)-[\d]+-(?P<title>.+)~', $song->getName(), $matches);

		if (!isset($matches['artist']) || !isset($matches['title']) ) {
			return;
		}

		$artist = $matches['artist'];
		$title = $matches['title'];

		$mp3_tagformat = 'UTF-8';
		$mp3_handler = new \getID3();
		$mp3_handler->setOption(array('encoding'=>$mp3_tagformat));
		$mp3_writter = new \getid3_writetags();
		$mp3_writter->filename       = $this->getSongPath($song->getId());
		$mp3_writter->tagformats     = array('id3v1', 'id3v2.3');
		$mp3_writter->overwrite_tags = true;
		$mp3_writter->tag_encoding   = $mp3_tagformat;
		$mp3_writter->remove_other_tags = false;

		$mp3_data['title'][]   = $title;
		$mp3_data['artist'][]  = $artist;

		$mp3_writter->tag_data = $mp3_data;
		$mp3_writter->WriteTags();
	}

}

class CantDeleteException extends \Exception {}