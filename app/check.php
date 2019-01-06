<?php

if( version_compare(phpversion(), '7.0', '<') == true ) {
	
	$this->get('Logger')->error(_('PHP 7.0+ required.'));
	
	putenv('PREAPP_ENABLED=false');
}

if( !extension_loaded('mbstring') ) {
	
	$this->get('Logger')->error(_('Missing mbstring extension.'));
	
	putenv('PREAPP_ENABLED=false');	
}

if( !extension_loaded('zlib') ) {
	
	$this->get('Logger')->error(_('Missing zlib extension.'));
	
	//putenv('PREAPP_ENABLED=false');
}
