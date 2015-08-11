<?php

require_once("classes/classes.mysql.php");
require_once("classes/classes.query.php");


session_start();

function __autoload($className) {
	if (file_exists("rest/rest_$className.php")) {
		require_once "rest/rest_$className.php";
	} else if (file_exists("$className.php")) {
		require_once "$className.php";
	} else {
		user_error("There is no $className", 'E_ERROR');
	}
}

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
	$_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}


try {
	$API = new restServer($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);

	/* register objects */
	$API->register('User');

	/* process API */
	echo $API->processAPI();
} catch (Exception $e) {
	echo json_encode(Array('error' => $e->getMessage()));
}

echo "\n";

