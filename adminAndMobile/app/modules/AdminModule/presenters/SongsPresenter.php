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

class SongsPresenter extends BasePresenter
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

	public function renderDefault(string $genre = null)
	{
		$this->template->songs = $this->songsManager->getSongsByGenreId($genre);
		$this->template->currentGenre = $genre;
		$this->template->genres = $this->genresManager->getAllGenres();
	}

	public function actionDelete(string $songId)
	{
		try {
			$name = $this->songsManager->deleteSong($songId);
			$this->flashMessage("Skladba $name byla úspěšně smazána.", 'info');
		} catch(CantDeleteException $e) {
			$this->flashMessage("Skladba není nalezena", 'warning');
		} catch(DBALException $e) {
			$this->flashMessage("Skladba je ve frontě", 'warning');
		}
		$this->redirect("default");
	}

	public function actionDownload($songId)
	{
		list($path, $song) = $this->songsManager->getSongPathAndName($songId);
		$this->presenter->sendResponse(new FileResponse($path, $song));
	}
}
