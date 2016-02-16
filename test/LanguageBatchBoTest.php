<?php
chdir(__DIR__);

include('../vendor/autoload.php');

class LanguageBatchBoTest extends PHPUnit_Framework_TestCase
{
    public function testTrue()
    {
        $this->assertEquals(TRUE, \Language\LanguageBatchBo::generateLanguageFiles());
    }

    public function testFalse()
    {
        $this->assertEquals(FALSE, \Language\LanguageBatchBo::generateAppletLanguageXmlFiles());
    }
}
