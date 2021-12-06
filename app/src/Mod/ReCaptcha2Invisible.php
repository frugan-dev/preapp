<?php

namespace PreApp\Mod;

class ReCaptcha2Invisible extends \PreApp\Model
{
	public function prepend()
	{
		if(apache_getenv('REQUEST_METHOD') === 'POST') {
			
			if(!apache_getenv('HTTP_X_REQUESTED_WITH') || mb_strtolower(apache_getenv('HTTP_X_REQUESTED_WITH')) !== 'xmlhttprequest') {
				
				$this->get('Logger')->info( __CLASS__ .' -> '. __FUNCTION__ );
			
				if(isset($_POST['g-recaptcha-response']) && isset($_POST['preapp_postdata'])) {
					
					$_POST = $_POST + json_decode(base64_decode($_POST['preapp_postdata']), true);
					
					unset($_POST['preapp_postdata']);
					unset($_REQUEST['preapp_postdata']);
					
					$_REQUEST = $_REQUEST + $_POST;
					
					//http://stackoverflow.com/a/30848193
					if(ini_get('allow_url_fopen')) {
					
						$recaptcha = new \ReCaptcha\ReCaptcha( env('PREAPP_GOOGLE_RECAPTCHA2_PRIVATE_KEY') );
					
					} else {
					
						$recaptcha = new \ReCaptcha\ReCaptcha( env('PREAPP_GOOGLE_RECAPTCHA2_PRIVATE_KEY'), new \ReCaptcha\RequestMethod\CurlPost());
						//$recaptcha = new \ReCaptcha\ReCaptcha( env('PREAPP_GOOGLE_RECAPTCHA2_PRIVATE_KEY'), new \ReCaptcha\RequestMethod\SocketPost());
					}
					
					$resp = $recaptcha->setExpectedHostname( apache_getenv('HTTP_HOST') )
								->verify( $_POST['g-recaptcha-response'], apache_getenv('REMOTE_ADDR') );
					
					if( !$resp->isSuccess() && file_exists(PREAPP_ROOT.'/app/view/recaptcha_error.php')) {
	
					    $this->get('Logger')->warning( __CLASS__ .' -> '. __FUNCTION__ , $resp->toArray() );
					    
					    include_once PREAPP_ROOT.'/app/view/recaptcha_error.php';
						exit();
					}
					
				} elseif(file_exists(PREAPP_ROOT.'/app/view/recaptcha2invisible.php')) {
					
					$postdata = json_encode($_POST);
					
					include_once PREAPP_ROOT.'/app/view/recaptcha2invisible.php';
					exit();
				}
			}
		}
	}
}
