<?php 

namespace PreApp;

class Model
{
	public function __construct() {}
	
	public function set($key, $value) 
	{
		$Container = \PreApp\Container::getInstance();
	
		$Container->set($key, $value);
	}
	
	public function get($key) 
	{
		$Container = \PreApp\Container::getInstance();
	
		return $Container->get($key);
	}
	
	public function raw($key) 
	{
		$Container = \PreApp\Container::getInstance();
	
		return $Container->raw($key);
	}
	
	public function has($key) 
	{
		$Container = \PreApp\Container::getInstance();
	
		return $Container->has($key);
	}
	
	public function unset($key) 
	{
		$Container = \PreApp\Container::getInstance();
	
		$Container->unset($key);
	}
	
	public function extend($key, $callable) 
	{
		$Container = \PreApp\Container::getInstance();
	
		return $Container->extend($key, $callable);
	}
}
