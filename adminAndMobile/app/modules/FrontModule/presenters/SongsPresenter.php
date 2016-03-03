<?php

namespace App\FrontModule\Presenters;

use App\Forms\SearchFormFactory;
use App\Model\AddressProvider;
use App\Model\GenresManager;
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
	private $allSongs;

	/** @var string[] */
	private $genres;

	/** @var double */
	private $pricePerSong;

	public function actionDefault()
	{
		$this->genres = $this->genresManager->getAllGenres();
		$this->allSongs = [];
		foreach ($this->songsManager->getSongs() as $song) {
			$this->allSongs[$song] = $this->modify($song);
		}
		foreach ($this->genres as $genre) {
			foreach ($this->songsManager->getSongs($genre) as $song) {
				$name = $genre . '_' . $song;
				$this->allSongs[$name] = $this->modify($name);
			}
		}
	}

	public function renderDefault()
	{
		$this->template->allSongs = $this->allSongs;
		$this->template->genres = $this->genres;
		$this->template->songsWithoutGenre = $this->songsManager->getSongs();
		/** string[] */
		$songs = [];
		foreach ($this->genres as $genre) {
			$songs[$genre] = $this->songsManager->getSongs($genre);
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
		foreach ($this->allSongs as $song) {
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

	public function renderOrder(string $songs)
	{
		$songsArray = Strings::split($songs, '~, ~');
		$this->template->amount = $this->pricePerSong * count($songsArray);
		$this->template->address = $this->addressProvider->getFreeAddress();
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
