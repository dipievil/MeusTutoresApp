<?php

	require_once('../php/inc.facebook.php');

	session_start();
	
	use Facebook\GraphUser;
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
	
		
?>