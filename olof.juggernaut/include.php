<?php

namespace Jugger;

use Bitrix\Main\Loader;
use Jugger\Psr\Psr4\Autoloader;

include_once __DIR__. '/lib/Psr/Psr4/Autoloader.php';

Loader::includeModule("iblock");

spl_autoload_register('\Jugger\Psr\Psr4\Autoloader::loadClass');

Autoloader::addNamespace("Jugger", __DIR__.'/lib');

Autoloader::addNamespace("Components", $_SERVER['DOCUMENT_ROOT'] ."/local/components");
Autoloader::addNamespace("Components", $_SERVER['DOCUMENT_ROOT']."/bitrix/components");

Autoloader::addNamespace("Modules", $_SERVER['DOCUMENT_ROOT'] ."/local/modules");
Autoloader::addNamespace("Modules", $_SERVER['DOCUMENT_ROOT']."/bitrix/modules");