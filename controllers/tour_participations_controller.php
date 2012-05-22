<?php
class TourParticipationsController extends AppController
{
	var $name = 'TourParticipations';

	var $helpers = array('Widget', 'Display');

	var $components = array('RequestHandler', 'Email');

	var $paginate = array(
		'limit' => 20,
		'order' => array('Tour.startdate' => 'ASC')
	);

	/**
	 * @auth:requireRole(user)
	 */
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
			'conditions' => array(
				'TourParticipation.user_id' => $this->Auth->user('id'),
				'TourParticipation.tour_id' => Set::extract('/Tour/id', $tourIds)
			),
			'contain' => array(
				'Tour', 'Tour.TourGroup', 'Tour.TourGuide', 'Tour.TourGuide.Profile', 'Tour.TourType',
				'Tour.ConditionalRequisite', 'Tour.Difficulty', 'TourParticipationStatus'
			)
		));

		$this->data['Tour'] = $this->params['url'];
		unset($this->data['Tour']['url']);

		$this->set(array(
			'tours' => $this->paginate('TourParticipation'),
			'tourParticipationCount' => count($tourParticipationTourIds),
			'filtersCollapsed' => empty($this->data['Tour']['TourGroup'])
				&& empty($this->data['Tour']['startdate'])
				&& empty($this->data['Tour']['enddate'])
				&& empty($this->data['Tour']['TourGuide'])
				&& empty($this->data['Tour']['TourType'])
				&& empty($this->data['Tour']['ConditionalRequisite'])
				&& empty($this->data['Tour']['Difficulty'])
		));

		$this->set($this->TourParticipation->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_GROUP, Tour::WIDGET_TOUR_GUIDE, Tour::WIDGET_TOUR_TYPE,
			Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	/**
	 * @auth:Model.TourParticipation.isTourGuideOfRespectiveTour(#arg-0)
	 */
	function changeStatus($id)
	{
		if(!empty($this->data))
		{
			$this->TourParticipation->save($this->data);

			$tourParticipationInfo = $this->TourParticipation->find('first', array(
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array('User', 'User.Profile', 'Tour', 'Tour.TourGroup', 'TourParticipationStatus')
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

	/**
	 * @auth:Model.TourParticipation.isParticipant(#arg-0)
	 */
	function cancelTourParticipation($id)
	{
		if(!empty($this->data))
		{
			$this->data['TourParticipation']['tour_participation_status_id'] = $this->TourParticipation->TourParticipationStatus->field('id', array('TourParticipationStatus.key' => TourParticipationStatus::CANCELED));

			$this->TourParticipation->save($this->data);

			$tourParticipationInfo = $this->TourParticipation->find('first', array(
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array('User', 'User.Profile', 'Tour', 'Tour.TourGroup', 'Tour.TourGuide', 'Tour.TourGuide.Profile')
			));

			$this->set(array(
				'tourParticipationInfo' => $tourParticipationInfo,
				'message' => $this->data['TourParticipation']['message']
			));

			$this->_sendEmail($tourParticipationInfo['Tour']['TourGuide']['email'], __('Anmeldung storniert', true), 'tours/cancel_tour_participation_tourguide');

			$this->Session->setFlash(__('Der Tourenleiter wurde über deine Absage informiert.', true));
			$this->redirect(array('controller' => 'tours', 'action' => 'view', $tourParticipationInfo['Tour']['id']));
		}
		else
		{
			$this->data = $this->TourParticipation->find('first', array(
				'fields' => array('TourParticipation.id'),
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array()
			));
		}

		$this->set(array(
			'tour' => $this->TourParticipation->find('first', array(
				'fields' => array('Tour.id', 'Tour.title'),
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array('Tour')
			))
		));
	}
}