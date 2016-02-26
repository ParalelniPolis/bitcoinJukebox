<?php

namespace App\Presenters;

use Nette;
use App\Forms\SignFormFactory;
use Nette\Application\UI\Form;


class SignPresenter extends BasePresenter
{
	/** @var SignFormFactory @inject */
	public $factory;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function (Form $form) {
			$form->getPresenter()->redirect('Dashboard:');
		};
		return $form;
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Byl jste odhlášen.', 'info');
		$this->redirect('in');
	}

}
