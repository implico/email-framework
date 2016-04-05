<?php

/**
	Implico Email Framework
	
	@author Bartosz Sak <info@implico.pl>
	
*/

if (php_sapi_name() != "cli") {
	exit('This script can be run only from the command line.');
}

define('IE_ROOT_DIR', __DIR__);
define('IE_PROJECTS_DIR', IE_ROOT_DIR.'/projects/');
define('IE_COMPILE_DIR', IE_ROOT_DIR.'/compiled/');
define('IE_CORE_DIR', IE_ROOT_DIR.'/core/');

require_once(IE_ROOT_DIR.'/vendor/autoload.php');


use Symfony\Component\Console\Application;


$app = new Application('Implico Email Framework', '0.0.1');
$app->add(new \ImplicoEmail\Commands\Compile());
$app->add(new \ImplicoEmail\Commands\Send());
$app->run();
