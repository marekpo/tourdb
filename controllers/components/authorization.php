<?php
class AuthorizationComponent extends Object
{
	var $components = array('Auth', 'Session');

	/**
	 * @var Controller
	 */
	var $controller = null;

	function initialize(&$controller, $settings = array())
	{
		$this->controller = $controller;
	}

	function init()
	{
		App::import('Model', 'User');
		$User = new User();

		$privileges = $User->getPrivileges($this->Auth->user('id'));
		$this->Session->write('Privileges', $privileges);
	}

	function check($controller, $action)
	{
		$privileges = null;
		$controller = Inflector::underscore($controller);

		$privileges = $this->Session->read('Privileges');

		foreach($privileges as $privilege)
		{
			list($privilegeController, $privilegeAction) = preg_split('/:/', $privilege['Privilege']['key']);

			if($privilegeController == $controller && ($privilegeAction == $action || $privilegeAction == '*'))
			{
				return true;
			}
		}

		CakeLog::write('authorization', sprintf('Access denied for user %s (%s) to action %s:%s',
			$this->controller->Auth->user('username'), $this->controller->Auth->user('id'),
			$controller, $action
		));

		return false;
	}
}