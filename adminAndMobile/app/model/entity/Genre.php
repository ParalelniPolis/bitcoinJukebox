<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;

/**
 * @ORM\Entity
 */
class Genre extends Entities\BaseEntity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
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

