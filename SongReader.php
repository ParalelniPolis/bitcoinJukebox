<?php

/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 21. 3. 2016
 * Time: 17:39
 */
class SongReader
{

	/** @var string */
	private $duration;

	/** @var string */
	private $author;

	/** @var string */
	private $title;

	/**
	 * Song constructor.
	 * @param string $path
	 */
	public function __construct(string $path)
	{
		$this->loadInfo($path);
	}

	private function loadInfo(string $path)
	{
		$getID3 = new getID3();
		$info = $getID3->analyze($path);
		$this->author = $info['tags']['id3v1']['artist'][0] ?? null;
		$this->title = $info['tags']['id3v1']['title'][0] ?? null;
		$this->duration = $info['playtime_string'] ?? null;
	}

	/**
	 * @return string
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

}