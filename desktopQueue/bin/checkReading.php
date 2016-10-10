<?php

require_once __DIR__ . '/../vendor/autoload.php';

$lastReadFile = __DIR__ . '/../../adminAndMobile/app/model/lastRead.txt';

while (true) {
	$lastRead = new \Carbon\Carbon(file_get_contents($lastReadFile));
	if ($lastRead->lt(\Carbon\Carbon::now()->subMinutes(30))) {
		shell_exec('systemctl restart jukebox-bitcoinreader');
	}
	sleep(10);
}