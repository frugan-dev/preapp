<?php

namespace PreApp\Mod;

class MinifyHtml extends \PreApp\Model
{
	public function append()
	{
		$parser = \WyriHaximus\HtmlCompress\Factory::construct();
		
		$this->set('buffer', $parser->compress( $this->get('buffer') ));
	}
}
