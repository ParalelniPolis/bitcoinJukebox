<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;
use Nette\Utils\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="queue")
 */
class QueueSong extends Entities\BaseEntity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Song")
	 * @ORM\JoinColumn(name="song")
	 * @var Song
	 */
	private $song;

	/**
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $paid;

	/**
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="address", referencedColumnName="address")
	 * @var Address
	 */
	private $address;

	/**
	 * @ORM\Column(type="datetime")
	 * @var \DateTime
	 */
	private $ordered;

    public function __construct(Song $song, Address $address)
    {
    	$this->song = $song;
		$this->paid = false;
	    $this->address = $address;
	    $this->ordered = new \DateTime();
    }

}

