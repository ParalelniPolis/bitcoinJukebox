<?php

namespace App\Model;
 
use App\Model\Entity\Song;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Nette;
use PHPHtmlParser\Dom;
use Tracy\Debugger;

class AlbumCoverProvider extends Nette\Object
{

	public function __construct()
	{
	
	}

	public function getAlbumCoverURL(string $songPath) : string
	{
		$songReader = new \SongReader($songPath);
		$client = new Client([
			'base_uri' => 'http://www.slothradio.com/',
			'timeout'  => 2.0
		]);
		$response = $client->request('GET', 'covers/', ['query' =>
			[
				'artist' => $songReader->getAuthor(),
				'album' => $songReader->getAlbum()
			]
		]);
		$html = $response->getBody()->getContents();

		$dom = new Dom();
		$dom->load($html);
		$images = $dom->find('#content > div.album0 > img');
		if (count($images) > 0) {
			/** @var Dom\HtmlNode $image */
			$image = $images[0];
			$albumURL = $image->getAttribute('src');
		} else {
			$albumURL = '';
		}
		return $albumURL;
	}
}