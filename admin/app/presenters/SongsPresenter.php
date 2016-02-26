<?php

namespace App\Presenters;

use App\Forms\AddSongFormFactory;
use App\Model\SongsManager;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Tracy\Debugger;

class SongsPresenter extends BasePresenter
{

	/** @var AddSongFormFactory @inject */
	public $addSongFormFactory;

	/** @var SongsManager @inject */
	public $songsManager;

	public function renderDefault()
	{
	}

	public function createComponentAddSongForm()
	{
		$form = $this->addSongFormFactory->create();
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
