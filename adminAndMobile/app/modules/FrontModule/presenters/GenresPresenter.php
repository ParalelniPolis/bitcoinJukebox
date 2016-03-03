<?php

namespace App\FrontModule\Presenters;

use App\Forms\SearchFormFactory;
use Nette;
use App\Model;


class GenresPresenter extends BasePresenter
{

	/** @var SearchFormFactory @inject */
	public $searchFormFactory;

	public function renderDefault()
	{
	}

	public function createComponentSearchForm()
	{
		$form = $this->searchFormFactory->create();
		return $form;
	}

}
