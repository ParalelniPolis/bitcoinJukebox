<?php

require_once __DIR__ . '/../../SongReader.php';

/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 14. 3. 2016
 * Time: 15:46
 */
class Song implements JsonSerializable
{
	/** @var string */
	private $name;

	/** @var string */
	private $location;

	/** @var string */
	private $duration;

	/** @var string */
	private $author;

	/** @var string */
	private $title;

	/** @var string */
	private $albumCover;

	/**
	 * Song constructor.
	 * @param string $name
	 * @param string $location
	 * @param string $path
	 * @param string $albumCover
	 */
	public function __construct(string $name, string $location, string $path, string $albumCover)
	{
		$this->name = \Nette\Utils\Strings::fixEncoding($name);
		$this->location = $location;
		$this->albumCover = $albumCover;
		$songReader = new SongReader($path);
		$this->author = $songReader->getAuthor();
		$this->title = $songReader->getTitle();
		$this->duration = $songReader->getDuration();
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getLocation()
	{
		return $this->location;
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

	/**
	 * @return string
	 */
	public function getAlbumCover()
	{
		return $this->albumCover;
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	function jsonSerialize()
	{
		return [
			'location' => $this->location,
			'title' => $this->title,
			'author' => $this->author,
			'duration' => $this->duration,
			'album_cover' => $this->albumCover
		];
	}
}