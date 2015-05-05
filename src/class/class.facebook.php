<?php

include('../lib/inc.facebook.php');

use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookJavaScriptLoginHelper;

class queryFacebook {

		/**
		 * Classe do constructor
         */
		public function __construct(){

		}

		/**
		 * Verifica se tem um usuário logado no Facebook
		 * @return bool True se está logado
         */
		public function VerificarUserLogado(){
            $session = null;
            $logado = false;

            $helper = new FacebookRedirectLoginHelper('http://meustutoresapp.esy.es/lib/helper.FacebookRedirect.php');
            try {
                $session = $helper->getSessionFromRedirect();
            } catch(FacebookRequestException $ex) {
                // When Facebook returns an error
                echo $ex;
            } catch(\Exception $ex) {
                // When validation fails or other local issues
                echo $ex;
            }

            /*
            $facebookHelper = new FacebookJavaScriptLoginHelper();
            try {
                $session = $facebookHelper->getSession();
            } catch(FacebookRequestException $ex) {
                // When Facebook returns an error
            } catch(\Exception $ex) {
                // When validation fails or other local issues
            }
            if ($session) {
                // Logged in
            }
            */



            if($session) {
                $logado = true;
            }

			return $logado;
		}

        /**
         * @param bool|null $jsonData False para retornar em JSON
         * @return array|string Array ou JSON com os dados do usuário
         */
        public function BuscarDadosLogado($jsonData = false){
            $arDadosLogado = array();
            $session = null;

            include('../lib/inc.facebook.php');
            if($session) {
                try {
                    $user_profile = (new FacebookRequest(
                        $session, 'GET', '/me'
                    ))->execute()->getGraphObject(GraphUser::className());
                    echo $arDadosLogado['nome'] = $user_profile->getName();
                } catch(FacebookRequestException $e) {
                    echo "Exception ocorreu, code: " . $e->getCode();
                    echo " with message: " . $e->getMessage();
                }
            }


            if($jsonData){
                return json_encode($arDadosLogado);
            } else {
                return $arDadosLogado;
            }
        }

		/*
		 *
		 * 	use Facebook\GraphUser;
	// add other classes you plan to use, e.g.:
	 use Facebook\FacebookRequest;
	 use Facebook\FacebookRedirectLoginHelper;

	//use Facebook\GraphUser;
	use Facebook\FacebookRequestException;

	// use Facebook\GraphUser;
	// use Facebook\FacebookRequestException;

	// Add `use Facebook\FacebookRedirectLoginHelper;` to top of file
	//$helper = new FacebookRedirectLoginHelper('your redirect URL here');
	//$loginUrl = $helper->getLoginUrl();
	// Use the login url on a link or button to
	// redirect to Facebook for authentication

	print_r($_SESSION);
	//$session = new FacebookSession('access token here');
	$helper = new FacebookRedirectLoginHelper('http://meustutoresapp.esy.es/html');
	try {
		echo 'oi';
	    $session = $helper->getSessionFromRedirect();
	} catch(FacebookRequestException $ex) {
	    // When Facebook returns an error
		echo $ex;
	} catch(\Exception $ex) {
	    // When validation fails or other local issues
		echo $ex;
	}

	if ($session) {
	  // Logged in.
		$request = new FacebookRequest($session, 'GET', '/me');
		$response = $request->execute();
		print_r($session);
		$graphObject = $response->getGraphObject();
	} else {
		echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
	}

		 *
		 *
		 */

	}


?>