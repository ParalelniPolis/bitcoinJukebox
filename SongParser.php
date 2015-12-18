<?php

/**
 * Created by PhpStorm.
 * User: Sliver
 * Date: 18. 12. 2015
 * Time: 18:33
 */
class SongParser {
    private $path;
    private $getid3;
    /**
     * SongParser constructor.
     */
    public function __construct($path) {
        $this->getid3 = new getID3();
        $this->path = $path;
    }

    public function getSongsInfo() {
        $files = scandir($this->path);
        $result = [];
        foreach($files as $file) {
            if ($file == '.' || $file == '..') continue;
            $result[] = $this->getid3->analyze($this->path.'/'.$file);
        }

        $songs = [];
        $i = 0;
        foreach ($result as $s) {
            if (!empty($s['id3v1']['title'])) $songs[$i]['title'] = $s['id3v1']['title']; else $songs[$i]['title'] = "";
            if (!empty($s['id3v1']['artist'])) $songs[$i]['artist'] = $s['id3v1']['artist']; else $songs[$i]['artist'] = "unknown artist";
            $songs[$i]['nameOfFile'] = $s['filename'];
            $i++;
        }
        return $songs;
    }


}