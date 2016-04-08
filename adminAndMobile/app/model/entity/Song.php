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
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $title;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $artist;

	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $duration;

    public function __construct(string $name, string $albumCover, Genre $genre = null)
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

	public function loadMetadata(\SongReader $songReader)
	{
		$this->title = $songReader->getTitle();
		$this->artist = $songReader->getAuthor();
		$this->duration = $songReader->getDuration();
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

}

