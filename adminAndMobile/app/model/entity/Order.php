<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order extends Entities\BaseEntity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid")
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @var \Ramsey\Uuid\Uuid
	 */
	private $id;

	/**
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $paid;

	/**
	 * @ORM\Column(type="datetime")
	 * @var \DateTime
	 */
	private $ordered;
	/**
	 * @ORM\ManyToOne(targetEntity="Address")
	 * @ORM\JoinColumn(name="address", referencedColumnName="address")
	 * @var Address
	 */
	private $address;

	/**
	 * @ORM\Column(type="float")
	 * @var double
	 */
	private $price;

	/**
	 * @ORM\ManyToOne(targetEntity="Genre")
	 * @var boolean
	 */
	private $orderedGenre;

	public function __construct($price, Address $address, Genre $orderedGenre = null)
    {
	    $this->id = Uuid::uuid4();
    	$this->paid = false;
	    $this->ordered = new \DateTime();
	    $this->address = $address;
	    $this->price = $price;
	    $this->orderedGenre = $orderedGenre;
    }
    
}

