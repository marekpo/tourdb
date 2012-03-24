<?php
class AppController extends Controller
{
	var $components = array('Auth', 'Session', 'Cookie', 'Authorization', 'DebugKit.Toolbar');

	var $helpers = array('Authorization', 'Menu');

	function beforeFilter()
	{
		$this->__mergeDefaultOrderForPagination();

		$this->__setupAuth();

		$this->__loginByCookie();

		$this->__checkDataPrivacyStatementAccepted();
	}

	function isAuthorized()
	{
		return $this->Authorization->isAuthorized();
	}

	function _sendEmail($recipient, $subject, $template)
	{
		$this->Email->reset();

		$this->Email->from = 'TourDB <tourdb@tourdb.ch>';
		$this->Email->sendAs = 'text';
		$this->Email->delivery = 'smtp';
		$this->Email->lineLength = 998;
		$this->Email->smtpOptions = array(
			'port' => 25,
			'timeout' => 30,
			'host' => 'tourdb.ch',
		);

		$this->Email->to = $recipient;
		$this->Email->subject = $subject;
		$this->Email->template = $template;

		$this->Email->send();
	}

	function __setupAuth()
	{
		$this->Auth->userScope = array('User.active' => 1);
		$this->Auth->logoutRedirect = '/';
		$this->Auth->autoRedirect = false;
		$this->Auth->authenticate = ClassRegistry::init('User');
		$this->Auth->authorize = 'controller';

		$this->Auth->loginError = __('Benutzername und/oder Passwort falsch.', true);
		$this->Auth->authError = __('Du hast nicht genügten Rechte um diese Seite zu sehen.', true);

		$this->Auth->deny('*');
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

	function __checkDataPrivacyStatementAccepted()
	{
		if($this->Auth->user() && !$this->Auth->user('dataprivacystatementaccepted')
			&& ($this->name != 'users' && $this->action != 'acceptDataPrivacyStatement'))
		{
			$this->Session->write('acceptDataPrivacyStatement.redirect', $this->here);
			$this->redirect(array('controller' => 'users', 'action' => 'acceptDataPrivacyStatement'));
		}
	}

	function __mergeDefaultOrderForPagination()
	{
		if(isset($this->passedArgs['sort']) && isset($this->paginate['order']) && array_pop(array_keys($this->paginate['order'])) != $this->passedArgs['sort'])
		{
			$this->passedArgs['order'] = array_merge($this->paginate['order'], array($this->passedArgs['sort'] => $this->passedArgs['direction']));
			unset($this->passedArgs['sort']);
			unset($this->passedArgs['direction']);
		}
	}
}