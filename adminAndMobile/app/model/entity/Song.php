<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;

/**
 * @ORM\Entity
 */
class Song extends Entities\BaseEntity
{

    use Entities\Attributes\Identifier;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="Genre", inversedBy="songs")
	 * @ORM\JoinColumn(referencedColumnName="name")
	 * @var Genre
	 */
	private $genre;

	/**
	 * @ORM\Column(type="string")
	 * @var string;
	 */
	private $hash;

    public function __construct($name, Genre $genre = null)
    {
    	$this->name = $name;
	    $this->genre = $genre;
	    $toBeHashed = $name;
	    $toBeHashed .= $genre ? $genre->getName() : '';
	    $this->hash = hash('sha512', $toBeHashed);
    }

	public function getName() : string
	{
		return $this->name;
	}

	public function getGenre() : Genre
	{
		return $this->genre;
	}

	public function getHash() : string
	{
		return $this->hash;
	}
    
}

