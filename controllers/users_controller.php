<?php
class UsersController extends AppController
{
	var $name = 'Users';

	var $components = array('Session', 'Email', 'Cookie');

	var $scaffold;

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(array('createAccount', 'activateAccount', 'login'));
	}

	function createAccount()
	{
		if(!empty($this->data))
		{
			$accountCreated = $this->User->createAccount($this->data['User']['username'], $this->data['User']['email'], $password);

			if($accountCreated)
			{
				$url = Router::url(array('action' => 'activateAccount', $this->data['User']['username']), true);

				$this->set(array(
					'username' => $this->data['User']['username'],
					'url' => $url,
					'password' => $password
				));

				$this->Email->to = $this->data['User']['email'];
				$this->Email->subject = __('Dein Benutzerkonto bei TourDB', true);
				$this->Email->lineLength = 998;
				$this->Email->template = 'account_created';
				$this->Email->send();

				$this->redirect('/');
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
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_login', date('Y-m-d H:i:s'));
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

			$this->redirect($this->Auth->redirect());
		}
	}

	function logout()
	{
		$this->Session->delete('Privileges');
		$this->Cookie->delete('User.Auth');
		$this->redirect($this->Auth->logout());
	}
}