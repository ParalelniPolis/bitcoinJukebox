<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;

/**
 * @ORM\Entity
 * @ORM\Table(name="addresses")
 */
class Address extends Entities\BaseEntity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $address;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var \DateTime
	 */
	private $lastUsed;

	/**
	 * @ORM\Column(type="integer", unique=true)
	 * @var integer
	 */
	private $bip32index;

    public function __construct($address, $bip32index)
    {
    	$this->address = $address;
	    $this->bip32index = $bip32index;
	    $this->lastUsed = null;
    }

	/**
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastUsed()
	{
		return $this->lastUsed;
	}

	/**
	 * @return int
	 */
	public function getBip32index()
	{
		return $this->bip32index;
	}

	public function useAddress()
	{
		$this->lastUsed = new \DateTime();
	}

}

