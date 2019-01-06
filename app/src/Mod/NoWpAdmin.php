<?php

namespace PreApp\Mod;

class NoWpAdmin extends \PreApp\Model
{
	public function prepend()
	{
		$path = parse_url(apache_getenv('REQUEST_URI'), PHP_URL_PATH);
		
		if(!empty($path)) {
			
			$paths = explode('/', $path);
			
			$paths = array_values(array_filter($paths));
			
			if(count($paths) > 0) {
			
				if(count(array_intersect($paths, ['wp-admin'])) > 0) {
					
					$this->set('skip', true);
				}
			}
		}
	}
	
	public function append()
	{
		if(defined('WPINC') && function_exists( 'is_admin' )) {
			
			if( is_admin() ) {
				
				$this->set('skip', true);
			}
		}
	}
}
