<?php

namespace App\AdminModule\Presenters;

use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function startup()
	{
		parent::startup();
		if (!$this->user->isLoggedIn() && !($this->presenter instanceof SignPresenter)){
			$this->redirect('Sign:in');
		}
	}

}
//fronta je prázdná => random písnička
//složky
//fulltext search
//2 záložky - fronta a písničky
//random žánr
//dát možnost ticho
//žánr se přehrává dokola, dokud není přeplacený někým jiným
//checkboxy vprocho