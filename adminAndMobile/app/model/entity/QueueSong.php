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
	 * is true when song is sent to frontend to queue
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $proceeded;

	/**
	 * @ORM\ManyToOne(targetEntity="Order")
	 * @var Order
	 */
	private $order;

    public function __construct(Song $song, Order $order)
    {
    	$this->song = $song;
		$this->proceeded = false;
	    $this->order = $order;
    }

}

