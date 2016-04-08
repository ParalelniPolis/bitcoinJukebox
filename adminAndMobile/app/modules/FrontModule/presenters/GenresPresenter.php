<?php

namespace App\FrontModule\Presenters;

use App\Forms\SearchFormFactory;
use App\Model\AddressProvider;
use App\Model\Entity\Address;
use App\Model\GenresManager;
use App\Model\QueueManager;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;
use Tracy\Debugger;

class GenresPresenter extends BasePresenter
{

	/** @var SearchFormFactory @inject */
	public $searchFormFactory;

	/** @var GenresManager @inject */
	public $genresManager;

	/** @var float */
	private $pricePerGenre;

	/** @var Address */
	private $address;

	/** @var AddressProvider @inject */
	public $addressProvider;

	/** @var QueueManager @inject */
	public $queueManager;

	public function renderDefault()
	{
	}

	public function createComponentSearchForm()
	{
		$form = $this->searchFormFactory->create();
		return $form;
	}

	public function createComponentOrderForm()
	{
		$form = new Form();
		$radioList = [];
		foreach ($this->genresManager->getAllNonEmptyGenres() as $genre) {
			$radioList[$genre->getId()] = $genre->getName();
		}
		$form->addRadioList('genre', '', $radioList);
		$form->addSubmit('order', 'Objednat');
		$form->onSuccess[] = $this->orderGenre;
		return $form;
	}

	public function orderGenre(Form $form)
	{
		$genreId = $form->getValues()->genre;
		$this->redirect('order', ['genreId' => $genreId]);
	}

	public function actionOrder(string $genreId)
	{
		$amount = $this->pricePerGenre;
		$this->address = $this->addressProvider->getFreeAddress();
		$this->queueManager->orderGenre($genreId, $amount, $this->address);
	}

	public function renderOrder(string $genreId)
	{
		$this->template->amount = $this->pricePerGenre;
		$this->template->address = $this->address->getAddress();
	}

	/**
	 * @param float $pricePerGenre
	 */
	public function setPricePerGenre($pricePerGenre)
	{
		$this->pricePerGenre = $pricePerGenre;
	}

}
