<?php

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

	/**
	 * Song constructor.
	 * @param string $name
	 * @param string $location
	 */
	public function __construct($name, $location, $path)
	{
		$this->name = \Nette\Utils\Strings::fixEncoding($name);
		$this->location = $location;
		$this->loadInfo($path);
	}

	private function loadInfo(string $path)
	{
		$getID3 = new getID3;
//		var_dump($path);
		$info = $getID3->analyze($path);
//		var_dump($info);
		$this->author = $info['tags']['id3v1']['artist'][0];
		$this->title = $info['tags']['id3v1']['title'][0];
		$this->duration = $info['playtime_seconds'];
		var_dump($this);
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
			'duration' => $this->duration
		];
	}
}