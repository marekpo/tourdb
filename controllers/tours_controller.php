<?php
class ToursController extends AppController
{
	var $name = 'Tours';

	var $components = array('RequestHandler', 'Email');

	var $helpers = array('Widget', 'Time', 'TourDisplay', 'Display', 'Csv', 'Excel');

	var $paginate = array(
		'limit' => 20,
		'order' => array('Tour.startdate' => 'ASC')
	);

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('search', 'view', 'calendar', 'sendEmailTourLeader');
	}

	/**
	 * @auth:requireRole(tourleader)
	 */
	function add()
	{
		$whitelist = $this->Tour->getEditWhitelist();

		if(!empty($this->data))
		{
			$this->data['Tour']['tour_guide_id'] = $this->Auth->user('id');

			$this->Tour->create($this->data);
			if($this->Tour->validates())
			{
				$this->data['Tour']['startdate'] = date('Y-m-d', strtotime($this->data['Tour']['startdate']));
				$this->data['Tour']['enddate'] = date('Y-m-d', strtotime($this->data['Tour']['enddate']));

				if($this->Tour->save($this->data, array('validate' => false, 'fieldList' => $whitelist)))
				{
					$this->redirect(array('action' => 'listMine'));
				}

				$this->Session->setFlash(__('Die Tour konnte nicht gespeichert werden.', true));
			}
		}
		else
		{
			$this->data['Tour']['signuprequired'] = true;
		}

		$this->set(compact('whitelist'));

		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_GROUP, Tour::WIDGET_TOUR_TYPE, Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(editor)
	 * @auth:requireRole(tourleader)
	 */
	function formGetAdjacentTours($startDate, $endDate)
	{
		$smallestEndDate = date('Y-m-d', strtotime('-1 week', strtotime($startDate)));
		$biggestStartDate = date('Y-m-d', strtotime('+1 week', strtotime($endDate)));

		$this->set(array(
			'adjacentTours' => $this->Tour->find('all', array(
				'conditions' => array(
					'OR' => array(
						array('enddate >=' => $smallestEndDate, 'enddate <=' => $endDate),
						array('startdate <=' => $biggestStartDate, 'startdate >=' => $startDate)
					)
				),
				'order' => array('startdate' => 'ASC'),
				'contain' => array(
					'TourGuide' => array(
						'fields' => array('username'),
						'Profile' => array(
							'fields' => array('firstname', 'lastname')
						)
					)
				)
			))
		));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(editor)
	 * @auth:requireRole(tourleader)
	 */
	function formGetTourCalendar($year, $month)
	{
		$this->set(array(
			'tours' => $this->Tour->getCalendarData($year, $month, array(
				'contain' => array('TourGuide', 'TourGuide.Profile', 'TourType', 'ConditionalRequisite', 'Difficulty', 'TourStatus', 'TourGroup')
			)),
			'month' => $month,
			'year' => $year
		));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(editor)
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function edit($id)
	{
		$whitelist = $this->Tour->getEditWhitelist($id);
		$newStatusOptions = $this->Tour->getNewStatusOptions($this->Authorization->getRoleKeys());

		if(!empty($this->data))
		{
			if(isset($this->data['Tour']['change_status']))
			{
				if(in_array($this->data['Tour']['change_status'], array_keys($newStatusOptions)))
				{
					$this->data['Tour']['tour_status_id'] = $this->Tour->TourStatus->field('id', array(
						'key' => $this->data['Tour']['change_status']
					));
				}
				unset($this->data['Tour']['change_status']);
			}

			$this->Tour->create($this->data);

			if($this->Tour->validates())
			{
				$this->Tour->setChangeDetail($this->Auth->user('id'), sprintf('%s:%s', Inflector::underscore($this->name), Inflector::underscore($this->action)));

				if(empty($whitelist) || $this->Tour->save($this->data, array('validate' => false, 'fieldList' => $whitelist)))
				{
					if($this->Session->check('referer.tours.edit'))
					{
						$redirect = $this->Session->read('referer.tours.edit');
						$this->Session->delete('referer.tours.edit');
						$this->redirect($redirect);
					}

					$this->redirect(array('action' => 'index'));
				}
			}
		}
		else
		{
			$this->Session->write('referer.tours.edit', $this->referer(null, true));
		}

		$tour = $this->Tour->findById($id);

		if(empty($this->data))
		{
			$this->data = $tour;
		}
		else
		{
			$data['Tour'] = array_merge($tour['Tour'], $this->data['Tour']);
			unset($tour['Tour'], $this->data['Tour']);
			$this->data = array_merge($tour, $data, $this->data);
		}

		$this->data['Tour']['startdate'] = date('d.m.Y', strtotime($this->data['Tour']['startdate']));
		$this->data['Tour']['enddate'] = date('d.m.Y', strtotime($this->data['Tour']['enddate']));

		if($this->data['Tour']['deadline'] != null)
		{
			$this->data['Tour']['deadline'] = date('d.m.Y', strtotime($this->data['Tour']['deadline']));
		}

		$this->set(compact('whitelist', 'newStatusOptions'));
		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_GROUP, Tour::WIDGET_TOUR_TYPE, Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function delete($id)
	{
		if(!empty($this->data) && $this->data['Tour']['confirm'])
		{
			if($this->Session->check('referer.tours.delete'))
			{
				$redirect = $this->Session->read('referer.tours.delete');
				$this->Session->delete('referer.tours.delete');
			}
			else
			{
				$redirect = array('action' => 'index');
			}

			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}

			if(!$this->Tour->delete($id))
			{
				$this->Session->setFlash(__('Die Tour konnte nicht gelöscht werden.', true));
			}

			$this->Session->setFlash(__('Die Tour wurde gelöscht.', true));
			$this->redirect($redirect);
		}

		$this->Session->write('referer.tours.delete', $this->referer(null, true));

		$this->data = $this->Tour->find('first', array(
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourGuide', 'TourGuide.Profile')
		));
	}

	/**
	 * @auth:requireRole(tourleader)
	 */
	function listMine()
	{
		
		if(!isset($this->params['url']['range']))
		{
			$this->params['url']['range'] = Tour::FILTER_RANGE_CURRENT;
		}		
		
		$tourIds = $this->Tour->searchTours($this->params['url'], array(
			'Tour.tour_guide_id' => $this->Auth->user('id')
		));

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('Tour.id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array('TourGroup', 'TourStatus', 'TourType', 'ConditionalRequisite', 'Difficulty')
		));

		$this->data['Tour'] = $this->params['url'];
		unset($this->data['Tour']['url']);

		$tours = $this->Tour->setEditableByTourGuide($this->paginate('Tour'));

		$this->set(array(
			'tours' => $tours,
			'unfilteredTourCount' => $this->Tour->find('count', array(
				'conditions' => array('Tour.tour_guide_id' => $this->Auth->user('id')),
				'contain' => array()
			)),
			'filtersCollapsed' => empty($this->data['Tour']['TourGroup'])
				&& $this->data['Tour']['range'] == Tour::FILTER_RANGE_CURRENT			
				&& empty($this->data['Tour']['startdate'])
				&& empty($this->data['Tour']['enddate'])
				&& empty($this->data['Tour']['TourGuide'])
				&& empty($this->data['Tour']['TourType'])
				&& empty($this->data['Tour']['ConditionalRequisite'])
				&& empty($this->data['Tour']['Difficulty'])
		));

		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_GROUP, Tour::WIDGET_TOUR_TYPE, Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(editor)
	 * @auth:requireRole(tourleader)
	 */
	function index()
	{
		if(!isset($this->params['url']['range']))
		{
			$this->params['url']['range'] = Tour::FILTER_RANGE_CURRENT;
		}

		$tourIds = $this->Tour->searchTours($this->params['url']);

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('Tour.id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array('TourGroup', 'TourStatus', 'TourType', 'Difficulty', 'ConditionalRequisite', 'TourGuide.Profile'),
		));

		$this->data['Tour'] = $this->params['url'];
		unset($this->data['Tour']['url']);

		$this->set(array(
			'tours' => $this->paginate('Tour'),
			'tourGuides' => $this->Tour->TourGuide->getUsersByRole(Role::TOURLEADER, array(
				'contain' => array('Profile')
			)),
			'filtersCollapsed' => empty($this->data['Tour']['TourGroup'])
				&& $this->data['Tour']['range'] == Tour::FILTER_RANGE_CURRENT
				&& empty($this->data['Tour']['TourStatus'])
				&& empty($this->data['Tour']['startdate'])
				&& empty($this->data['Tour']['enddate'])
				&& empty($this->data['Tour']['TourGuide'])
				&& empty($this->data['Tour']['TourType'])
				&& empty($this->data['Tour']['ConditionalRequisite'])
				&& empty($this->data['Tour']['Difficulty'])
		));

		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_STATUS, Tour::WIDGET_TOUR_GUIDE, Tour::WIDGET_TOUR_TYPE,
			Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY, Tour::WIDGET_TOUR_GROUP
		)));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(editor)
	 * @auth:requireRole(tourleader)
	 */
	function export()
	{
		if(!empty($this->data))
		{
			$valid = true;

			if(!isset($this->data['Tour']['startdate']) || empty($this->data['Tour']['startdate']) || strtotime($this->data['Tour']['startdate']) === false)
			{
				$this->Tour->invalidate('startdate', 'correctDate');
				$valid = false;
			}

			if(!isset($this->data['Tour']['enddate']) || empty($this->data['Tour']['enddate']) || strtotime($this->data['Tour']['enddate']) === false)
			{
				$this->Tour->invalidate('enddate', 'correctDate');
				$valid = false;
			}

			if($valid && strtotime($this->data['Tour']['startdate']) > strtotime($this->data['Tour']['enddate']))
			{
				$this->Tour->invalidate('enddate', 'greaterOrEqualStartDate');
				$valid = false;
			}

			if(empty($this->data['Tour']['tour_status_id']))
			{
				$this->Tour->invalidate('tour_status_id', 'notEmpty');
				$valid = false;
			}

			if($valid)
			{
				$searchConditions['Tour.tour_status_id'] = $this->data['Tour']['tour_status_id'];
				$searchConditions['Tour.startdate >='] = date('Y-m-d', strtotime($this->data['Tour']['startdate']));
				$searchConditions['Tour.enddate <='] = date('Y-m-d', strtotime($this->data['Tour']['enddate']));

				if(isset($this->data['Tour']['tour_group_id']) && !empty($this->data['Tour']['tour_group_id']))
				{
					$searchConditions['Tour.tour_group_id'] = $this->data['Tour']['tour_group_id'];
				}

				$tours = $this->Tour->find('all', array(
					'recursive' => 2,
					'conditions' => array('AND' => $searchConditions),
					'order' => array('startdate' => 'ASC'),
					'contain' => array('TourGroup', 'TourGuide', 'TourGuide.Profile', 'ConditionalRequisite', 'TourType', 'Difficulty', 'TourStatus')
				));

				if(empty($tours))
				{
					$this->Session->setFlash(__('Für die angegebenen Kriterien wurden keine Touren gefunden.', true));
				}
				else
				{
					$this->viewPath = Inflector::underscore($this->name) . DS . 'xls';
					$this->set(compact('tours'));
				}
			}
		}

		$this->set($this->Tour->getWidgetData(array(Tour::WIDGET_TOUR_GROUP)));
		$this->set(array(
			'tourStatuses' => $this->Tour->TourStatus->find('list', array(
				'conditions' => array('TourStatus.key' => array(TourStatus::NEW_, TourStatus::FIXED, TourStatus::PUBLISHED, TourStatus::CANCELED, TourStatus::REGISTRATION_CLOSED)),
				'order' => array('TourStatus.rank' => 'ASC')
			)),
			'tourStatusDefault' => array_keys($this->Tour->TourStatus->find('list', array(
				'conditions' => array('TourStatus.key' => array(Tourstatus::FIXED, TourStatus::PUBLISHED, TourStatus::CANCELED, TourStatus::REGISTRATION_CLOSED)),
				'order' => array('TourStatus.rank' => 'ASC')
			)))
		));
	}

	/**
	 * @auth:allowed()
	 */
	function search()
	{
		if(!isset($this->params['url']['range']))
		{
			$this->params['url']['range'] = Tour::FILTER_RANGE_CURRENT;
		}

		$tourIds = $this->Tour->searchTours($this->params['url'], array(
			'TourStatus.key' => array(TourStatus::FIXED, TourStatus::PUBLISHED, TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED, TourStatus::CARRIED_OUT, TourStatus::NOT_CARRIED_OUT)
		));

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('Tour.id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array('TourGroup', 'TourStatus', 'TourType', 'Difficulty', 'ConditionalRequisite', 'TourGuide.Profile'),
		));

		$this->data['Tour'] = $this->params['url'];
		unset($this->data['Tour']['url']);

		$this->set(array(
			'tours' => $this->paginate('Tour'),
			'tourGuides' => $this->Tour->TourGuide->getUsersByRole(Role::TOURLEADER, array(
				'contain' => array('Profile')
			)),
			'filtersCollapsed' => empty($this->data['Tour']['TourGroup'])
				&& $this->data['Tour']['range'] == Tour::FILTER_RANGE_CURRENT
				&& empty($this->data['Tour']['TourStatus'])
				&& empty($this->data['Tour']['startdate'])
				&& empty($this->data['Tour']['enddate'])
				&& empty($this->data['Tour']['TourGuide'])
				&& empty($this->data['Tour']['TourType'])
				&& empty($this->data['Tour']['ConditionalRequisite'])
				&& empty($this->data['Tour']['Difficulty'])
		));

		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_STATUS, Tour::WIDGET_TOUR_GUIDE, Tour::WIDGET_TOUR_TYPE,
			Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY, Tour::WIDGET_TOUR_GROUP
		)));
	}

	/**
	 * @auth:allowed()
	 */
	function view($id)
	{
		$tour = $this->Tour->find('first', array(
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourGroup', 'TourStatus', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty', 'TourGuide.Profile', 'TourGuideReport.id')
		));

		$fixedTourStatus = $this->Tour->TourStatus->findByKey(TourStatus::FIXED);

		if(empty($tour) || $tour['TourStatus']['rank'] < $fixedTourStatus['TourStatus']['rank'])
		{
			$this->Session->setFlash(__('Diese Tour wurde nicht gefunden.', true));
			$this->redirect('/');
		}

		if(!$tour['Tour']['signuprequired'])
		{
			$registrationOpen = false;
			$currentUserAlreadySignedUp = false;
			$tourParticipations = array();
		}
		else
		{
			$registrationOpen = $this->Tour->isRegistrationOpen($id);
			$currentUserAlreadySignedUp = $this->Auth->user() ? $this->Tour->TourParticipation->tourParticipationExists($id, $this->Auth->user('id')) : false;

			$this->paginate['TourParticipation'] = array(
				'contain' => array('User.Profile', 'TourParticipationStatus'),
				'limit' => 1000
			);
			$tourParticipations = $tour['Tour']['tour_guide_id'] == $this->Auth->user('id') || $this->Authorization->hasRole(Role::SAFETYCOMMITTEE)
				? $this->paginate('TourParticipation', array(
					'TourParticipation.tour_id' => $tour['Tour']['id']
				))
				: array();
		}

		if($currentUserAlreadySignedUp)
		{
			$currentUsersTourParticipation = $this->Tour->TourParticipation->getTourParticipation($id, $this->Auth->user('id'));

			$this->Tour->TourParticipation->set($currentUsersTourParticipation);

			$this->set(array(
				'currentUsersTourParticipation' => $currentUsersTourParticipation,
				'mayBeCanceledByUser' => $this->Tour->TourParticipation->mayBeCanceledByUser()
			));
		}

		$this->set(compact('tour', 'registrationOpen', 'currentUserAlreadySignedUp', 'tourParticipations'));
	}

	/**
	 * @auth:allowed()
	 */
	function calendar($year = null, $month = null)
	{
		if(empty($year) || empty($month))
		{
			$this->redirect(array('action' => 'calendar', date('Y'), date('m')));
		}

		$tourStatusVisible = $this->Tour->TourStatus->find('all', array(
			'fields' => array('TourStatus.id', 'TourStatus.statusname'),
			'conditions' => array('TourStatus.key' => array(TourStatus::FIXED, TourStatus::PUBLISHED, TourStatus::CANCELED, TourStatus::REGISTRATION_CLOSED, TourStatus::CARRIED_OUT, TourStatus::NOT_CARRIED_OUT)),
			'contain' => array()
		));

		$tours = $this->Tour->getCalendarData($year, $month, array(
			'conditions' => array('Tour.tour_status_id' => Set::extract('/TourStatus/id', $tourStatusVisible)),
			'contain' => array('TourGroup', 'TourGuide', 'TourGuide.Profile', 'TourStatus', 'TourType', 'ConditionalRequisite', 'Difficulty')
		));

		$this->loadModel('Appointment');
		$appointments = $this->Appointment->getCalendarData($year, $month, array(
			'contain' => array()
		));

		$allCalendarItems = $this->Tour->sortRecords($tours, $appointments);

		$this->set(compact('allCalendarItems', 'year', 'month'));
	}

	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function closeRegistration($id)
	{
		if(!empty($this->data))
		{
			$redirect = array('action' => 'view', $id);

			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}

			$registrationClosedStatusId = $this->Tour->TourStatus->field('id', array('key' => TourStatus::REGISTRATION_CLOSED));

			$this->__changeTourStatus($id, $registrationClosedStatusId);

			$this->Session->setFlash(__('Die Anmeldung für diese Tour wurde geschlossen.', true));
			$this->redirect($redirect);
		}
		else
		{
			$this->data = $this->Tour->find('first', array(
				'fields' => array('Tour.id', 'Tour.title'),
				'conditions' => array('Tour.id' => $id),
				'contain' => false
			));
		}
	}
	
	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function reopenRegistration($id)
	{
		if(!empty($this->data))
		{
			$redirect = array('action' => 'view', $id);
	
			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}
	
			$publishedStatusId = $this->Tour->TourStatus->field('id', array('key' => TourStatus::PUBLISHED));
	
			$this->__changeTourStatus($id, $publishedStatusId);
	
			$this->Session->setFlash(__('Die Anmeldung für diese Tour wurde wiedereröffnet.', true));
			$this->redirect($redirect);
		}
		else
		{
			$this->data = $this->Tour->find('first', array(
					'fields' => array('Tour.id', 'Tour.title'),
					'conditions' => array('Tour.id' => $id),
					'contain' => false
			));
		}
	}
	

	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function cancel($id)
	{
		$tour = $this->Tour->find('first', array(
			'fields' => array('Tour.id', 'Tour.title', 'TourGroup.tourgroupname'),
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourGroup')
		));

		$this->set(compact('tour'));

		if(!empty($this->data))
		{
			$redirect = array('action' => 'view', $id);

			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}

			$canceledStatusId = $this->Tour->TourStatus->field('id', array('key' => TourStatus::CANCELED));

			$this->__changeTourStatus($id, $canceledStatusId);

			$tourParticipationStatuses = $this->Tour->TourParticipation->TourParticipationStatus->find('all', array(
				'conditions' => array('TourParticipationStatus.key' => array(TourParticipationStatus::REGISTERED, TourParticipationStatus::AFFIRMED, TourParticipationStatus::WAITINGLIST)),
				'contain' => false
			));

			$tourParticipations = $this->Tour->TourParticipation->find('all', array(
				'conditions' => array(
					'TourParticipation.tour_id' => $id,
					'TourParticipation.tour_participation_status_id' => Set::extract('/TourParticipationStatus/id', $tourParticipationStatuses)
				),
				'contain' => array('User', 'User.Profile')
			));

			foreach($tourParticipations as $tourParticipation)
			{
				$this->set(array(
					'tourParticipation' => $tourParticipation,
					'message' => $this->data['Tour']['message']
				));

				$this->_sendEmail($tourParticipation['User']['email'], sprintf(__('Die Tour "%s" wurde abgesagt', true), $tour['Tour']['title']), 'tours/cancel_tour_participant');
			}

			$this->Session->setFlash(__('Die Tour wurde abgesagt.', true));
			$this->redirect($redirect);
		}
		else
		{
			$this->data = $tour;
		}
	}

	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function carriedOut($id)
	{
		$carriedOutStatusId = $this->Tour->TourStatus->field('id', array('key' => TourStatus::CARRIED_OUT));

		$this->__changeTourStatus($id, $carriedOutStatusId);

		$this->Session->setFlash(__('Die Tour wurde als durchgeführt markiert.', true));
		$this->redirect($this->referer(null, true));
	}

	/**
	 * @auth:requireRole(user)
	 */
	function signUp($id)
	{
		if(!$this->Tour->find('count', array('conditions' => array('Tour.id' => $id))))
		{
			$this->Session->setFlash(__('Diese Tour wurde nicht gefunden.', true));
			$this->redirect('/');
		}

		if(!$this->Tour->field('signuprequired', array('Tour.id' => $id)))
		{
			$this->Session->setFlash(__('Für diese Tour ist keine Anmeldung erforderlich.', true));
			$this->redirect(array('action' => 'view', $id));
		}

		if($this->Tour->TourParticipation->tourParticipationExists($id, $this->Auth->user('id')))
		{
			$this->Session->setFlash(__('Du bist bereits für diese Tour angemeldet.', true));
			$this->redirect(array('action' => 'view', $id));
		}

		$this->loadModel('Profile');

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
				if($tourParticipation = $this->Tour->TourParticipation->createTourParticipation($id, $this->Auth->user('id'), $this->data['TourParticipation']))
				{
					$this->loadModel('User');

					$tour = $this->Tour->find('first', array(
						'conditions' => array('Tour.id' => $id),
						'contain' => array('TourGroup', 'TourGuide', 'TourGuide.Profile', 'TourType')
					));

					$user = $this->User->find('first', array(
						'conditions' => array('User.id' => $this->Auth->user('id')),
						'contain' => array(
							'Profile', 'Profile.Country', 'Profile.LeadClimbNiveau', 'Profile.SecondClimbNiveau',
							'Profile.AlpineTourNiveau', 'Profile.SkiTourNiveau', 'Profile.SacMainSection', 'Profile.SacAdditionalSection1'
						)
					));

					$this->set(array(
						'user' => $user,
						'tour' => $tour,
						'tourParticipation' => $tourParticipation
					));

					$this->_sendEmail(
						$this->Auth->user('email'),
						sprintf(__('Deine Touranmeldung zu "%s"', true), $tour['Tour']['title']),
						'tours/signup_participant'
					);

					$this->_sendEmail(
						$tour['TourGuide']['email'],
						sprintf(__('Neue Anmeldung zu "%s"', true), $tour['Tour']['title']),
						'tours/signup_tourguide'
					);

					$this->Session->setFlash(__('Deine Anmeldung zu dieser Tour wurde gespeichert.', true));
					$this->redirect(array('action' => 'view', $id));
				}
			}

			$this->Session->setFlash(__('Beim Anmelden ist ein Fehler aufgetreten.', true));
		}
		else
		{
			$this->data = $this->Profile->find('first', array(
				'conditions' => array('user_id' => $this->Auth->user('id'))
			));
		}

		$this->loadModel('Country');
		$this->loadModel('SacSection');

		$this->set(array(
			'tour' => $this->Tour->find('first', array(
				'conditions' => array('Tour.id' => $id),
				'contain' => array()
			)),
			'countries' => $this->Country->find('list', array(
				'order' => array('name' => 'ASC')
			)),
			'climbingDifficulties' => $this->Tour->Difficulty->getRockClimbingDifficulties(),
			'skiAndAlpineTourDifficulties' => $this->Tour->Difficulty->getSkiAndAlpineTourDifficulties(),
			'sacSections' => $this->SacSection->find('list', array(
				'order' => array('SacSection.id' => 'ASC'),
				'contain' => array()
			))
		));
	}

	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 * @auth:requireRole(safetycommittee)
	 */
	function exportParticipantList($id)
	{
		if(!empty($this->data))
		{
			$tour = $this->Tour->find('first', array(
				'conditions' => array('Tour.id' => $id),
				'contain' => array(
					'TourGroup', 'TourGuide', 'TourGuide.Profile', 'TourGuide.Profile.SacMainSection',
					'TourGuide.Profile.LeadClimbNiveau', 'TourGuide.Profile.SecondClimbNiveau',
					'TourGuide.Profile.AlpineTourNiveau', 'TourGuide.Profile.SkiTourNiveau',
					'ConditionalRequisite', 'TourType', 'Difficulty'
				)
			));

			$conditions = $this->data['Tour']['exportAffirmedParticipantsOnly'] ? array('TourParticipationStatus.key' => 'affirmed') : array();

			$tourParticipations = $this->Tour->TourParticipation->find('all', array(
				'conditions' => array_merge(array('TourParticipation.tour_id' => $id), $conditions),
				'contain' => array(
					'User', 'User.Profile', 'User.Profile.LeadClimbNiveau', 'User.Profile.SecondClimbNiveau',
					'User.Profile.AlpineTourNiveau', 'User.Profile.SkiTourNiveau', 'User.Profile.SacMainSection',
					'TourParticipationStatus' 
				)
			));

			$this->viewPath = Inflector::underscore($this->name) . DS . 'xls';
			$this->set(array(
				'tour' => $tour,
				'tourParticipations' => $tourParticipations,
				'exportEmergencyContacts' => $this->data['Tour']['exportEmergencyContacts'],
				'exportExperienceInformation' => $this->data['Tour']['exportExperienceInformation'],
				'exportAdditionalInformation' => $this->data['Tour']['exportAdditionalInformation']
			));
		}

		$this->data = $this->Tour->find('first', array(
			'fields' => array('Tour.id', 'Tour.title'),
			'conditions' => array('Tour.id' => $id),
			'contain' => array()
		));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(bookkeeper)
	 */
	function listToursWithoutReport()
	{
		$reportDeadLine = date('Y-m-d', strtotime('-30 day'));
		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array(
				'AND' => array(
					'TourGuideReport.id' => null,
					'Tour.enddate <' => $reportDeadLine
				),
				'TourStatus.key' => array(Tourstatus::FIXED, TourStatus::PUBLISHED, TourStatus::CANCELED, TourStatus::REGISTRATION_CLOSED)
			),
			'contain' => array('TourStatus', 'TourType', 'Difficulty', 'ConditionalRequisite', 'TourGuide.Profile', 'TourGuideReport.id')
		));

		$this->set(array(
			'tours' => $this->paginate('Tour')
		));
	}

	/**
	 * @auth:requireRole(tourchief)
	 * @auth:requireRole(bookkeeper)
	 */
	function reminderTourguideReport($id)
	{
		$tour = $this->Tour->find('first', array(
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourGuide', 'TourGuide.Profile')
		));

		if(!empty($this->data) && $this->data['Tour']['confirm'])
		{
			$redirect = array('action' => 'listToursWithoutReport');

			if(isset($this->data['Tour']['cancel']) && $this->data['Tour']['cancel'])
			{
				$this->redirect($redirect);
			}

			$this->set(array('tour' => $tour));

			$this->_sendEmail(
				$tour['TourGuide']['email'],
				sprintf(__('Tourenrapport Erinnerung für die Tour "%s"', true), $tour['Tour']['title']),
				'tours/reminder_tourguide_report'
			);

			$this->Session->setFlash(__('Die E-Mail wurde verschickt.', true));
			$this->redirect($redirect);
		}
		else
		{
			$this->data = $tour;
		}
	}

	function __changeTourStatus($id, $statusId)
	{
		$tour = $this->Tour->find('first', array(
			'conditions' => array('Tour.id' => $id),
			'contain' => array()
		));

		if(empty($tour))
		{
			$this->Session->setFlash(__('Diese Tour wurde nicht gefunden.', true));
			$this->redirect('/');
		}

		if($tour['Tour']['tour_guide_id'] != $this->Auth->user('id'))
		{
			$this->Session->setFlash(__('Nur der Tourleiter darf diese Aktion durchführen.', true));
			$this->redirect($this->referer(null, true));
		}

		$this->Tour->setChangeDetail($this->Auth->user('id'), sprintf('%s:%s', Inflector::underscore($this->name), Inflector::underscore($this->action)));
		if(!$this->Tour->save(array('Tour' => array('id' => $id, 'tour_status_id' => $statusId))))
		{
			$this->Session->setFlash(__('Beim Ändern des Tourstatus ist ein Fehler aufgetreten.', true));
			$this->redirect($this->referer(null, true));
		}
	}
	
	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function sendEmailAllSelected($id)
	{
		$tour = $this->Tour->find('first', array(
				'fields' => array('Tour.id', 'Tour.title'),
				'conditions' => array('Tour.id' => $id),
				'contain' => array()
		));
	
		$this->set(compact('tour'));
	
		if(!empty($this->data))
		{
			$tour = $this->Tour->find('first', array(
					'conditions' => array('Tour.id' => $id),
					'contain' => array('TourGuide.email')
			));

			$tourParticipations = $this->Tour->TourParticipation->find('all', array(
					'conditions' => array(
							'TourParticipation.tour_id' => $id,
							'TourParticipation.tour_participation_status_id' => $this->data['Tour']['participationStatuses']
					),
					'contain' => array('User.email')
			));
			
			$tourParticipationEmails = array();
			foreach($tourParticipations as $tourParticipation)
			{
				$tourParticipationEmails[] = $tourParticipation['User']['email'];
			}
			$this->redirect(sprintf('mailto:%s?bcc=%s&subject=%s: %s', $tour['TourGuide']['email'], implode(';', $tourParticipationEmails), __('Tour',true), $tour['Tour']['title']));
		}
		else
		{
			$this->data = $tour;
			$this->set(array(
					'participationStatuses' => $this->Tour->TourParticipation->TourParticipationStatus->find('list', array(
							'conditions' => array('TourParticipationStatus.key' => array(TourParticipationStatus::REGISTERED, TourParticipationStatus::AFFIRMED, TourParticipationStatus::WAITINGLIST, TourParticipationStatus::CANCELED, TourParticipationStatus::REJECTED)),
							'order' => array('TourParticipationStatus.rank' => 'ASC')
					)),
					'participationStatusDefault' => array_keys($this->Tour->TourParticipation->TourParticipationStatus->find('list', array(
							'conditions' => array('TourParticipationStatus.key' => array(TourParticipationStatus::AFFIRMED)),
							'order' => array('TourParticipationStatus.rank' => 'ASC')
					)))
			));
		}
	}	
	
	/**
	 * @auth:allowed()
	 */
	function sendEmailTourLeader($id)
	{
		$tour = $this->Tour->find('first', array(
				'conditions' => array('Tour.id' => $id),
				'contain' => array('TourGuide')
		));
		$this->redirect(sprintf('mailto:%s?subject=%s: %s',$tour['TourGuide']['email'], __('Tour',true), $tour['Tour']['title']));
	}
}