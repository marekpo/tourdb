<?php
if (!class_exists('TourDBAuthorization'))
{
	App::import('Lib', 'TourDBAuthorization');
}

class AuthorizationComponent extends TourDBAuthorization
{
	/**
	 * Holds a reference to the controller this component is associated with.
	 * 
	 * @var Controller
	 */
	var $controller = null;

	var $components = array('Auth');

	function initialize(&$controller, $settings = array())
	{
		$this->controller = $controller;
	}

	function init()
	{
		App::import('Model', 'User');
		$User = new User();

		$this->write('Auth._SessionId', String::uuid());

		$roles = $User->getRoles($this->Auth->user('id'));
		$this->write('Auth.Roles', $roles);
	}

	function endUserSession()
	{
		$this->delete('Auth._SessionId');
		$this->delete('Auth.Roles');
	}

	function isAuthorized($controller, $action, $requestArguments = array(), $userId = null)
	{
		return $this->checkRules($controller, $action, $requestArguments, $userId);
	}
}