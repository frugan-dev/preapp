<?php 

//https://chrishewett.com/blog/monolog-human-readable-exception-email-with-stack-trace/

namespace PreApp;

use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\DeduplicationHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\TagProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;

class Logger extends \PreApp\Model
{		
	public function __construct()
	{	
		$this->set('Vendor\Logger', new \Monolog\Logger('debug'));
		
		$RotatingFileHandler = new RotatingFileHandler( PREAPP_ROOT.'/var/'.env('PREAPP_ENV').'/log/debug-'.$this->get('domain').'.log', 500, \Monolog\Logger::DEBUG, true, 0777 );					
		$this->get('Vendor\Logger')->pushHandler( $RotatingFileHandler );
				
		$this->get('Vendor\Logger')->pushProcessor(new UidProcessor()); // Adds a unique identifier to a log record.
		$this->get('Vendor\Logger')->pushProcessor(new ProcessIdProcessor()); // Adds the process id to a log record.
		$this->get('Vendor\Logger')->pushProcessor(new IntrospectionProcessor(\Monolog\Logger::INFO)); // Adds the line/file/class/method from which the log call originated.	
		$this->get('Vendor\Logger')->pushProcessor(new WebProcessor()); // Adds the current request URI, request method and client IP to a log record.
		$this->get('Vendor\Logger')->pushProcessor(new MemoryUsageProcessor()); // Adds the current memory usage to a log record.
		$this->get('Vendor\Logger')->pushProcessor(new MemoryPeakUsageProcessor()); // Adds the peak memory usage to a log record.
					
		$this->get('Vendor\Logger')->pushProcessor(function ($record) {
			
			if(isset($_REQUEST) && (is_array($_REQUEST) || $_REQUEST instanceof \ArrayAccess))
				$record['extra']['_REQUEST'] = $_REQUEST;
			
			if(isset($_POST) && (is_array($_POST) || $_POST instanceof \ArrayAccess))
				$record['extra']['_POST'] = $_POST;
			
			if(isset($_SESSION) && (is_array($_SESSION) || $_SESSION instanceof \ArrayAccess))
				$record['extra']['_SESSION'] = $_SESSION;	
			
			if(isset($_FILES) && (is_array($_FILES) || $_FILES instanceof \ArrayAccess))
				$record['extra']['_FILES'] = $_FILES;	
			
			if(isset($_COOKIES) && (is_array($_COOKIES) || $_COOKIES instanceof \ArrayAccess))
				$record['extra']['_COOKIES'] = $_COOKIES;	
			
			if(isset($_SERVER) && (is_array($_SERVER) || $_SERVER instanceof \ArrayAccess)) {
				$record['extra']['_SERVER'] = $_SERVER;	
			}
			
			foreach(['password', 'password_retyped'] as $val) {
				if(isset($record['extra']['_REQUEST'][$val]))
					unset($record['extra']['_REQUEST'][$val]);
		
				if(isset($record['extra']['_POST'][$val]))
					unset($record['extra']['_POST'][$val]);
			}
			
			return $record;
		});
				
		if(env('PREAPP_DEBUG')) {
			
			$this->get('Vendor\Logger')->pushHandler(new BrowserConsoleHandler());
		}
		
		$NativeMailerHandler = new NativeMailerHandler( 
			env('PREAPP_EMAIL_TO'),
			sprintf(_('Error reporting from %1$s - %2$s'), parse_url(env('HTTP_HOST'), PHP_URL_HOST), env('PREAPP_ENV')),
			env('PREAPP_EMAIL_FROM'),
			\Monolog\Logger::ERROR
		);
		$NativeMailerHandler->setContentType('text/html');
		$NativeMailerHandler->setFormatter(new HtmlFormatter());
		
		if(env('PREAPP_DEBUG')) {
			
			$this->get('Vendor\Logger')->pushHandler( $NativeMailerHandler );
			
		} else {
			
			$DeduplicationHandler = new DeduplicationHandler( $NativeMailerHandler, PREAPP_ROOT.'/var/'.env('PREAPP_ENV').'/log/dedup-'.$this->get('domain').'.log', \Monolog\Logger::ERROR, 86400);
			
			$this->get('Vendor\Logger')->pushHandler( $DeduplicationHandler );
		}
	}
		
	public function log($level, $message, array $context = [])
    {
    	$this->get('Vendor\Logger')->log($level, $message, $context);
    }
	
	public function debug($message, array $context = [])
    {
        return $this->log(\Monolog\Logger::DEBUG, $message, $context);
    }
    
    public function info($message, array $context = [])
    {
       return $this->log(\Monolog\Logger::INFO, $message, $context);
    }
    
    public function notice($message, array $context = [])
    {
       return $this->log(\Monolog\Logger::NOTICE, $message, $context);
    }
    
    public function warning($message, array $context = [])
    {
       return $this->log(\Monolog\Logger::WARNING, $message, $context);
    }
	
	public function error($message, array $context = [])
    {
        return $this->log(\Monolog\Logger::ERROR, $message, $context);
    }
    
    public function critical($message, array $context = [])
    {
        return $this->log(\Monolog\Logger::CRITICAL, $message, $context);
    }
    
    public function alert($message, array $context = [])
    {
        return $this->log(\Monolog\Logger::ALERT, $message, $context);
    }
    
    public function emergency($message, array $context = [])
    {
        return $this->log(\Monolog\Logger::EMERGENCY, $message, $context);
    }
}
