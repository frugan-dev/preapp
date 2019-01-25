<?php

namespace PreApp\Mod;

use Monolog\Handler\RavenHandler;

class Sentry extends \PreApp\Model
{
	public function prepend()
	{
		$this->set('Vendor\Raven_Client', (new \Raven_Client( env('PREAPP_SENTRY_DSN'), [
			'environment' => env('PREAPP_ENV'),
			'debug' => env('PREAPP_DEBUG'),
		]))->install());
		
		if($this->has('Vendor\Logger')) {
		
			$RavenHandler = new RavenHandler( $this->get('Vendor\Raven_Client'), \Monolog\Logger::ERROR );
						
			$this->get('Vendor\Logger')->pushHandler( $RavenHandler );
				
			$Raven_Breadcrumbs_MonologHandler = new \Raven_Breadcrumbs_MonologHandler( $this->get('Vendor\Raven_Client'), \Monolog\Logger::ERROR );
						
			$this->get('Vendor\Logger')->pushHandler( $Raven_Breadcrumbs_MonologHandler );
		}
		
		//https://stackoverflow.com/a/34164495
		// This script tag should be included after other libraries are loaded, but before your main application code (e.g. app.js)	
		if(file_exists(PREAPP_ROOT.'/app/view/sentry.php')) {
			
			ob_start();
			include_once PREAPP_ROOT.'/app/view/sentry.php';
			$this->set('sentry_buffer', ob_get_contents());
			ob_end_clean();
		}	
	}
	
	public function append()
	{
		if($this->has('sentry_buffer')) {
			
			$this->set('buffer', preg_replace(
				'/\<\/head\>/',
				PHP_EOL.$this->get('sentry_buffer').'</head>',
				$this->get('buffer')
			));
		}
	}
}
