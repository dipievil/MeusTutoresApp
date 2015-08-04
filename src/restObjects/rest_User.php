<?php

/**
 * Rest object example
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
 * @author Rafał Przetakowski <rprzetakowski@pr-projektos.pl>
 */
class User extends restObject {

	/**
	 * user data
	 */
	public $id;
	public $name;
	public $lastName;
	public $login;

	/**
	 * 
	 * @param string $method
	 * @param array $request
	 * @param string $file
	 */
	public function __construct($method, $request = null, $file = null) {
		parent::__construct($method, $request, $file);
	}

	/**
	 * Login example
	 * @return array
	 */
	public function login() {
		if (!$this->isMethodCorrect('POST')) {
			return $this->getResponse();
		}
		
		if (isset($_SESSION['auth_id'])) {
			$this->setError( "User already logged" );
			return $this->getResponse();
		}
		
		if (isset($_SERVER['PHP_AUTH_PW']) && isset($_SERVER['PHP_AUTH_USER'])) {
			$login = $_SERVER['PHP_AUTH_USER'];
			$password = $_SERVER['PHP_AUTH_PW'];
		} else if (isset($this->request['login']) && $this->request['password']) {
			$login = $this->request['login'];
			$password = $this->request['password'];
		} else {
			$this->setError('There is no username info');
			return $this->getResponse();
		}
		
		$userData = $this->getMyVars();
		$this->respponse = array("logu" => $_SESSION['auth_id'], 'Cookie' => 'PHPSESSID='.  session_id(), 'user' => $userData);
		return $this->getResponse();
	}
	
	/**
	 * Example of an Endpoint
	 * @return array
	 */
	public function example() {
		$this->id = 1111;
		$this->name = 'John';
		$this->lastName = 'Doe';
		$this->login = 'Test';
		
		$this->respponse = $this->getMyVars();
		return $this->getResponse();
	}

	/**
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function get($id) {
		$logged = $this->haveToBeLogged();
		if (true !== $logged) {
			return $logged;
		}
		
		if (!$this->isMethodCorrect('GET')) {
			return $this->getResponse();
		}
		
		$this->setIdFromRequest($id);
		$this->respponse = $this->getMyVars();
		return $this->getResponse();
	}
	
	/**
	 *
	 * @return array
	 */
	public function logout() {
		$_SESSION['auth_id'] = null;
		$this->respponse = array("logout" => "true");
		return $this->getResponse();
	}

	private function setIdFromRequest($id) {
		if (is_array($id)) {
			$this->id = $id[0];
		} else {
			$this->id = $id;
		}
	}
}
