<?php

namespace PreApp\Mod;

class ObfuscateEmail extends \PreApp\Model
{
	public function append()
	{
		//$pattern = '/([A-Za-z0-9._%-]+)@([A-Za-z0-9._%-]+).([A-Za z]{2,4})/';
		//$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		$pattern = '/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/';
		
		$this->set('buffer', preg_replace_callback(
			$pattern,
			function ( $matches ) {
				return $this->obfuscate( $matches[0] );
			},
			$this->get('buffer')
		));
	}
	
	protected function obfuscate( $string )
	{
		switch( env('PREAPP_OBFUSCATE_EMAIL_TYPE') ) {
			
			default:
				
				$safe = '';
	    
				foreach (str_split($string) as $letter)
				{
				    if (ord($letter) > 128) return $letter;
				    
				    // To properly obfuscate the value, we will randomly convert each letter to
				    // its entity or hexadecimal representation, keeping a bot from sniffing
				    // the randomly obfuscated letters out of the string on the responses.
				    switch (rand(1, 3))
				    {
				        case 1:
				            $safe .= '&#'.ord($letter).';'; break;
				            
				        case 2:
				            $safe .= '&#x'.dechex(ord($letter)).';'; break;
				            
				        case 3:
				            $safe .= $letter;
				    }
				}
				
				$string = $safe;
				
				break;
		}
		
		return $string;
	}
}
