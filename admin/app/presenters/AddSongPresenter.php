<?php

namespace App\Presenters;

use App\Forms\AddSongFormFactory;
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
		$genre = $values['genre'];
		if ($songFile->isOk()) {
			$this->songsManager->addSong($songFile, $genre);
		}
		$this->flashMessage('Skladba byla úspěšně přidána.', 'success');
		$this->redirect('this');
	}

}
