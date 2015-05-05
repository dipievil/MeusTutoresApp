<?php

	session_start();
	
	require_once('../lib/inc.facebook.php');
	
	use Facebook\FacebookRedirectLoginHelper;
	
	$redirectUrl = 'http://meustutoresapp.esy.es/class/class.facebook.php';
	$helper = new FacebookRedirectLoginHelper($redirectUrl);
	$loginUrl = $helper->getLoginUrl();
	
	header("location:".$loginUrl);
	
?>