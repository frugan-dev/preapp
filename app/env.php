<?php

if( count(array_intersect([PHP_SAPI, php_sapi_name()], ['cli', 'cli-server'])) > 0 )
	putenv('PREAPP_ENABLED=false');

if( in_array($_SERVER['SERVER_ADDR'], ['127.0.1.1', '::1', 'fe80::1']) )
    $_SERVER['SERVER_ADDR'] = '127.0.0.1';
