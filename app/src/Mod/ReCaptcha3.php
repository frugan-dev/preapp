<?php

namespace PreApp\Mod;

class ReCaptcha3 extends \PreApp\Model
{
	public function prepend()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
				
				$this->get('Logger')->info( __CLASS__ .' -> '. __FUNCTION__ );
			
				if(isset($_POST['g-recaptcha-response']) && isset($_POST['preapp_postdata'])) {
					
					$_POST = $_POST + json_decode(base64_decode($_POST['preapp_postdata']), true);
					
					unset($_POST['preapp_postdata']);
					unset($_REQUEST['preapp_postdata']);
					
					$_REQUEST = $_REQUEST + $_POST;
					
					//http://stackoverflow.com/a/30848193
					if(ini_get('allow_url_fopen')) {
					
						$recaptcha = new \ReCaptcha\ReCaptcha( env('PREAPP_GOOGLE_RECAPTCHA3_PRIVATE_KEY') );
					
					} else {
					
						$recaptcha = new \ReCaptcha\ReCaptcha( env('PREAPP_GOOGLE_RECAPTCHA3_PRIVATE_KEY'), new \ReCaptcha\RequestMethod\CurlPost());
						//$recaptcha = new \ReCaptcha\ReCaptcha( env('PREAPP_GOOGLE_RECAPTCHA3_PRIVATE_KEY'), new \ReCaptcha\RequestMethod\SocketPost());
					}
					
					$resp = $recaptcha->setExpectedHostname( $_SERVER['HTTP_HOST'] )
								->setExpectedAction( $this->get('camelCaseDomain') ) // Note: actions may only contain alphanumeric characters and slashes, and must not be user-specific.
								->setScoreThreshold( env('PREAPP_RECAPTCHA3_SCORE_THRESHOLD') )
								->verify( $_POST['g-recaptcha-response'], $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? null );
					
					if( !$resp->isSuccess() && file_exists(PREAPP_ROOT.'/app/view/recaptcha_error.php')) {
	
					    $this->get('Logger')->warning( __CLASS__ .' -> '. __FUNCTION__ , $resp->toArray() );
					    
					    include_once PREAPP_ROOT.'/app/view/recaptcha_error.php';
						exit();
					}
					
				} elseif(file_exists(PREAPP_ROOT.'/app/view/recaptcha3.php')) {
					
					$postdata = json_encode($_POST);
					
					include_once PREAPP_ROOT.'/app/view/recaptcha3.php';
					exit();
				}
			}
		}
	}
}
