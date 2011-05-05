<?php
class AppController extends Controller
{
	var $components = array('Auth', 'Session', 'DebugKit.Toolbar');

	function beforeFilter()
	{
		$this->__setupAuth();
		$this->__setupEmail();
	}

	function __setupAuth()
	{
		$this->Auth->userScope = array('User.active' => 1);
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'welcome');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->autoRedirect = true;
		$this->Auth->authenticate = ClassRegistry::init('User');

		$this->Auth->loginError = __('Benutzername und/oder Passwort falsch.', true);
		$this->Auth->authError = __('Du hast nicht genügten Rechte um diese Seite zu sehen.', true);

		$this->Auth->allow('*');
	}

	function __setupEmail()
	{
		if(isset($this->Email))
		{
			$this->Email->from = 'TourDB <tourdb@localhost.ch>';
			$this->Email->sendAs = 'text';
			$this->Email->delivery = 'smtp';
			$this->Email->smtpOptions = array(
				'port' => 25,
				'timeout' => 30,
				'host' => 'localhost',
			);
		}
	}
}