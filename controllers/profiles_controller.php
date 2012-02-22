<?php
class ProfilesController extends AppController
{
	var $name = 'Profiles';

	var $helpers = array('Html', 'Form', 'Display', 'Widget');

	function edit()
	{
		if(!empty($this->data))
		{
			$this->data['Profile']['user_id'] = $this->Auth->user('id');
			$profileId = $this->Profile->field('id', array('user_id' => $this->Auth->user('id')));

			if($profileId)
			{
				$this->data['Profile']['id'] = $profileId;
			}

			if($this->Profile->save($this->data))
			{
				$this->Session->setFlash(__('Dein Profil wurde gespeichert.', true));
				$this->redirect(array('action' => 'edit'));
			}

			$this->log(var_export($this->Profile->validationErrors, true));

			unset($this->data['Profile']['id']);

			$this->Session->setFlash(__('Fehler beim Speichern deines Profils.', true));
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

			$this->data['Profile']['birthdate'] = date('d.m.Y', strtotime($this->data['Profile']['birthdate']));
		}

		$this->set(array(
			'countries' => $this->Profile->Country->find('list', array(
				'order' => array('name' => 'ASC')
			)),
			'climbingDifficulties' => $this->Profile->LeadClimbNiveau->getRockClimbingDifficulties(),
			'skiAndAlpineTourDifficulties' => $this->Profile->AlpineTourNiveau->getSkiAndAlpineTourDifficulties()
		));
	}
}