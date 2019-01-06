<?php

if( !function_exists( 'sd' ) ) {

	function sd($var)
	{
	    s($var);
	    die();
	}
}

if( !function_exists( 'apache_getenv' ) ) {
	
	function apache_getenv()
	{
		$args = func_get_args();
		
		if(isset($_SERVER[$args[0]]))
			return $_SERVER[$args[0]];
		
		return call_user_func_array('env', $args);
	}
}
