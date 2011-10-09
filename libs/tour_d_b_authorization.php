<?php
class TourDBAuthorization extends CakeSession
{
	var $components = array('Auth');

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