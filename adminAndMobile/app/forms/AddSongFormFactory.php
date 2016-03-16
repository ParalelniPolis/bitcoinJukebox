<?php

namespace App\Forms;

use App\Model\GenresManager;
use App\Utils\SizeParser;
use Latte\Runtime\Filters;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\Object;
use Tracy\Debugger;


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
		$form->addUpload('song', 'Nová skladba: ', true)
			->addRule(Form::MAX_FILE_SIZE, 'Nemůžete nahrát vetší soubor než ' . Filters::bytes($maxSize) . '(nastaveno v php.ini)', $maxSize)
			->getControlPrototype()->addAttributes(['class' => 'file']);

		$genres = $this->genresManager->getAllGenreIdsAndNames();
		$form->addSelect('genre', 'Žánr: ', $genres)
			->setPrompt('-')
			->setDefaultValue($defaultGenre);

		$form->addSubmit('send', 'Nahrát skladbu');

		$form->onValidate[] = $this->validateSongsMetadata;

		return $form;
	}

	public function validateSongsMetadata(Form $form, array $values)
	{
		$songFiles = $values['song'];
		/** @var FileUpload $songFile */
		foreach ($songFiles as $songFile) {
			if ($songFile->isOk()) {
				if (!$this->hasSongValidMetadata($songFile)) {
					$form->addError('Song ' . $songFile->getName() . ' has invalid metadata, upload not permitted.');
				}
			} else {
				$form->addError('Song ' . $songFile->getName() . ' was invalid, upload failed.');
			}
		}
	}

	private function hasSongValidMetadata(FileUpload $song) : bool
	{
		$getID3 = new \getID3();
		$info = $getID3->analyze($song->getTemporaryFile());
		Debugger::barDump($info, 'song info ' . $song->getName());
		if (!isset($info['tags']['id3v1']['artist'][0])) {
			return false;
		}
		if (!isset($info['tags']['id3v1']['title'][0])) {
			return false;
		}
		if (!isset($info['playtime_string'])) {
			return false;
		}
		return true;
	}

	//TODO: dodělat hlášení, který tag chybí, dodělat načítání alba
}
