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

		preg_match_all('/@([a-z\.]+)\(([^\)]+)\)/i', $comment, $ruleMatches);

		$authorized = false;

		for($i = 0; $i < count($ruleMatches[0]); $i++)
		{
			$ruleQualifier = explode('.', $ruleMatches[1][$i]);
			$rawArguments = preg_split('/\s*,\s*/', $ruleMatches[2][$i]);
			$arguments = array($this->Auth->user('id') ? $this->Auth->user('id') : null);

			foreach($rawArguments as $rawArgument)
			{
				if(preg_match('/\#arg\-([a-zA-Z0-9]+)/', $rawArgument, $argumentMatch))
				{
					if(!array_key_exists($argumentMatch[1], $this->controller->passedArgs))
					{
						trigger_error(sprintf('Missing argument "%s" for action "%s::%s" while validating rule "%s".',
							$argumentMatch[1], $this->controller->name, $this->controller->action, $ruleMatches[1][$i]
						), E_USER_ERROR);
					}

					$arguments[] = $this->controller->passedArgs[$argumentMatch[1]];
				}
				else
				{
					$arguments[] = eval(sprintf('return %s;', $rawArgument));
				}
			}

			$callback = array();

			switch($ruleQualifier[0])
			{
				case 'Model':
					$callback = array(ClassRegistry::init($ruleQualifier[1]), sprintf('%sRule', $ruleQualifier[2]));
					break;
				case 'Controller':
					$callback = array($this->controller, sprintf('%sRule', $ruleQualifier[1]));
					break;
				default:
					$callback = array($this, sprintf('%sRule', $ruleQualifier[0]));
			}

			if(call_user_func_array($callback, $arguments))
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

	function noAccessRule($userId)
	{
		return false;
	}

	function requireRoleRule($userId, $requiredRole)
	{
		return in_array($requiredRole, $this->getRoles());
	}
}