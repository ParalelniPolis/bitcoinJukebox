<?php

namespace App\Forms;

use App\Model\GenresManager;
use Nette\Application\UI\Form;
use Nette\Object;


class AddGenreFormFactory extends Object
{
	/** @var FormFactory */
	private $factory;

	/** @var GenresManager */
	private $genresManager;

	public function __construct(FormFactory $factory, GenresManager $genresManager)
	{
		$this->factory = $factory;
		$this->genresManager = $genresManager;
	}


	/**
	 * @return Form
	 */
	public function create()
	{
		$form = $this->factory->create();
		$form->addText('genre', 'Název žánru: ')
			->setRequired('Musíte vyplnit název žánru')
			->addRule(Form::IS_NOT_IN, 'Tento žánr již existuje', $this->genresManager->getAllGenreNames());
		$form->addSubmit('send', 'Vytvořit nový žánr');
		return $form;
	}

}
