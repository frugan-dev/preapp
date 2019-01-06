<?php

namespace PreApp\ModCustom;

class ReCaptcha3OpencartDomainTld extends \PreApp\Mod\ReCaptcha3
{
	public function prepend()
	{
		if(isset($_GET['route']) && in_array($_GET['route'], ['information/contact', 'account/register'], true)) {
			
			parent::prepend();
		}
	}
}
