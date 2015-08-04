<?php

/**
 * 
 * 
 * GNU General Public License (Version 2, June 1991) 
 * 
 * This program is free software; you can redistribute 
 * it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free 
 * Software Foundation; either version 2 of the License, 
 * or (at your option) any later version. 
 * 
 * This program is distributed in the hope that it will 
 * be useful, but WITHOUT ANY WARRANTY; without even the 
 * implied warranty of MERCHANTABILITY or FITNESS FOR A 
 * PARTICULAR PURPOSE. See the GNU General Public License 
 * for more details. 
 *
 * @author Corey Maynard <http://coreymaynard.com/>
 * @author Rafał Przetakowski <rprzetakowski@pr-projektos.pl>
 */
session_start();

function __autoload($className) {
	if (file_exists("restObjects/rest_$className.php")) {
		require_once "restObjects/rest_$className.php";
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

