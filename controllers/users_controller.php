<?php
App::import('Lib', 'SecurityTools');

class UsersController extends AppController
{
	var $name = 'Users';

	var $components = array('Session', 'Email', 'Cookie');

	var $helpers = array('Widget', 'Display');

	var $scaffold;

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(array('createAccount', 'activateAccount', 'login', 'logout', 'requestNewPassword'));

		$this->paginate = array(
			'limit' => 25,
			'order' => array('User.username' => 'ASC')
		);
	}

	function createAccount()
	{
		if(!empty($this->data))
		{
			$accountCreated = $this->User->createAccount(
				$this->data['User']['username'],
				$this->data['User']['email'],
				$password,
				$this->data['User']['dataprivacystatementaccpted']
			);

			if($accountCreated)
			{
				$url = Router::url(array('action' => 'activateAccount', $this->data['User']['username']), true);

				$this->set(array(
					'username' => $this->data['User']['username'],
					'url' => $url,
					'password' => $password
				));

				$this->_sendEmail($this->data['User']['email'], __('Dein Benutzerkonto bei Tourenangebot', true), 'account_created');

				$this->redirect(array('action' => 'activateAccount', $this->data['User']['username']));
			}
		}
	}

	function activateAccount($username)
	{
		$id = $this->User->field('id', array('User.username' => $username));

		if($this->User->isActive($id))
		{
			$this->Session->setFlash(__('Dein Benutzerkonto ist bereits aktiviert. Du kannst dich mit deinem Benutzernamen und deinem Passwort einloggen.', true));
			$this->redirect(array('action' => 'login'));
		}

		if(!empty($this->data))
		{
			$accountActivated = $this->User->activateAccount($id, $this->data['User']['tempPassword'], $this->data['User']['newPassword'], $this->data['User']['newPasswordRepeat']);

			if($accountActivated)
			{
				$this->Auth->login(array(
					'username' => $username,
					'password' => $this->User->field('password')
				));
				$this->User->updateLastLoginTime($id);
				$this->Authorization->init();

				$this->Session->setFlash(__('Dein Benutzerkonto ist jetzt aktiviert und du wurdest automatisch eingeloggt.', true));

				$this->redirect('/');
			}
		}

		$this->set(compact('username'));
	}

	function login()
	{
		if($this->Auth->user())
		{
			if(!empty($this->data))
			{
				$this->User->updateLastLoginTime($this->Auth->user('id'));
			}

			if(!empty($this->data['User']['cookie']))
			{
				$loginCookie = array(
					'username' => $this->data['User']['username'],
					'password' => $this->data['User']['password']
				);

				$this->Cookie->write('User.Auth', $loginCookie, true, '+1 month');
				unset($this->data['User']['cookie']);
			}

			$this->Authorization->init();
			$this->redirect($this->Auth->redirect());
		}
	}

	function logout()
	{
		$this->Authorization->endUserSession();
		$this->Cookie->delete('User.Auth');
		$this->redirect($this->Auth->logout());
	}

	function requestNewPassword($id = null, $newPasswordToken = null)
	{
		if(!empty($this->data))
		{
			$this->User->recursive = -1;
			$user = $this->User->findByEmail($this->data['User']['email'], array('id', 'username'));

			if(empty($user))
			{
				$this->Session->setFlash(__('Zur eingegebenen E-Mail-Adresse wurde kein Benutzer gefunden.', true));
				return;
			}

			$generatedNewPasswordToken = String::uuid();

			$this->User->id = $user['User']['id'];
			$this->User->saveField('new_password_token', $generatedNewPasswordToken);

			$this->set(array(
				'requestUrl' => Router::url(array(
					'controller' => 'users', 'action' => 'requestNewPassword',
					$user['User']['id'], $generatedNewPasswordToken
				), true),
				'username' => $user['User']['username']
			));

			$this->_sendEmail($this->data['User']['email'], __('Neues Passwort anfordern für Tourenangebot', true), 'request_new_password');

			$this->Session->setFlash(__('Dir wurde ein Link zum Generieren eines neuen Passworts per E-Mail zugeschickt.', true));
			$this->redirect(array('action' => 'login'));
		}
		elseif($id != null && $newPasswordToken != null)
		{
			$user = $this->User->find('first', array(
				'conditions' => array('id' => $id, 'new_password_token' => $newPasswordToken),
				'contain' => array()
			));

			if(empty($user))
			{
				$this->Session->setFlash(__('Fehler beim Generieren des neuen Passworts.', true));
				return;
			}

			$generatedPassword = $this->User->generateNewPassword($id);

			$this->set(array(
				'newPassword' => $generatedPassword,
				'username' => $user['User']['username']
			));

			$this->_sendEmail($user['User']['email'], __('Dein neues Passwort für Tourenangebot', true), 'new_password');

			$this->Session->setFlash(__('Dein neues Passwort wurde dir per E-Mail zugeschickt.', true));
			$this->redirect(array('action' => 'login'));
		}
	}

	function index()
	{
		$this->set(array(
			'users' => $this->paginate('User')
		));
	}

	function edit($id)
	{
		if(!empty($this->data))
		{
			if($this->User->save($this->data))
			{
				$this->Session->setFlash(__('Gespeichert', true));
				$this->redirect(array('action' => 'index'));			
			}
		}
		else
		{
			$this->data = $this->User->find('first', array(
				'conditions' => array('User.id' => $id)
			));
		}

		$this->set(array(
			'roles' => $this->User->Role->find('list')
		));
	}

	function editAccount()
	{
		if(!empty($this->data))
		{
			$this->data['User']['id'] = $this->Auth->user('id');
			$this->User->create($this->data);
			if($this->User->validates())
			{
				if(!empty($this->data['User']['changedPassword']))
				{
					$this->User->id = $this->Auth->user('id');
					$salt = SecurityTools::generateRandomString();
					$this->data['User']['salt'] = $salt;
					$this->data['User']['password'] = $this->User->hashPassword($salt, $this->data['User']['changedPassword']);
				}

				unset($this->data['User']['changedPassword'], $this->data['User']['changedPasswordRepeat']);

				$this->User->save($this->data, true, array('email', 'salt', 'password'));

				$this->Session->setFlash(__('Benutzerkonto wurde gespeichert.', true));
				$this->redirect(array('action' => 'editAccount'));
			}
			else
			{
				unset($this->data['User']['id']);
				unset($this->data['User']['changedPassword']);
				unset($this->data['User']['changedPasswordRepeat']);
			}
		}
		else
		{
			$this->data = $this->User->find('first', array(
				'fields' => array('email'),
				'conditions' => array('id' => $this->Auth->user('id')),
				'contain' => array()
			));
		}
	}
}