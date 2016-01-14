<?php

/**
 * Created by PhpStorm.
 * User: Sliver
 * Date: 18. 12. 2015
 * Time: 18:33
 */
class SongParser {
	private $getid3;

	/**
	 * SongParser constructor.
	 */
	public function __construct() {
		$this->getid3 = new getID3();
	}

	public function getSongsInfo($path) {
		$files = scandir($path);
		$result = [];
		foreach ($files as $file) {
			if ($file == '.' || $file == '..') continue;
			if (is_dir($path.'/'.$file)) {
				//need flat structure
				$resultRecursion = $this->getSongsInfo($path.'/'.$file);
				$result = array_merge($result, $resultRecursion);
			} else { //if file!
				$r = $this->getid3->analyze($path.'/'.$file);
				$r['filenamepath'] = $path.'/'.$file;
				$result[] = $r;
			}
		}
		return $result;
	}

	public function parseSongsInfo($rawSongs) {
		$songs = [];
		$i = 0;
		foreach ($rawSongs as $s) {
			if (!empty($s['id3v1']['title'])) $songs[$i]['title'] = $s['id3v1']['title']; else $songs[$i]['title'] = '';
			if (!empty($s['id3v1']['artist'])) $songs[$i]['artist'] = $s['id3v1']['artist']; else $songs[$i]['artist'] = '';
			$songs[$i]['url'] = str_replace(' ', '%20', $s['filenamepath']);
			$songs[$i]['nameOfFile'] = $s['filename'];
			$i++;
		}
		return $songs;
	}


}