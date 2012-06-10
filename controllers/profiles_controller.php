<?php
class ProfilesController extends AppController
{
	var $name = 'Profiles';

	var $helpers = array('Html', 'Form', 'Display', 'Widget');

	/**
	 * @auth:requireRole(user)
	 */
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

			if(!empty($this->data['Profile']['birthdate']))
			{
				$this->data['Profile']['birthdate'] = date('d.m.Y', strtotime($this->data['Profile']['birthdate']));
			}
		}

		$this->set(array(
			'countries' => $this->Profile->Country->find('list', array(
				'order' => array('name' => 'ASC')
			)),
			'climbingDifficulties' => $this->Profile->LeadClimbNiveau->getRockClimbingDifficulties(),
			'skiAndAlpineTourDifficulties' => $this->Profile->AlpineTourNiveau->getSkiAndAlpineTourDifficulties(),
			'sacSections' => $this->Profile->SacMainSection->find('list', array(
				'order' => array('SacMainSection.id' => 'ASC'),
				'contain' => array()
			))
		));
	}

	/**
	 * @auth:requireRole(tourleader)
	 * @auth:requireRole(safetycommittee)
	 */
	function view($userId)
	{
		$profile = $this->Profile->find('first', array(
			'conditions' => array('Profile.user_id' => $userId),
			'contain' => array(
				'User', 'Country', 'LeadClimbNiveau', 'SecondClimbNiveau',
				'AlpineTourNiveau', 'SkiTourNiveau', 'SacMainSection',
				'SacAdditionalSection1', 'SacAdditionalSection2', 'SacAdditionalSection3'
			)
		));

		$this->set(array(
			'profile' => $profile,
			'ownTours' => $this->Profile->User->Tour->find('all', array(
				'conditions' => array('Tour.tour_guide_id' => $userId),
				'contain' => array('TourStatus', 'TourType', 'Difficulty', 'ConditionalRequisite'),
				'order' => array('Tour.startdate' => 'desc')
			)),
			'tourParticipations' => $this->Profile->User->TourParticipation->find('all', array(
				'conditions' => array('TourParticipation.user_id' => $userId),
				'contain' => array('Tour', 'Tour.TourStatus', 'Tour.TourType', 'Tour.Difficulty', 'Tour.ConditionalRequisite'),
				'order' => array('Tour.startdate' => 'desc')
			))
		));
	}
}