<?php

namespace PreApp\Mod;

class NoWpLogin extends \PreApp\Model
{
	public function prepend()
	{
		if( in_array(basename(apache_getenv('SCRIPT_NAME')), ['wp-login.php', 'wp-register.php'], true) ) {
			
			$this->set('skip', true);				
		}
	}
	
	public function append()
	{
		if(defined('WPINC') && isset($GLOBALS['pagenow'])) {
			
			if( in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'], true) ) {
				
				$this->set('skip', true);
			}
		}
	}
}
