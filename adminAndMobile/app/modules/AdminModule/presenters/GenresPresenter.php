<?php

namespace App\AdminModule\Presenters;

use App\Forms\AddGenreFormFactory;
use App\Model\GenresManager;
use Nette\Application\UI\Form;

class GenresPresenter extends BasePresenter
{

	/** @var GenresManager @inject */
	public $genresManager;

	/** @var AddGenreFormFactory @inject */
	public $addGenreFormFactory;

	public function renderDefault()
	{

	}

	public function createComponentAddGenreForm()
	{
		$form = $this->addGenreFormFactory->create();
		$form->onSuccess[] = $this->addGenre;
		return $form;
	}

	public function addGenre(Form $form, array $values)
	{
		$this->genresManager->addGenre($values['genre']);
		$this->flashMessage('Žánr byl úspěšně přidán.', 'success');
		$this->redirect('this');
	}
}
