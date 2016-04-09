<?php

/** @var \Nette\DI\Container $container */
$container = require __DIR__ . '/../app/bootstrap.php';
/** @var \App\Model\SongsManager $songsManager */
$songsManager = $container->getByType(\App\Model\SongsManager::class);

if ($argc < 2) {
	echo 'Adds all songs in chosen directory to jukebox. ' . PHP_EOL .
	'Good for batch processing and large amount of songs.' . PHP_EOL .
	'Usage: php add-songs.php <songsDirectory>';
	exit(0);
}

$relativePath = $argv[1];
$path = getcwd() . DIRECTORY_SEPARATOR . $relativePath;
echo $path . PHP_EOL;

$songs = \Nette\Utils\Finder::findFiles('*.*')->from($path);

// zobrazování procent
$count = $songs->count();
$i = 0;
$previous = 0;
//zobrazování procent

/** @var \SplFileInfo $file */
foreach ($songs as $file) {
	//todo: vymyslet, jak načítat žánry
	$songsManager->addSongFromCLI($file);

	$i++;
	$percentage = (int) ($i * 100 / $count);
	if ($percentage > $previous) {
		echo "$percentage% done" . PHP_EOL;
	}

	$previous = $percentage;
}

echo 'Songs have been added.' . PHP_EOL;
