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

	public function addSong(FileUpload $file, string $genre = null)
	{
		$destination = $this->songsDirectory;
		if ($genre != null) {
			$destination .= "/$genre";
		}
		$file->move($destination . "/" . $file->getName());
	}

}