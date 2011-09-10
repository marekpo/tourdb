<?php
class AppController extends Controller
{
	var $components = array('Auth', 'Session', 'Cookie', 'Authorization', 'DebugKit.Toolbar');

	var $helpers = array('Authorization', 'Menu');

	function beforeFilter()
	{
		$this->__setupAuth();
		$this->__setupEmail();

		$this->__loginByCookie();
	}

	function isAuthorized()
	{
		return $this->Authorization->hasPrivilege($this->name, $this->action);
	}

	function _sendEmail($recipient, $subject, $template)
	{
		$this->Email->to = $recipient;
		$this->Email->subject = $subject;
		$this->Email->template = $template;

		$this->Email->send();
	}

	function __setupAuth()
	{
		$this->Auth->userScope = array('User.active' => 1);
		$this->Auth->loginRedirect = '/';
		$this->Auth->logoutRedirect = '/';
		$this->Auth->autoRedirect = false;
		$this->Auth->authenticate = ClassRegistry::init('User');
		$this->Auth->authorize = 'controller';

		$this->Auth->loginError = __('Benutzername und/oder Passwort falsch.', true);
		$this->Auth->authError = __('Du hast nicht genügten Rechte um diese Seite zu sehen.', true);

		$this->Auth->deny('*');
	}

	function __setupEmail()
	{
		if(isset($this->Email))
		{
			$this->Email->from = 'TourDB <tourdb@localhost.ch>';
			$this->Email->sendAs = 'text';
			$this->Email->delivery = 'smtp';
			$this->Email->lineLength = 998;
			$this->Email->smtpOptions = array(
				'port' => 25,
				'timeout' => 30,
				'host' => 'localhost',
			);
		}
	}

	function __loginByCookie()
	{
		$loginCookie = $this->Cookie->read('User.Auth');

		if(!$this->Auth->user() && !empty($loginCookie))
		{
			if($this->Auth->login($loginCookie))
			{
				$this->loadModel('User');
				$this->User->updateLastLoginTime($this->Auth->user('id'));
				$this->Authorization->init();
				$this->Session->delete('Message.auth');
			}
		}
	}
}