<?php

namespace Language\Model;


class Language
{

	private $language;
	private $application;


	public function __construct ($language, $application)
	{
		$this->language = $language;
		$this->application = $application;
	}
	/**
	 * @return mixed
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param mixed $language
	 */
	public function setLanguage($language)
	{
		$this->language = $language;
	}
	/**
	 * @return mixed
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * @param mixed $application
	 */
	public function setApplication($application)
	{
		$this->application = $application;
	}

	public function getFile()
	{
		$langFilesModel =  new LanguageFile();
		return $langFilesModel->getLanguageFile($this->getApplication(),$this->getLanguage());
	}
}
