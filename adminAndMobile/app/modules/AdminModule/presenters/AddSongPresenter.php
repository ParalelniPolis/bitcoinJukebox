<?php

namespace App\AdminModule\Presenters;

use App\Forms\AddSongFormFactory;
use App\Model\GenresManager;
use App\Model\SongsManager;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Tracy\Debugger;

class AddSongPresenter extends BasePresenter
{

	/** @var AddSongFormFactory @inject */
	public $addSongFormFactory;

	/** @var SongsManager @inject */
	public $songsManager;

	/** @var GenresManager @inject */
	public $genresManager;

	/** @var string */
	private $genre;

	public function actionDefault($genre = null)
	{
		$this->genre = $genre;
	}

	public function renderDefault($genre = null)
	{
	}

	public function createComponentAddSongForm()
	{
		$form = $this->addSongFormFactory->create($this->genre);
		$form->onSuccess[] = $this->addSong;
		return $form;
	}

	public function addSong(Form $form, array $values)
	{
		/** @var FileUpload $songFile */
		$songFile = $values['song'];
		$genreName = $values['genre'];
		if ($songFile->isOk()) {
			$this->songsManager->addSong($songFile, $genreName);
			$this->flashMessage('Skladba byla úspěšně přidána.', 'success');
		} else {
			$this->flashMessage('Skladbu se nepodařilo přidat.', 'error');
		}
		$this->redirect('this');
	}

}
