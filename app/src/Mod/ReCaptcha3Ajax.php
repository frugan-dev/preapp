<?php

namespace PreApp\Mod;

class ReCaptcha3Ajax extends \PreApp\Model
{
	public function prepend()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->get('Logger')->info( __CLASS__ .' -> '. __FUNCTION__ );
			
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			
				if(isset($_POST['g-recaptcha-response'])) {
					
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
					
					if( !$resp->isSuccess()) {
	
					    $this->get('Logger')->warning( __CLASS__ .' -> '. __FUNCTION__ , $resp->toArray() );

                        header("HTTP/1.0 400 Bad Request");
					    die();
					}

				} else {

                    header("HTTP/1.0 400 Bad Request");
                    die();
                }
				
			} else {

                header("HTTP/1.0 400 Bad Request");
                die();
            }
		}
	}

    public function append()
    {
        if(file_exists(PREAPP_ROOT.'/app/view/recaptcha3ajax_field.php')) {

            ob_start();
            include_once PREAPP_ROOT.'/app/view/recaptcha3ajax_field.php';
            $buffer = ob_get_contents();
            ob_end_clean();

            $this->set('buffer', preg_replace(
                '/\<\/form\>/',
                PHP_EOL.$buffer.'</form>',
                $this->get('buffer')
            ));
        }

        if(file_exists(PREAPP_ROOT.'/app/view/recaptcha3ajax_script.php')) {

            ob_start();
            include_once PREAPP_ROOT.'/app/view/recaptcha3ajax_script.php';
            $buffer = ob_get_contents();
            ob_end_clean();

            $this->set('buffer', preg_replace(
                '/\<\/body\>/',
                PHP_EOL.$buffer.'</body>',
                $this->get('buffer')
            ));
        }
    }
}
