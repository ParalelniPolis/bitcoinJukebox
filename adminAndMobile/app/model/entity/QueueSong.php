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

	/**
	 * Database cache, so order table does not have to be joined during selecting songs in websocket.
	 * Should be same as paid column in related order.
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $paid;

    public function __construct(Song $song, Order $order)
    {
    	$this->song = $song;
		$this->proceeded = false;
	    $this->order = $order;
	    $this->paid = false;
    }

}

