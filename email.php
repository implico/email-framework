<?php

/**
 * Implico Email Framework
 * 	
 * @author Bartosz Sak <info@implico.pl>
 * 
*/

if (php_sapi_name() != "cli") {
	exit('This script can be run only from the command line.');
}

/*
  DIRS
*/

//root dir
define('IE_ROOT_DIR', __DIR__);
//core dir
define('IE_CORE_DIR', IE_ROOT_DIR.'/core/');
//custom dir
define('IE_CUSTOM_DIR', IE_ROOT_DIR.'/custom/');
//projects dir
define('IE_PROJECTS_DIR', IE_ROOT_DIR.'/projects/');
//cache dir
define('IE_SMARTY_COMPILE_DIR', IE_ROOT_DIR.'/.cache/');
//plugins dir
define('IE_SMARTY_PLUGINS_DIR', IE_CORE_DIR.'/plugins/');
//custom plugins dir
define('IE_SMARTY_CUSTOM_PLUGINS_DIR', IE_CUSTOM_DIR.'/plugins/');

ini_set('display_errors', 'off');

require_once(IE_ROOT_DIR.'/vendor/autoload.php');


use Symfony\Component\Console\Application;


$app = new Application('Implico Email Framework', '0.0.1');
$app->add(new \Implico\Email\Commands\Compile());
$app->add(new \Implico\Email\Commands\Send());
$app->run();
