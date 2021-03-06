<?php

//preg_match('~(?P<Marks>)~', 'Ian D Marks-16-King of the Mountain The Proclamation.mp3', $matches);
//preg_match('~(?P<artist>.+)-[\d]+-(?P<title>.+)\.mp3~', 'Little Howlin Wolf-04-Unknown 3.mp3', $matches);
//preg_match('~(?P<artist>.+)-(?P<title>.+)\.mp3~', 'Meanest Man Contest-Takitani Edit Superhumanoids Remix.mp3', $matches);
//
//var_dump($matches);
//
//exit;

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
		$time_pre = microtime(true);
		$songsManager->addSongFromCLI($file, $genre);
		$time_post = microtime(true);
		$exec_time = $time_post - $time_pre;
		echo $exec_time . PHP_EOL;

		$i++;
		$percentage = (int) ($i * 100 / $count);
		if ($percentage > $previous) {
			echo "$percentage% done" . PHP_EOL;
		}

		$previous = $percentage;
	}
}

echo 'Songs have been added.' . PHP_EOL;
