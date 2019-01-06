<?php

// no env() because auto_prepend_file could be overridden
if( getenv('PREAPP_ENABLED') ) {
	
	// http://php.net/manual/en/function.ob-start.php#56830
	// If outbut buffering is still active when the script ends, PHP outputs it automatically. 
	// In effect, every script ends with ob_end_flush().
	ob_end_flush();
}
