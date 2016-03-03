<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class SignFormFactory extends Nette\Object
{
	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;


	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}


	/**
	 * @return Form
	 */
	public function create()
	{
		$form = $this->factory->create();
		$form->addText('username', 'Jméno:')
			->setRequired('Zadejte své uživatelské jméno.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte své heslo.');

		$form->addCheckbox('remember', 'Zůstat přihlášen');

		$form->addSubmit('send', 'Přihlásit se');

		$form->onSuccess[] = $this->formSucceeded;
		return $form;
	}


	public function formSucceeded(Form $form, \stdClass $values)
	{
		if ($values->remember) {
			$this->user->setExpiration('14 days', FALSE);
		} else {
			$this->user->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->user->login($values->username, $values->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError('Přihlašovací údaje nejsou správné.');
		}
	}

}
