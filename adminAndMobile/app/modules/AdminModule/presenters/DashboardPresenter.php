<?php

namespace App\AdminModule\Presenters;

use Nette;
use App\Model;


class DashboardPresenter extends BasePresenter
{

	/** @var Model\GenresManager @inject */
	public $genresManager;

	/** @var Model\SongsManager @inject */
	public $songsManager;

	public function renderDefault()
	{
		$this->template->genres = $this->genresManager->countAllGenres();
		$this->template->songs = $this->songsManager->countAllSongs();
		$this->songsManager->hashSongs();
	}

}
