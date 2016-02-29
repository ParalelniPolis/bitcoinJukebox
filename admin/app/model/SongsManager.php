<?php

namespace App\Model;

use Nette\Http\FileUpload;
use Nette\Object;
use Nette\Utils\Finder;

class SongsManager extends Object
{

	/** @var string */
	private $songsDirectory;

	public function __construct(string $songsDirectory)
	{
		$this->songsDirectory = $songsDirectory;
	}

	public function countAllSongs() : int
	{
		return Finder::findFiles('*')->from($this->songsDirectory)->count();
	}

	public function getSongs(string $genre = null) : array
	{
		$directory = $this->songsDirectory;
		if ($genre) {
			$directory .= "/$genre";
		}
		/** @var string[] $songs */
		$songs = [];
		/** @var \SplFileInfo $song */
		foreach (Finder::findFiles('*')->from($directory) as $song) {
			$songs[] = $song->getBasename();
		}
		return $songs;
	}

	public function addSong(FileUpload $file, string $genre = null)
	{
		$destination = $this->songsDirectory;
		if ($genre != null) {
			$destination .= "/$genre";
		}
		$file->move($destination . "/" . $file->getName());
	}

	public function deleteSong($song, $genre = null)
	{
		$destination = $this->songsDirectory;
		if ($genre != null) {
			$destination .= "/$genre";
		}
		if (file_exists($destination . "/" . $song)) {
			unlink($destination . "/" . $song);
		}
	}

	public function getSongPath($song, $genre)
	{
		$destination = $this->songsDirectory;
		if ($genre != null) {
			$destination .= "/$genre";
		}
		return $destination . "/" . $song;
	}
}