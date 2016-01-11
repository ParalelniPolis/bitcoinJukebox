<?php
/**
 * Created by PhpStorm.
 * User: Sliver
 * Date: 18. 12. 2015
 * Time: 18:32
 */
require_once ('SongParser.php');
require_once ('getID3-1.9.10/getid3/getid3.php');

$songParser = new SongParser('./songs');
$songs = $songParser->getSongsInfo();

header('Content-type: application/json');
echo json_encode($songs);

//require('view.php');
//send json instead


//TODO QR addresses to single songs
//TODO check payments via http://blockr.io/documentation/api
//TODO song player (random and payed songs) res: http://www.webcodegeeks.com/html5/html5-audio-player-example/