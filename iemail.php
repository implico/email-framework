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
//sample dir
define('IE_SAMPLE_DIR', IE_ROOT_DIR.'/samples/');
//projects dir
define('IE_PROJECTS_DIR', getcwd() . DIRECTORY_SEPARATOR);//IE_ROOT_DIR.'/projects/');
//custom dir
define('IE_CUSTOM_DIR', IE_PROJECTS_DIR.'/_custom/');
//cache dir
define('IE_SMARTY_COMPILE_DIR', IE_ROOT_DIR.'/.cache/');
//plugins dir
define('IE_SMARTY_PLUGINS_DIR', IE_CORE_DIR.'/plugins/');
//custom plugins dir
define('IE_SMARTY_CUSTOM_PLUGINS_DIR', IE_CUSTOM_DIR.'/plugins/');

ini_set('display_errors', 'off');
ini_set('date.timezone', 'Europe/London');	//anything to disable warnings


require_once(IE_ROOT_DIR.'/vendor/autoload.php');


use Symfony\Component\Console\Application;


$app = new Application('Implico Email Framework', '0.0.1');
$app->add(new \Implico\Email\Commands\Init());
$app->add(new \Implico\Email\Commands\Compile());
$app->add(new \Implico\Email\Commands\Send());
$app->run();
