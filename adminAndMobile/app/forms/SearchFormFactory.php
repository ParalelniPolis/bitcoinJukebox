<?php

namespace App\Forms;

use App\Model\GenresManager;
use App\Utils\SizeParser;
use Latte\Runtime\Filters;
use Nette\Application\UI\Form;
use Nette\Object;


class SearchFormFactory extends Object
{
	/** @var FormFactory */
	private $factory;

	public function __construct(FormFactory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = $this->factory->create();
		$form->addText('text', '')
			->setRequired('Musíte zadat hledaný pojem');

		$form->addSubmit('search', '');

		return $form;
	}

}
