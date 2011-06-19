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

	function startup(&$controller)
	{
		
	}

	function check($controller, $action)
	{
		$privileges = null;

		if(!$this->Session->check('Privileges'))
		{
			App::import('Model', 'User');
			$User = new User();

			$privileges = $User->getPrivileges($this->Auth->user('id'));
			$this->Session->write('Privileges', $privileges);
		}
		else
		{
			$privileges = $this->Session->read('Privileges');
		}

		foreach($privileges as $privilege)
		{
			list($privilegeController, $privilegeAction) = preg_split('/:/', $privilege['Privilege']['key']);

			if($privilegeController == $controller && ($privilegeAction == $action || $privilegeAction == '*'))
			{
				return true;
			}
		}

		return true;
	}
}