<?php

namespace App\AdminModule\Presenters;

use App\Forms\AddSongFormFactory;
use App\Model\AlbumCoverProvider;
use App\Model\CantDeleteException;
use App\Model\Entity\Song;
use App\Model\GenresManager;
use App\Model\SongsManager;
use Doctrine\DBAL\DBALException;
use Nette\Application\Responses\FileResponse;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Tracy\Debugger;

class SongsGridPresenter extends BasePresenter
{

	/** @var SongsManager @inject */
	public $songsManager;

	/** @var GenresManager @inject */
	public $genresManager;

	/** @var string @persistent */
	public $genre;

	/** @var AlbumCoverProvider @inject */
	public $albumCoverProvider;

	public function actionDefault(string $genre = null)
	{
		$this->genre = $genre;
	}

	public function renderDefault()
	{
		$this->template->songs = $this->songsManager->getAllSongs();
	}

}
