<?php

namespace PreApp\Mod;

class Polyfill extends \PreApp\Model
{
	public function prepend()
	{
		//https://stackoverflow.com/a/34164495
		if(file_exists(PREAPP_ROOT.'/app/view/polyfill.php')) {
			
			ob_start();
			include_once PREAPP_ROOT.'/app/view/polyfill.php';
			$this->set('polyfill_buffer', ob_get_contents());
			ob_end_clean();
		}	
	}
	
	public function append()
	{
		if($this->has('polyfill_buffer')) {
			
			$this->set('buffer', preg_replace(
				'/\<\/head\>/',
				PHP_EOL.$this->get('polyfill_buffer').'</head>',
				$this->get('buffer')
			));
		}
	}
}
