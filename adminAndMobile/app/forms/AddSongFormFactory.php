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
	 * @param string $defaultGenre
	 * @return Form
	 */
	public function create(string $defaultGenre = null)
	{
		$form = $this->factory->create();
		$maxSize = SizeParser::parse_size(ini_get("upload_max_filesize"));
		$form->addUpload('song', 'Nová skladba: ')
			->addRule(Form::MAX_FILE_SIZE, 'Nemůžete nahrát vetší soubor než ' . Filters::bytes($maxSize) . '(nastaveno v php.ini)', $maxSize)
			->getControlPrototype()->addAttributes(['class' => 'file']);

		$genres = $this->genresManager->getAllGenreNames();
		$form->addSelect('genre', 'Žánr: ', array_combine($genres, $genres))
			->setPrompt('-')
			->setDefaultValue($defaultGenre);

		$form->addSubmit('send', 'Nahrát skladbu');

		return $form;
	}

}
