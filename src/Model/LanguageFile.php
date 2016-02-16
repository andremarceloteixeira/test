<?php
namespace Language\Model;
use Language\Api\ApiCall;
use Language\Config\Config;
use Language\Exception\FileException;

class LanguageFile extends File
{

    public function getLanguageFile($application, $language)
    {
        $result = false;
        $languageResponse = ApiCall::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ),
            array('language' => $language)
        );

        try {
            $this->checkFileApiResult($languageResponse);
        } catch (\Exception $e) {
            throw new FileException('Error during getting language file: (' . $application . '/' . $language . ')');
        }
        // If we got correct data we store it.
        $destination = $this->getLanguageCachePath($application) . $language . '.php';
        // If there is no folder yet, we'll create it.
        var_dump($destination);
        if (!is_dir(dirname($destination))) {
            mkdir(dirname($destination), 0755, true);
        }
        $result = file_put_contents($destination, $languageResponse['data']);
        return (bool)$result;
    }


    protected function getLanguageCachePath($application)
    {
        return Config::get('system.paths.root') . '/cache/' . $application. '/';
    }

}