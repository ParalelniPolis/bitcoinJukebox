<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;
use Nette\Utils\Strings;

/**
 * @ORM\Entity
 */
class Genre extends Entities\BaseEntity
{


	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true, nullable=false)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\OneToMany(targetEntity="Song", mappedBy="genre")
	 * @var Song[]
	 */
	private $songs;

    public function __construct($name)
    {
    	$this->name = $name;
    }

	public function getId() : int
	{
		return $this->id;
	}

	public function getName() : string
	{
		return $this->name;
	}

	/**
	 * @return Song[]
	 */
	public function getSongs() : array
	{
		return $this->songs;
	}
    
}

