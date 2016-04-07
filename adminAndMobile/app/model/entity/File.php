<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 7. 4. 2016
 * Time: 13:53
 */

namespace App\Model\Entity;


use Nette\Http\FileUpload;
use Nette\InvalidStateException;

class File
{

	/** @var string */
	private $destination;

	/** @var string */
	private $name;

	/**
	 * @param string $destination
	 * @param string $name
	 */
	private function __construct($destination, $name)
	{
		$this->destination = $destination;
		$this->name = $name;
	}

	static public function fromFileUpload(FileUpload $fileUpload) {
		return new static($fileUpload->getTemporaryFile(), $fileUpload->getName());
	}

	static public function fromSplFileInfo(\SplFileInfo $splFileInfo) {
		return new static($splFileInfo->getRealPath(), $splFileInfo->getBasename());
	}

	/**
	 * @return string
	 */
	public function getDestination()
	{
		return $this->destination;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	public function copy(string $destination)
	{
		//vykopírováno z $file->move(''); a upraveno move na copy
		@mkdir(dirname($destination), 0777, TRUE); // @ - dir may already exist
		@unlink($destination); // @ - file may not exists
		if (!copy($this->destination, $destination)) {
			throw new InvalidStateException("Unable to move uploaded file '{$this->destination}' to '$destination'.");
		}
		@chmod($destination, 0666); // @ - possible low permission to chmod
	}


	public function move(string $destination)
	{
		@mkdir(dirname($destination), 0777, TRUE); // @ - dir may already exist
		@unlink($destination); // @ - file may not exists
		if (!call_user_func(is_uploaded_file($this->destination) ? 'move_uploaded_file' : 'rename', $this->destination, $destination)) {
			throw new InvalidStateException("Unable to move uploaded file '{$this->destination}' to '$destination'.");
		}
		@chmod($destination, 0666); // @ - possible low permission to chmod
	}

}