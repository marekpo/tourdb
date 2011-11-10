<?php
class TourParticipationsController extends AppController
{
	var $name = 'TourParticipations';

	var $helpers = array('Widget', 'Display');

	var $components = array('RequestHandler', 'Email');

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('changeStatus');

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
// 			$this->TourParticipation->save($this->data);

			$user = $this->TourParticipation->find('first', array(
				'fields' => array('User.*'),
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array('User')
			));

			$this->set(array(
				'user' => $user,
				'message' => $this->data['TourParticipation']['message']
			));

			$this->_sendEmail($user['User']['email'], __('Statusänderung Anmeldung', true), 'tours/change_tour_participation_status_participant');
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
				'conditions' => array('NOT' => array('TourParticipationStatus.id' => $currentTourParticipationStatus['TourParticipationStatus']['id'])),
				'order' => array('TourParticipationStatus.rank' => 'ASC')
			))
		));
	}
}