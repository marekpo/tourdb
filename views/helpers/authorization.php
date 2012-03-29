<?php
if (!class_exists('TourDBAuthorization'))
{
	App::import('Lib', 'TourDBAuthorization');
}

class AuthorizationHelper extends TourDBAuthorization
{
	var $helpers = array('Html', 'Session');

	function link($title, $url = null, $options = array(), $confirmMessage = false)
	{
		$parsedRoute = Router::parse(Router::url($url !== null ? $url : $title));

		if(!$this->checkRules($parsedRoute['controller'], $parsedRoute['action'], Set::merge($parsedRoute['named'], $parsedRoute['pass']), $this->read('Auth.User.id')))
		{
			return false;
		}

		return $this->Html->link($title, $url, $options, $confirmMessage);
	}
}