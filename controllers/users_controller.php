<?php
class UsersController extends AppController
{
	var $name = 'Users';

	var $components = array('Session', 'Email');

	var $scaffold;

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
				
				$this->redirect(array('action' => 'index'));
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
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->set(compact('username'));
	}
}