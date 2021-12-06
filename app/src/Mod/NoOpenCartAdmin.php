<?php

namespace PreApp\Mod;

class NoOpenCartAdmin extends \PreApp\Model
{
	public function prepend()
	{
		$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		
		if(!empty($path)) {
			
			$paths = explode('/', $path);
			
			$paths = array_values(array_filter($paths));
			
			if(count($paths) > 0) {
			
				if(count(array_intersect($paths, ['admin'])) > 0) {
			
					$this->set('skip', true);
				}
			}				
		}
	}
	
	public function append()
	{
		if(defined('DIR_CATALOG') && defined('HTTP_CATALOG')) {
			
			$this->set('skip', true);
		}
	}
}
