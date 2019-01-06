<?php

$PreApp = require_once __DIR__.'/bootstrap.php';

if( env('PREAPP_ENABLED') ) {
	
	$PreApp->prepend();
	
	// The callback function will be called when the output buffer is flushed (sent) 
	// or cleaned (with ob_flush(), ob_clean() or similar function) 
	// or when the output buffer is flushed to the browser at the end of the request.	
	ob_start([$PreApp, 'append']);
}
