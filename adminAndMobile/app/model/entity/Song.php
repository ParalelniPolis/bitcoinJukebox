<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;
use Nette\Utils\Strings;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 */
class Song extends Entities\BaseEntity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid")
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @var \Ramsey\Uuid\Uuid
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="Genre", inversedBy="songs")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 * @var Genre
	 */
	private $genre;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $albumCover;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $artist;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $duration;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $hash;

    public function __construct(string $name, string $albumCover, string $hash, Genre $genre = null)
    {
	    $this->id = Uuid::uuid4();
    	$this->name = $name;
	    $this->albumCover = $albumCover;
	    $this->genre = $genre;
    }

	public function getId() : string
	{
		return $this->id->toString();
	}

	public function getAlphaNumericId() : string
	{
		return Strings::replace($this->getId(), '~-~', '_');
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getGenre() : Genre
	{
		return $this->genre;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @param string $artist
	 */
	public function setArtist($artist)
	{
		$this->artist = $artist;
	}

	public function loadMetadata(\SongReader $songReader)
	{
		$songReader->getTitle() ? $this->title = $songReader->getTitle() : null;
		$songReader->getAuthor() ? $this->artist = $songReader->getAuthor() : null;
		$songReader->getDuration() ? $this->duration = $songReader->getDuration() : null;
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
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @return string
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	public function hasMetadata() :bool
	{
		return $this->title && $this->artist && $this->duration;
	}

	/**
	 * @return string
	 */
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * @param string $hash
	 */
	public function setHash($hash)
	{
		$this->hash = $hash;
	}
	
}
