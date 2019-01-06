<?php

define('PREAPP_ROOT', __DIR__);

require PREAPP_ROOT.'/vendor/autoload.php';

Env::init();

require PREAPP_ROOT.'/app/helpers.php';
require PREAPP_ROOT.'/app/env.php';

(new \Dotenv\Dotenv(PREAPP_ROOT.'/app/config'))->load();

if(file_exists(PREAPP_ROOT.'/app/config/.env.'.apache_getenv('SERVER_ADDR'))) 
	(new \Dotenv\Dotenv(PREAPP_ROOT.'/app/config', '.env.'.apache_getenv('SERVER_ADDR')))->overload();

if(file_exists(PREAPP_ROOT.'/app/config/.env.'.str_replace('www.', '', apache_getenv('HTTP_HOST')))) 
	(new \Dotenv\Dotenv(PREAPP_ROOT.'/app/config', '.env.'.str_replace('www.', '', apache_getenv('HTTP_HOST'))))->overload();

if(file_exists(PREAPP_ROOT.'/app/config/.env.'.str_replace('www.', '', apache_getenv('HTTP_HOST').'.'.apache_getenv('SERVER_ADDR')))) 
	(new \Dotenv\Dotenv(PREAPP_ROOT.'/app/config', '.env.'.str_replace('www.', '', apache_getenv('HTTP_HOST').'.'.apache_getenv('SERVER_ADDR'))))->overload();

foreach(['private', 'homes'] as $dir) {
	
	// Note: The running script must have executable permissions on all directories in the hierarchy, otherwise realpath() will return FALSE.
	// suppress open_basedir restriction warning
	if(@file_exists(apache_getenv('DOCUMENT_ROOT').'/../'.$dir.'/.preapp')) 
		(new \Dotenv\Dotenv(apache_getenv('DOCUMENT_ROOT').'/../'.$dir, '.preapp'))->overload();
	elseif(@file_exists(apache_getenv('DOCUMENT_ROOT').'/../../../'.$dir.'/.preapp')) 
		(new \Dotenv\Dotenv(apache_getenv('DOCUMENT_ROOT').'/../../../'.$dir, '.preapp'))->overload();
}
	
$PreApp = new \PreApp\PreApp();

return $PreApp;
