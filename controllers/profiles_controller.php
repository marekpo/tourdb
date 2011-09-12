<?php
class ProfilesController extends AppController
{
	var $name = 'Profiles';

	var $helpers = array('Html', 'Form');

	function edit()
	{
		if(!empty($this->data))
		{
			$profileId = $this->Profile->field('id', array('user_id' => $this->Auth->user('id')));

			if(!empty($profileId))
			{
				$this->data['Profile']['id'] = $profileId;
			}

			$this->data['Profile']['user_id'] = $this->Auth->user('id');

			if($this->Profile->save($this->data))
			{
				$this->Session->setFlash(__('Dein Profil wurde gespeichert.', true));
			}

			$this->redirect(array('action' => 'edit'));
		}
		else
		{
			$this->data = $this->Profile->find('first', array(
				'conditions' => array('user_id' => $this->Auth->user('id')),
				'contain' => array()
			));

			if(is_array($this->data))
			{
				unset($this->data['Profile']['id']);
			}
		}
	}
}