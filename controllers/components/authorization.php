<?php
if (!class_exists('TourDBAuthorization'))
{
	App::import('Lib', 'TourDBAuthorization');
}

class AuthorizationComponent extends TourDBAuthorization
{
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

		$this->write('Auth._SessionId', String::uuid());

		$roles = $User->getRoles($this->Auth->user('id'));
		$this->write('Auth.Roles', $roles);

		$privileges = $User->getPrivileges($this->Auth->user('id'));
		$this->write('Auth.Privileges', $privileges);
	}

	function endUserSession()
	{
		$this->delete('Auth._SessionId');
		$this->delete('Auth.Roles');
		$this->delete('Auth.Privileges');
	}

	function isAuthorized()
	{
		$method = new ReflectionMethod($this->controller, $this->controller->action);

		$comment = $method->getDocComment();

		preg_match_all('/@([a-z\.]+)\(([^\)]+)\)/i', $comment, $matches);

		$authorized = false;

		for($i = 0; $i < count($matches[0]); $i++)
		{
			$ruleQualifier = explode('.', $matches[1][$i]);
			$arguments = explode(',', $matches[2][$i]);

			switch($ruleQualifier[0])
			{
				case 'Model':
					break;
				case 'Controller':
					break;
				default:
					$ruleName = sprintf('%sRule', $matches[1][$i]);
					$authorized = $authorized || $this->{$ruleName}($matches[2][$i]);
			}

			if($authorized)
			{
				return true;
			}
		}

		return false;

		return $this->hasPrivilege($this->controller->name, $this->controller->action);
	}

	function hasPrivilege($controller, $action)
	{
		$privileges = null;
		$controller = Inflector::underscore($controller);

		$privileges = $this->read('Auth.Privileges');

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

	function requireRoleRule($requiredRole)
	{
		if(!preg_match('/[\'\"]([a-z]+)[\'\"]/i', $requiredRole, $matches))
		{
			trigger_error('Invalid parameter for requireRoleRule', E_USER_ERROR);
		}

		return in_array($matches[1], $this->getRoles());
	}
}