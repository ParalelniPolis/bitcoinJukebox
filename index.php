<?php
/**
 * Created by PhpStorm.
 * User: Sliver
 * Date: 18. 12. 2015
 * Time: 18:32
 */
require_once ('SongParser.php');
require_once ('getID3-1.9.10/getid3/getid3.php');

$songParser = new SongParser();
$songs = $songParser->getSongsInfo('./songs');
$songs = $songParser->parseSongsInfo($songs);


sendSongs($songs);

function sendSongs($songs) {
	header('Content-type: application/json');
	//var_dump($songs);
	echo json_encode($songs);
}