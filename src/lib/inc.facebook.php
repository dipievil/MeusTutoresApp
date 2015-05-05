<?php
	
	define('FACEBOOK_SDK_V4_SRC_DIR', '../vendor/facebook/src/Facebook/');
	
	require __DIR__ . '/../vendor/facebook/autoload.php';

	use Facebook\FacebookSession;
	
	FacebookSession::setDefaultApplication('1416196658700730', 'fcfd80cee261302a99104f535b376815');	
	
