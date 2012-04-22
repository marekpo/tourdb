<?php
/**
 * This class provides some basic functionality for the authorization system.
 * It inherits CakeSession so that it can easily access session values.
 * 
 * @author Michael
 */
class TourDBAuthorization extends CakeSession
{
	/**
	 * This method checks the authorization requirements for the denoted
	 * controller action and request arguments against the currently logged in
	 * user account.
	 * 
	 * @param Controller|string	$controller
	 * 			Either a Controller object or the name of a controller
	 * 			(underscored).
	 * @param string $action
	 * 			The name of a controller action.
	 * @param array $requestArguments
	 * 			All request arguments (passed and named). May be empty, defaults
	 * 			to an empty array.
	 * @param string $userId
	 * 			The id of the currently logged in user account. May be null,
	 * 			defaults to null.
	 * 
	 * @return boolean
	 * 			Returns true, if the checks passed and the currently logged in
	 * 			user account has access to the denoted controller action, false
	 * 			otherwise.
	 */
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

	/**
	 * This method parses the authorization rules from the denoted controller
	 * action and returns the result.
	 * 
	 * @param string $controllerClassName
	 * 			The class name of the respective controller.
	 * @param string $action
	 * 			The name of the respective controller action.
	 * @param array $requestArguments
	 * 			The request arguments (named and passed).
	 * @return array
	 * 			Returns a multidimensional array containing information about
	 * 			all the autorization rules that are specified for the denoted
	 * 			controller action. The array has the following format:
	 * 
	 * 			array(
	 * 				0 => array(
	 * 					'rulename' => '<fully qualified rulename>',
	 * 					'arguments' => array('<ruleargument 1>', '<ruleargument 2>')
	 * 				),
	 * 				1 => array(
	 * 					...
	 * 				),
	 * 				...
	 * 			)
	 */
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

	/**
	 * This authorization rule handler method always returns true.
	 * 
	 * @param string $userId
	 * 			The id of the currently logged in user account.
	 * @return boolean
	 * 			Returns true.
	 */
	function allowedRule($userId)
	{
		return true;
	}

	/**
	 * This authorization rule handler method checks whether the currenlty
	 * logged in user account is associated with some required role.
	 * 
	 * @param string $userId
	 * 			The id of the currently logged in user account.
	 * @param string $requiredRole
	 * 			The key of the required role.
	 * @return boolean
	 * 			Returns true, if the currently logged in user account is
	 * 			associated with the denoted role, false otherwise.
	 */
	function requireRoleRule($userId, $requiredRole)
	{
		return in_array($requiredRole, $this->getRoleKeys());
	}

	function getRoleKeys()
	{
		return Set::extract('/Role/key', $this->read('Auth.Roles'));
	}
}