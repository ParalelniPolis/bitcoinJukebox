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
					$form->addError('Song ' . $songFile->getName() . ' has invalid metadata: ' .
						implode(', ', $this->getInvalidMetadata($songFile)) . '. Upload not permitted.');
				}
			} else {
				$form->addError('Song ' . $songFile->getName() . ' was invalid, upload failed.');
			}
		}
	}

	private function hasSongValidMetadata(FileUpload $song) : bool
	{
		$songReader = new \SongReader($song->getTemporaryFile());
		if (!$songReader->getDuration()) {
			return false;
		}
		if (!$songReader->getAuthor()) {
			return false;
		}
		if (!$songReader->getTitle()) {
			return false;
		}
		if (!$songReader->getAlbum()) {
			return false;
		}
		return true;
	}


	private function getInvalidMetadata(FileUpload $song) : array
	{
		$invalidMetadata = [];
		$songReader = new \SongReader($song->getTemporaryFile());
		if (!$songReader->getDuration()) {
			$invalidMetadata[] = 'playtime_string';
		}
		if (!$songReader->getAuthor()) {
			$invalidMetadata[] = 'artist';
		}
		if (!$songReader->getTitle()) {
			$invalidMetadata[] = 'title';
		}
		if (!$songReader->getAlbum()) {
			$invalidMetadata[] = 'album';
		}
		return $invalidMetadata;
	}
}
