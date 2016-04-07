<?php

/** @var \Nette\DI\Container $container */
$container = require __DIR__ . '/../app/bootstrap.php';
/** @var \App\Model\SongsManager $songsManager */
$songsManager = $container->getByType(\App\Model\SongsManager::class);
/** @var \App\Model\GenresManager $genresManager */
$genresManager = $container->getByType(\App\Model\GenresManager::class);

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

/** @var \SplFileInfo $genreDirectory */
foreach (\Nette\Utils\Finder::findDirectories('*')->from($path) as $genreDirectory) {
	$genre = $genreDirectory->getBasename();

	$genresManager->addGenre($genre);

	/** @var \SplFileInfo $file */
	foreach (\Nette\Utils\Finder::findFiles('*.*')->from($genreDirectory->getRealPath()) as $file) {
		$songsManager->addSongFromCLI($file, $genre);

		$i++;
		$percentage = (int) ($i * 100 / $count);
		if ($percentage > $previous) {
			echo "$percentage% done" . PHP_EOL;
		}

		$previous = $percentage;
	}
}

echo 'Songs have been added.' . PHP_EOL;
