<?php

namespace Language\Config;
// I shared in more namespaces for clarity but did not move in classes
class Config
{
	public static function get($key)
	{
		switch ($key)
		{
			case 'system.paths.root' :
				return realpath(dirname(__FILE__) . '/../../');//Change the path
				break;

			case 'system.translated_applications':
				return ['portal' => ['en', 'hu']];

			default:
				return;
		}
	}
}