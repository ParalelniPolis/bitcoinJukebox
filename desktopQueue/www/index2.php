<?php
/**
 * Created by PhpStorm.
 * User: Sliver
 * Date: 18. 12. 2015
 * Time: 18:32
 */
require_once('../SongParser.php');
require_once('../getID3-1.9.10/getid3/getid3.php');

define('SONGS_PATH', 'songs');
define('QR_PATH', 'qr');
define('QR_SIZE', '250');
define('QR_DOT_EXTENSION', '.png');


$songParser = new SongParser();
$songs = $songParser->getSongsInfo(SONGS_PATH, QR_PATH);
$songs = $songParser->createQRcodes($songs, QR_PATH);
$songs = $songParser->cleanSongsInfo($songs, QR_PATH);

sendSongs($songs);

function sendSongs($songs) {
	var_dump($songs);

	//header('Content-type: application/json');
	//echo json_encode($songs);
}
