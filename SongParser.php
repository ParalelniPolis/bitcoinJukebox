<?php

/**
 * Created by PhpStorm.
 * User: Sliver
 * Date: 18. 12. 2015
 * Time: 18:33
 */
class SongParser {
	/**
	 * @var getID3
	 */
	private $getid3;

	/**
	 * SongParser constructor.
	 */
	public function __construct() {
		$this->getid3 = new getID3();
	}

	/**
	 * @param $songsPath
	 * @param $qrPath
	 * @return array
	 */
	public function getSongsInfo($songsPath, $qrPath) {
		$files = scandir($songsPath);
		$result = [];
		foreach ($files as $file) {
			if ($file == '.' || $file == '..') continue;
			if (is_dir($songsPath.'/'.$file)) {
				//need flat structure of informations
				$resultRecursion = $this->getSongsInfo($songsPath.'/'.$file, $qrPath);
				$result = array_merge($result, $resultRecursion);
			} else { //if it is file
				$r = $this->getid3->analyze($songsPath.'/'.$file);
				$r['filename'] = $file;
				$r['filenamepath'] = $songsPath.'/'.$file;
				$r['qrNamePath'] = $qrPath.'/'.$file.QR_DOT_EXTENSION;
				$r['relativePath'] = str_replace(SONGS_PATH, '', $songsPath);
				$result[] = $r;
			}
		}
		return $result;
	}

	/**
	 * @param $songs
	 * @param $qrPath
	 * @return array
	 */
	public function createQRcodes($songs = [], $qrPath) {
		foreach ($songs as $s) {
			$fileNamePath = $qrPath.urldecode($s['relativePath']).'/'.$s['filename'].QR_DOT_EXTENSION;
			if (!file_exists($fileNamePath)) $this->createAndSafeQRcode($fileNamePath);
		}
		return $songs;
	}

	/**
	 * @param $fileNamePath
	 */
	private function createAndSafeQRcode($fileNamePath) {
		//TODO generate filestructure correctly - now the dirs must be prepared
		$address = $this->getAddress($fileNamePath);
		$ch = curl_init('http://www.qrgenerator.cz/download.php?url=http%3A%2F%2Fchart.apis.google.com%2Fchart%3Fcht%3Dqr%26chs%3D'.QR_SIZE.'x'.QR_SIZE.'%26chl%3D'.$address.'%26choe%3Dundefined%26chld%3DL');
		//$ch = curl_init('https://chart.googleapis.com/chart?cht=qr&chs='.QR_SIZE.'x'.QR_SIZE.'&chl='.$address);
		$gif = fopen($fileNamePath, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $gif);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($gif);
	}

	/**
	 * @param $filename
	 * @return string
	 */
	private function getAddress($filename) {
		//TODO generate correct addresses
		return 'bitcoin:address';
	}

	/**
	 * @param $rawSongs
	 * @param $qrs
	 * @return array
	 */
	public function cleanSongsInfo($rawSongs, $qrs) {
		$songs = [];
		$i = 0;
		foreach ($rawSongs as $s) {
			if (!empty($s['id3v1']['title'])) $songs[$i]['title'] = $s['id3v1']['title']; else $songs[$i]['title'] = '';
			if (!empty($s['id3v1']['artist'])) $songs[$i]['artist'] = $s['id3v1']['artist']; else $songs[$i]['artist'] = '';
			$songs[$i]['directory'] = $s['relativePath'];
			$songs[$i]['nameOfFile'] = $s['filename'];
			$songs[$i]['url'] = urlencode($s['filenamepath']);
			$songs[$i]['qrUrl'] = urlencode($s['qrNamePath']);

			//cleanup
			unset($songs[$i]['directory']);

			$i++;
		}
		return $songs;
	}
}