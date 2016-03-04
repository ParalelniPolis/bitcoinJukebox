<?php

namespace App\FrontModule\Presenters;

use App\Forms\SearchFormFactory;
use App\Model\AddressProvider;
use App\Model\Entity\Address;
use App\Model\Entity\Genre;
use App\Model\GenresManager;
use App\Model\QueueManager;
use App\Model\SongsManager;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;

class SongsPresenter extends BasePresenter
{

	/** @var SearchFormFactory @inject */
	public $searchFormFactory;

	/** @var SongsManager @inject */
	public $songsManager;

	/** @var GenresManager @inject */
	public $genresManager;

	/** @var AddressProvider @inject */
	public $addressProvider;

	/** @var string[] */
	private $songIds;

	/** @var Genre[] */
	private $genres;

	/** @var double */
	private $pricePerSong;

	/** @var QueueManager @inject */
	public $queueManager;

	/** @var Address */
	private $address;

	public function actionDefault()
	{
		$this->genres = $this->genresManager->getAllGenres();
		$this->songIds = $this->songsManager->getSongIds();
	}

	public function renderDefault()
	{
		$this->template->genres = $this->genres;
		$this->template->songsWithoutGenre = $this->songsManager->getSongs();
		/** Song[][] */
		$songs = [];
		foreach ($this->genres as $genre) {
			$songs[$genre->getName()] = $this->songsManager->getSongs($genre->getName());
		}
		$this->template->songs = $songs;
	}

	public function createComponentSearchForm()
	{
		$form = $this->searchFormFactory->create();
		return $form;
	}

	public function createComponentOrderForm()
	{
		$form = new Form();
		foreach ($this->songIds as $song) {
			$form->addCheckbox($song);
		}
		$form->addSubmit('order', 'Objednat');
		$form->onSuccess[] = $this->orderSongs;
		return $form;
	}

	public function orderSongs(Form $form)
	{
		$songsArray = $form->getValues();
		$songs = [];
		foreach ($songsArray as $song => $selected) {
			if ($selected) {
				$songs[] = $song;
			}
		}
		$this->redirect('order', ['songs' => implode(', ', $songs)]);
	}

	public function actionOrder(string $songs)
	{
		$songsArray = Strings::split($songs, '~, ~');
		$this->address = $this->addressProvider->getFreeAddress();
		$this->queueManager->addSongs($songsArray, $this->address);
	}

	public function renderOrder(string $songs)
	{
		$songsArray = Strings::split($songs, '~, ~');
		$this->template->amount = $this->pricePerSong * count($songsArray);
		$this->template->address = $this->address->getAddress();
	}

	private function modify(string $string) : string
	{
		$string = Strings::webalize($string);
		$string = Strings::replace($string, '~-~', '_');
		return $string;
	}

	/**
	 * @param float $pricePerSong
	 */
	public function setPricePerSong($pricePerSong)
	{
		$this->pricePerSong = $pricePerSong;
	}

}
