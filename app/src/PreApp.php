<?php 

namespace PreApp;

use Nette\Utils\Strings;

class PreApp extends \PreApp\Model
{
	private $domain;
	private $camelCaseDomain;
	private $mod = [];
	
	public function __construct() 
	{
		if( env('PREAPP_ENABLED') ) {
			
			$this->setDomain();
			$this->setCamelCaseDomain();
			$this->setMod();
			
			$this->set('domain', $this->getDomain());
			$this->set('camelCaseDomain', $this->getCamelCaseDomain());
			$this->set('mod', $this->getMod());
			$this->set('skip', false);
			
			$this->set('Logger', new \PreApp\Logger);
			
			require PREAPP_ROOT.'/app/check.php';
		}
	}
	
	public function setDomain()
	{
		$this->domain = str_replace('www.', '', apache_getenv('HTTP_HOST'));
	}
	
	public function getDomain()
	{
		return $this->domain;
	}
	
	public function setCamelCaseDomain()
	{
		$this->camelCaseDomain = Strings::webalize($this->getDomain());
		$this->camelCaseDomain = Strings::capitalize(str_replace('-', ' ', $this->camelCaseDomain));
		$this->camelCaseDomain = str_replace(' ', '', $this->camelCaseDomain);
	}
	
	public function getCamelCaseDomain()
	{
		return $this->camelCaseDomain;
	}
	
	public function setMod()
	{
		$this->mod = explode(',', env('PREAPP_MOD'));
	}
	
	public function getMod()
	{
		return $this->mod;
	}
	
	public function prepend()
	{
		if( env('PREAPP_MOD') ) {
			
			foreach($this->getMod() as $mod) {	
				
				if($this->get('skip'))
					break;
				
				$namespace = ucwords('\PreApp\ModCustom\\'.$mod.$this->getCamelCaseDomain(), '\\');
				
				if(!class_exists($namespace))
					$namespace = ucwords('\PreApp\Mod\\'.$mod, '\\');
				
				if(class_exists($namespace)) {
					
					$this->set('Mod\\'.ucfirst($mod), new $namespace);				
					
					if(method_exists($this->get('Mod\\'.ucfirst($mod)), __FUNCTION__) && is_callable([$this->get('Mod\\'.ucfirst($mod)), __FUNCTION__])) {
				
						call_user_func([$this->get('Mod\\'.ucfirst($mod)), __FUNCTION__]);				
					}
				}
			}
		}
	}
	
	public function append( $buffer )
	{
		if(empty($buffer))
			return;
		
		if( env('PREAPP_MOD') ) {
			
			// suppress gz*(): data error
			if(($buffer_gzdecoded = @gzdecode($buffer)) !== false)
				$buffer = $buffer_gzdecoded;
			elseif(($buffer_gzinflated = @gzinflate($buffer)) !== false)
				$buffer = $buffer_gzinflated;
			elseif(($buffer_gzuncompressed = @gzuncompress($buffer)) !== false)
				$buffer = $buffer_gzuncompressed;
			
			$this->set('buffer', $buffer);
			
			foreach($this->getMod() as $mod) {	
				
				if($this->get('skip'))
					break;
				
				$namespace = ucwords('\PreApp\ModCustom\\'.$mod.$this->getCamelCaseDomain(), '\\');
				
				if(!class_exists($namespace))
					$namespace = ucwords('\PreApp\Mod\\'.$mod, '\\');
				
				if(class_exists($namespace)) {
					
					$this->set('Mod\\'.ucfirst($mod), new $namespace);				
					
					if(method_exists($this->get('Mod\\'.ucfirst($mod)), __FUNCTION__) && is_callable([$this->get('Mod\\'.ucfirst($mod)), __FUNCTION__])) {
				
						call_user_func([$this->get('Mod\\'.ucfirst($mod)), __FUNCTION__]);				
					}
				}
			}
			
			if($buffer_gzdecoded !== false)
				$this->set('buffer', gzencode($this->get('buffer'), 9));
			elseif(isset($buffer_gzinflated) && $buffer_gzinflated !== false)
				$this->set('buffer', gzdeflate($this->get('buffer'), 9));
			elseif(isset($buffer_gzuncompressed) && $buffer_gzuncompressed !== false)
				$this->set('buffer', gzcompress($this->get('buffer'), 9));
			
			$buffer = $this->get('buffer');
		}	
		
		return $buffer;
	}
}

