<?php

$servername = "localhost";
$username = "jukebox";
$password = "doog7AeghoFughi7eijiezoegheime";
$databaseName = "jukebox";
$connection = mysqli_connect($servername, $username, $password, $databaseName);
$sql = file_get_contents('jukebox.sql');
$connection->multi_query($sql);

///jukebox/adminAndMobile/www/index.php
