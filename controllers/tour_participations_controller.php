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
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function add($tourId)
	{
		if(!empty($this->data))
		{
			$tourParticipation = $this->TourParticipation->createTourParticipation(
				$tourId, null, $this->Auth->user('id'), $this->data['TourParticipation']
			);

			if($tourParticipation)
			{
				$this->Session->setFlash(sprintf(__('Die Anmeldung von %s %s wurde gespeichert.', true), $this->data['TourParticipation']['firstname'], $this->data['TourParticipation']['lastname']));

				if(!empty($this->data['TourParticipation']['email']))
				{
					$tourParticipation = $this->TourParticipation->find('first', array(
						'conditions' => array('TourParticipation.id' => $this->Tour->TourParticipation->id),
						'contain' => array('Tour', 'Tour.TourGroup', 'Tour.TourType', 'Tour.TourGuide', 'Tour.TourGuide.Profile')
					));

					$this->set(compact('tourParticipation'));

					$this->_sendEmail(
						$this->data['TourParticipation']['email'],
						sprintf(__('Deine Touranmeldung zu "%s"', true), $tourParticipation['Tour']['title']),
						'tours/add_participation_participant'
					);
				}

				$this->redirect(array('controller' => 'tours', 'action' => 'view', $tourId));
			}

			$this->Session->setFlash(__('Beim Speichern der Anmeldung ist ein Fehler aufgetreten.', true));
		}

		$this->set(array(
			'tour' => $this->TourParticipation->Tour->find('first', array(
				'conditions' => array('Tour.id' => $tourId),
				'contain' => array()
			)),
			'countries' => $this->TourParticipation->Country->find('list', array(
				'order' => array('Country.name' => 'ASC')
			)),
			'sacSections' => $this->TourParticipation->SacMainSection->find('list', array(
				'order' => array('SacMainSection.id' => 'ASC'),
				'contain' => array()
			)),
			'climbingDifficulties' => $this->TourParticipation->Tour->Difficulty->getRockClimbingDifficulties(),
			'skiAndAlpineTourDifficulties' => $this->TourParticipation->Tour->Difficulty->getSkiAndAlpineTourDifficulties()
		));
	}

	/**
	 * @auth:requireRole(safetycommittee)
	 * @auth:Model.TourParticipation.isTourGuideOfRespectiveTour(#arg-0)
	 */
	function view($id = null)
	{
		if($id == null)
		{
			$this->cakeError('error404');
		}

		$tourParticipation = $this->TourParticipation->find('first', array(
			'conditions' => array('TourParticipation.id' => $id),
			'contain' => array(
				'Tour', 'Country', 'SacMainSection', 'SacAdditionalSection1',
				'SacAdditionalSection2', 'SacAdditionalSection3',
				'LeadClimbNiveau', 'SecondClimbNiveau', 'AlpineTourNiveau', 'SkiTourNiveau'
			)
		));

		$this->set(array(
			'tourParticipation' => $tourParticipation
		));
	}

	/**
	 * @auth:requireRole(user)
	 */
	function listMine()
	{
		if(!isset($this->params['url']['range']))
		{
			$this->params['url']['range'] = Tour::FILTER_RANGE_CURRENT;
		}

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
				&& $this->data['Tour']['range'] == Tour::FILTER_RANGE_CURRENT
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
			$tourId = $this->TourParticipation->field('tour_id', array('TourParticipation.id' => $id));

			$redirect = array('controller' => 'tours', 'action' => 'view', $tourId);

			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}

			if($this->TourParticipation->save($this->data))
			{
				$this->Session->setFlash(__('Der Status der Touranmeldung wurde geändert.', true));

				$tourParticipation = $this->TourParticipation->find('first', array(
					'conditions' => array('TourParticipation.id' => $id),
					'contain' => array('TourParticipationStatus', 'Tour', 'Tour.TourGroup', 'Tour.TourGuide', 'Tour.TourGuide.Profile')
				));

				if(!empty($tourParticipation['TourParticipation']['email']))
				{
					$this->set(array(
						'tourParticipation' => $tourParticipation,
						'message' => $this->data['TourParticipation']['message']
					));

					$this->_sendEmail($tourParticipation['TourParticipation']['email'], __('Statusänderung Anmeldung', true), 'tours/change_tour_participation_status_participant');
				}
			}
			else
			{
				$this->Session->setFlash(__('Beim ändern des Anmeldungsstatus ist ein Fehler aufgetreten.', true));
			}

			$this->redirect($redirect);
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
			$tourParticipation = $this->TourParticipation->find('first', array(
				'conditions' => array('TourParticipation.id' => $id),
				'contain' => array('Tour', 'Tour.TourGroup', 'Tour.TourGuide', 'Tour.TourGuide.Profile')
			));

			$redirect = array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id']);

			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}

			$this->data['TourParticipation']['tour_participation_status_id'] = $this->TourParticipation->TourParticipationStatus->field('id', array('TourParticipationStatus.key' => TourParticipationStatus::CANCELED));

			$this->TourParticipation->save($this->data);

			$this->set(array(
				'tourParticipation' => $tourParticipation,
				'message' => $this->data['TourParticipation']['message']
			));

			$this->_sendEmail($tourParticipation['Tour']['TourGuide']['email'], __('Anmeldung storniert', true), 'tours/cancel_tour_participation_tourguide');

			$this->Session->setFlash(__('TourenleiterIn wurde über deine Absage informiert.', true));
			$this->redirect($redirect);
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