<?php

namespace PreApp\Mod;

class NoJoomlaAdmin extends \PreApp\Model
{
	public function prepend()
	{
		$path = parse_url(apache_getenv('REQUEST_URI'), PHP_URL_PATH);
		
		if(!empty($path)) {
			
			$paths = explode('/', $path);
			
			$paths = array_values(array_filter($paths));
			
			if(count($paths) > 0) {
			
				if(count(array_intersect($paths, ['administrator'])) > 0) {
			
					$this->set('skip', true);
				}
			}				
		}
	}
	
	public function append()
	{
		if(defined('_JEXEC')) {
			
			if(class_exists('\JFactory')) {
			
				if((\JFactory::getApplication())->isAdmin()) {
				
					$this->set('skip', true);
				}
			}
		}
	}
}
