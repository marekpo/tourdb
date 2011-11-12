<?php
class TourParticipationsController extends AppController
{
	var $name = 'TourParticipations';

	var $helpers = array('Widget', 'Display');

	var $components = array('RequestHandler', 'Email');

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->paginate = array(
			'limit' => 20,
			'order' => array('Tour.startdate' => 'ASC')
		);
	}

	function listMine()
	{
		$tourParticipationTourIds = $this->TourParticipation->find('all', array(
			'fields' => array('TourParticipation.tour_id'),
			'conditions' => array('TourParticipation.user_id' => $this->Auth->user('id')),
			'contain' => array()
		));

		$tourIds = $this->TourParticipation->Tour->searchTours($this->params['url'], array(
			array('Tour.id' => Set::extract('/TourParticipation/tour_id', $tourParticipationTourIds))
		));

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('TourParticipation.tour_id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array(
				'Tour', 'Tour.TourGuide', 'Tour.TourGuide.Profile', 'Tour.TourType',
				'Tour.ConditionalRequisite', 'Tour.Difficulty', 'TourParticipationStatus'
			)
		));

		$this->data['Tour'] = $this->params['url'];
		unset($this->data['Tour']['url']);

		$this->set(array(
			'tours' => $this->paginate('TourParticipation'),
			'tourParticipationCount' => count($tourParticipationTourIds),
			'filtersCollapsed' => empty($this->data['Tour']['startdate'])
				&& empty($this->data['Tour']['enddate'])
				&& empty($this->data['Tour']['TourGuide'])
				&& empty($this->data['Tour']['TourType'])
				&& empty($this->data['Tour']['ConditionalRequisite'])
				&& empty($this->data['Tour']['Difficulty'])
		));

		$this->set($this->TourParticipation->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_GUIDE, Tour::WIDGET_TOUR_TYPE,
			Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	function changeStatus($id)
	{
		if(!empty($this->data))
		{
			$this->log($this->TourParticipation->save($this->data));

			$tourParticipationInfo = $this->TourParticipation->find('first', array(
				'fields' => array('TourParticipation.tour_id', 'User.*', 'Tour.*', 'TourParticipationStatus.*'),
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array('User', 'Tour', 'TourParticipationStatus')
			));

			$tourGuide = $this->TourParticipation->Tour->find('first', array(
				'conditions' => array('Tour.id' => $tourParticipationInfo['TourParticipation']['tour_id']),
				'contain' => array('TourGuide', 'TourGuide.Profile')
			));

			$this->set(array(
				'user' => array('User' => $tourParticipationInfo['User']),
				'tour' => array('Tour' => $tourParticipationInfo['Tour']),
				'tourParticipationStatus' => array('TourParticipationStatus' => $tourParticipationInfo['TourParticipationStatus']),
				'tourGuide' => $tourGuide,
				'message' => $this->data['TourParticipation']['message']
			));

			$this->_sendEmail($tourParticipationInfo['User']['email'], __('Statusänderung Anmeldung', true), 'tours/change_tour_participation_status_participant');

			$this->redirect(array('controller' => 'tours', 'action' => 'view', $tourParticipationInfo['Tour']['id']));
		}
		else
		{
			$this->data = $this->TourParticipation->find('first', array(
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array()
			));
		}

		$currentTourParticipationStatus = $this->TourParticipation->find('first', array(
			'fields' => array('TourParticipationStatus.*'),
			'conditions' => array('TourParticipation.id' => $id),
			'contain' => array('TourParticipationStatus')
		));

		$this->set(array(
			'tourParticipationStatuses' => $this->TourParticipation->TourParticipationStatus->find('list', array(
				'conditions' => array(
					'NOT' => array(
						'OR' => array(
							'TourParticipationStatus.id' => $currentTourParticipationStatus['TourParticipationStatus']['id'],
							'TourParticipationStatus.key' => TourParticipationStatus::REGISTERED
						)
					)
				),
				'order' => array('TourParticipationStatus.rank' => 'ASC')
			))
		));
	}
}