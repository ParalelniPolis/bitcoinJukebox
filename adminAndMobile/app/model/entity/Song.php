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
    
}

