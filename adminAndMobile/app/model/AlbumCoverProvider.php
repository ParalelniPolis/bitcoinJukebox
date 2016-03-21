<?php

namespace App\Model;
 
use App\Model\Entity\Song;
use Nette;
 
class AlbumCoverProvider extends Nette\Object
{

	public function __construct()
	{
	
	}

	public function getAlbumCoverURL(Song $song) : string
	{
		$client = new Client([
			// Base URI is used with relative requests
			'base_uri' => 'http://httpbin.org',
			// You can set any number of default request options.
			'timeout'  => 2.0,
		]);
	}
}