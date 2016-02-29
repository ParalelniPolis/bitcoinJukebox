<?php

namespace App\Presenters;

use App\Forms\AddSongFormFactory;
use App\Model\GenresManager;
use App\Model\SongsManager;
use Nette\Application\Responses\FileResponse;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Tracy\Debugger;

class SongsPresenter extends BasePresenter
{

	/** @var SongsManager @inject */
	public $songsManager;

	/** @var GenresManager @inject */
	public $genresManager;

	/** @var string @persistent */
	public $genre;

	public function actionDefault($genre = null)
	{
		$this->genre = $genre;
	}

	public function renderDefault($genre = null)
	{
		$this->template->songs = $this->songsManager->getSongs($genre);
		$this->template->genre = $genre;
		$this->template->genres = $this->genresManager->getAllGenres();
	}

	public function actionDelete($song)
	{
		$this->songsManager->deleteSong($song, $this->genre);
		$this->flashMessage("Skladba $song byla úspěšně smazána.", "info");
		$this->redirect("default");
	}

	public function actionDownload($song)
	{
		$path = $this->songsManager->getSongPath($song, $this->genre);
		$this->presenter->sendResponse(new FileResponse($path, $song));
	}
}
