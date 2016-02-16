<?php

namespace Language;
use Language\Config\Config;
use Language\Api\ApiCall;;
use Language\Exception\AppletException;
use Language\Exception\LangsException;
use Language\Exception\NotGenerateFileException;
use \Language\Facade\ILanguage;
use Language\Model\Applet;
use Language\Model\Language;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo implements ILanguage
{
	/**
	 * Contains the applications which ones require translations.
	 *
	 * @var array
	 */
	protected static $applications = array();

	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public static function generateLanguageFiles()
	{
		// The applications where we need to translate.
		self::$applications = Config::get('system.translated_applications');

		echo "<p></p><span style='color:darkred'>Generating language files</span></p>";
		echo "<ul>";

		foreach (self::$applications as $application => $languages) {
			echo "<li style='color: #2b542c'>APPLICATION NAME: " . $application . "<li>";
			foreach ($languages as $language) {
				echo "<ul>";
				echo "<li style='color: #2e6da4'>[LANGUAGE: " . $language . "]</li>";
				$languageModel = new Language($language, $application);
				if ($languageModel->getFile()) {
					echo "<span style='color:orangered'>OK</span>";
				} else {
					throw new NotGenerateFileException('Unable to generate language file!');
				}
			}
			echo "</ul>";
		}
		echo "</ul>";
		return true;
	}

	public static function generateAppletLanguageXmlFiles()
	{
		// List of the applets [directory => applet_id].
		$applets = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);

		echo "<p style='color: #66512c'>Getting applet language XMLs..</p>";


		foreach ($applets as $appletDirectory => $appletLanguageId) {
			echo "<p> Getting > $appletLanguageId ($appletDirectory) language xmls..</p>";
			$appletModel = new Applet($appletLanguageId);
			$languages = $appletModel->getAppletLanguages();
			if (empty($languages)) {
				throw new LangsException("There is no available languages for the " . $appletLanguageId . " applet.");
			}
			echo "<p style='color: #2ca02c'>- Available languages: " . implode(', ', $languages) . "</p>";

			$path = $appletModel->getAppletPath();
			foreach ($languages as $language) {
				$xmlContent = $appletModel->getAppletLanguageFile($language);
				$xmlFile    = $path . '/lang_' . $language . '.xml';
				if (!file_exists(dirname($xmlFile))) {
					mkdir(dirname($xmlFile), 0777, true);
				}
				if (strlen($xmlContent) == file_put_contents($xmlFile, $xmlContent)) {
					echo "<p> OK saving $xmlFile was successful.</p>";
				}
				else {
					throw new AppletException('Unable to save applet: (' . $appletLanguageId . ') language: (' . $language
						. ') xml (' . $xmlFile . ')!');
				}
			}
			echo " <p> $appletLanguageId ($appletDirectory) language xml cached.</p>";
		}
		echo "\nApplet language XMLs generated.\n";
		return true;
	}

}
