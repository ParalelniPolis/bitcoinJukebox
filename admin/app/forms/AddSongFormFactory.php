<?php

namespace App\Forms;

use App\Model\GenresManager;
use App\Utils\SizeParser;
use Latte\Runtime\Filters;
use Nette\Application\UI\Form;
use Nette\Object;


class AddSongFormFactory extends Object
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
		$maxSize = SizeParser::parse_size(ini_get("upload_max_filesize"));
		$form->addUpload('song', 'Nová skladba: ')
			->addRule(Form::MAX_FILE_SIZE, 'Nemůžete nahrát vetší soubor než ' . Filters::bytes($maxSize) . '(nastaveno v php.ini)', $maxSize);

		$genres = $this->genresManager->getAllGenres();
		$form->addSelect('genre', 'Žánr: ', array_combine($genres, $genres))
			->setPrompt('-');

		$form->addSubmit('send', 'Nahrát skladbu');

		return $form;
	}

}
