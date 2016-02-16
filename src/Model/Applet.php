<?php
namespace Language\Model;


use Language\Api\ApiCall;
use Language\Exception\AppletException;
use Language\Config\Config;
class Applet extends File
{
    private $applet;


    public function __construct ($applet)
    {
        $this->applet = $applet;
    }


    public function getAppletLanguages()
    {
        $result = ApiCall::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages'
            ),
            array('applet' => $this->getApplet())
        );
        return $this->getAppletResult($result);
    }

    /**
     * @return mixed
     */
    public function getApplet()
    {
        return $this->applet;
    }

    /**
     * @param mixed $applet
     */
    public function setApplet($applet)
    {
        $this->applet = $applet;
    }

    public function getAppletPath()
    {
        return Config::get('system.paths.root') . '/cache/flash';
    }


    public function getAppletLanguageFile($language)
    {
        $result = ApiCall::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile'
            ),
            array(
                'applet' => $this->getApplet(), 'language' => $language
            )
        );
        return $this->getAppletResult($result);
    }

    /**
     * @param $result
     * @return mixed
     * @throws \Exception
     */
    private function getAppletResult($result)
    {

        try {
            $this->checkFileApiResult($result);
        }
        catch (\Exception $e) {
            throw new AppletException('Getting languages for applet (' . $this->getApplet() . ') was unsuccessful ' . $e->getMessage());
        }

        return $result['data'];
    }
}