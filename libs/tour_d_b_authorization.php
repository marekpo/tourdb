<?php
class TourDBAuthorization extends CakeSession
{
	function checkRules($controller, $action, $requestArguments = array(), $userId = null)
	{
		if(is_object($controller) && is_a($controller, 'Controller'))
		{
			$controllerName = $controller->name;
			$controllerClassName = get_class($controller);
			$controllerObject = $controller;
		}
		else
		{
			$controllerName = Inflector::camelize($controller);
			$controllerClassName = sprintf('%sController', $controllerName);
			$controllerObject = null;
		}

		$authRules = $this->getAuthRules($controllerClassName, $action, $requestArguments);

		$this->log(sprintf('%s::%s: %s', $controllerName, $action, var_export($authRules, true)));

		foreach($authRules as $authRule)
		{
			$ruleQualifier = explode('.', $authRule['ruleName']);
			$ruleArguments = $authRule['ruleArguments'];
			array_unshift($ruleArguments, $userId);

			$callback = array();

			switch($ruleQualifier[0])
			{
				case 'Model':
					$callback = array(ClassRegistry::init($ruleQualifier[1]), sprintf('%sRule', $ruleQualifier[2]));
					break;
				case 'Controller':
					if($controllerObject == null)
					{
						if(!class_exists($controllerClassName))
						{
							App::import('Controller', $controllerName);
						}

						$controllerObject = new $controllerClassName();
						$controllerObject->constructClasses();
					}

					$callback = array($controllerObject, sprintf('%sRule', $ruleQualifier[1]));
					break;
				default:
					$callback = array($this, sprintf('%sRule', $ruleQualifier[0]));
			}

			if(call_user_func_array($callback, $ruleArguments))
			{
				if(Configure::read() > 0)
				{
					$userName = $this->check('Auth.User.username') ? $this->read('Auth.User.username') : 'anonymous';
					CakeLog::write('authorization', sprintf('Access on action "%s::%s" granted to user "%s" by authorization rule "%s".',
						$controllerClassName, $action, $userName, $authRule['ruleName']
					));
				}

				return true;
			}
		}

		if(Configure::read() > 0)
		{
			$userName = $this->check('Auth.User.username') ? $this->read('Auth.User.username') : 'anonymous';
			CakeLog::write('authorization', sprintf('Access on action "%s::%s" denied for user "%s".',
				$controllerClassName, $action, $userName
			));
		}

		return false;
	}

	function getAuthRules($controllerClassName, $action, $requestArguments)
	{
		if(!class_exists($controllerClassName))
		{
			App::import('Controller', str_replace('Controller', '', $controllerClassName));
		}

		$reflectionMethod = new ReflectionMethod($controllerClassName, $action);
		$docComment = $reflectionMethod->getDocComment();
		$authRules = array();

		preg_match_all('/@auth:([a-z\.]+)\(([^\)]*)\)/i', $docComment, $ruleMatches);

		for($i = 0; $i < count($ruleMatches[0]); $i++)
		{
			$ruleName = $ruleMatches[1][$i];
			$rawRuleArguments = preg_split('/\s*,\s*/', $ruleMatches[2][$i]);
			$ruleArguments = array();

			foreach($rawRuleArguments as $rawRuleArgument)
			{
				if(empty($rawRuleArgument))
				{
					continue;
				}

				if(preg_match('/\#arg\-([a-zA-Z0-9]+)/', $rawRuleArgument, $argumentMatch))
				{
					if(!array_key_exists($argumentMatch[1], $requestArguments))
					{
						trigger_error(sprintf('Missing argument "%s" for action "%s::%s" while validating rule "%s".',
						$argumentMatch[1], $controllerClassName, $action, $ruleName
						), E_USER_ERROR);
					}

					$ruleArguments[] = $requestArguments[$argumentMatch[1]];
				}
				else
				{
					$ruleArguments[] = $rawRuleArgument;
				}
			}

			$authRules[] = array(
				'ruleName' => $ruleName,
				'ruleArguments' => $ruleArguments
			);
		}

		return $authRules;
	}

	function allowedRule($userId)
	{
		return true;
	}

	function requireRoleRule($userId, $requiredRole)
	{
		return in_array($requiredRole, $this->getRoles());
	}

	function getRoles()
	{
		return Set::extract('/Role/key', $this->read('Auth.Roles'));
	}

	function hasRole($requiredRoles = array())
	{
		if(!$this->check('Auth.User'))
		{
			return false;
		}

		if(!is_array($requiredRoles))
		{
			$requiredRoles = array($requiredRoles);
		}

		$roles = $this->read('Auth.Roles');

		return count(Set::extract(sprintf('/Role[key=/%s/]', implode('|', $requiredRoles)), $roles)) > 0;
	}
}