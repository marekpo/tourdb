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

		if(!empty($this->data))
		{
			App::import('Lib', 'Sanitize');
			$this->data = $this->__sanitize($this->data);
		}
	}

	function beforeRender()
	{
		$this->__restoreOrderForPagination();
	}

	function isAuthorized()
	{
		return $this->Authorization->isAuthorized($this, $this->action, $this->passedArgs, $this->Auth->user('id'));
	}

	function _sendEmail($recipient, $subject, $template)
	{
		$this->Email->reset();

		$this->Email->from = Configure::read('Email.from');
		$this->Email->sendAs = 'text';
		$this->Email->delivery = Configure::read('Email.delivery');
		$this->Email->lineLength = 998;

		if(Configure::read('Email.delivery') === 'smtp')
		{
			$smtpOptions = array(
				'host' => Configure::read('Email.Smtp.host'),
				'port' => Configure::read('Email.Smtp.port'),
				'timeout' => Configure::read('Email.Smtp.timeout'),
			);

			if(Configure::read('Email.Smtp.username') != null && Configure::read('Email.Smtp.password') != null)
			{
				$smtpOptions['username'] = Configure::read('Email.Smtp.username');
				$smtpOptions['password'] = Configure::read('Email.Smtp.password');
			}

			$this->Email->smtpOptions = $smtpOptions;
		}

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
		$this->Auth->authError = __('Du hast nicht genügend Rechte um diese Seite zu sehen.', true);

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

	function __restoreOrderForPagination()
	{
		if(isset($this->passedArgs['order']))
		{
			end($this->passedArgs['order']);
			$this->passedArgs['sort'] = key($this->passedArgs['order']);
			$this->passedArgs['direction'] = current($this->passedArgs['order']);

			unset($this->passedArgs['order']);
		}
	}

	function __sanitize($data)
	{
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				$data[$key] = $this->__sanitize($value);
			}

			return $data;
		}

		return strip_tags($data);
	}
}