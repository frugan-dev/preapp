<?php 

namespace PreApp;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;
use Pimple\Container as PimpleContainer;

class Container extends PimpleContainer implements ContainerInterface {
	
	private static $instance = null;
	
	public static function getInstance() 
	{
		if(self::$instance === null) {
			self::$instance = new Container();
		}
	
		return self::$instance;
	}
	
	public function set( $key, $value ) 
	{
		$this->offsetSet( $key, $value );
	}
	
	public function get( $key )
	{
		return $this->offsetGet( $key );
	}
	
	public function has( $key )
	{
		return $this->offsetExists( $key );
	}
	
	public function unset( $key )
	{
		$this->offsetUnset( $key );
	}
}
