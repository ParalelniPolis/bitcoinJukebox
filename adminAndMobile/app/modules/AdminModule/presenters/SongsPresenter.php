<?php

namespace App\AdminModule\Presenters;

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

	public function actionDefault(string $genre = null)
	{
		$this->genre = $genre;
	}

	public function renderDefault(string $genre = null)
	{
		$this->template->songs = $this->songsManager->getSongs($genre);
		$this->template->currentGenre = $genre;
		$this->template->genres = $this->genresManager->getAllGenres();
	}

	public function actionDelete(string $songId)
	{
		$name = $this->songsManager->deleteSong($songId);
		$this->flashMessage("Skladba $name byla úspěšně smazána.", "info");
		$this->redirect("default");
	}

	public function actionDownload($songId)
	{
		list($path, $song) = $this->songsManager->getSongPath($songId);
		$this->presenter->sendResponse(new FileResponse($path, $song));
	}
}
