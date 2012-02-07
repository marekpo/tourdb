<?php
class ToursController extends AppController
{
	var $name = 'Tours';

	var $components = array('RequestHandler', 'Email');

	var $helpers = array('Widget', 'Time', 'TourDisplay', 'Display', 'Csv', 'Excel');

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('*');//search', 'view');

		$this->paginate = array(
			'limit' => 20,
			'order' => array('Tour.startdate' => 'ASC')
		);
	}

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

		$this->set(compact('whitelist'));

		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_TYPE, Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

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

	function formGetTourCalendar($year, $month)
	{
		$this->set(array(
			'tours' => $this->Tour->getCalendarData($year, $month, array(
				'contain' => array('TourGuide', 'TourGuide.Profile', 'TourType', 'ConditionalRequisite', 'Difficulty', 'TourStatus')
			)),
			'month' => $month,
			'year' => $year
		));
	}

	function edit($id)
	{
		$whitelist = $this->Tour->getEditWhitelist($id);
		$newStatusOptions = $this->Tour->getNewStatusOptions($this->Authorization->getRoles());

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

		if(!$this->Session->check('referer.tours.edit'))
		{
			$this->Session->write('referer.tours.edit', $this->referer(null, true));
		}

		$this->set(compact('whitelist', 'newStatusOptions'));
		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_TYPE, Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	function listMine()
	{
		$tourIds = $this->Tour->searchTours($this->params['url'], array(
			'Tour.tour_guide_id' => $this->Auth->user('id')
		));

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('Tour.id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array('TourStatus', 'TourType', 'ConditionalRequisite', 'Difficulty')
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
			'filtersCollapsed' => empty($this->data['Tour']['startdate'])
				&& empty($this->data['Tour']['enddate'])
				&& empty($this->data['Tour']['TourGuide'])
				&& empty($this->data['Tour']['TourType'])
				&& empty($this->data['Tour']['ConditionalRequisite'])
				&& empty($this->data['Tour']['Difficulty'])
		));

		$this->set($this->Tour->getWidgetData(array(
			Tour::WIDGET_TOUR_TYPE, Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	function index()
	{
		$this->paginate = array_merge($this->paginate, array(
			'contain' => array('TourStatus', 'TourType', 'ConditionalRequisite', 'Difficulty', 'TourGuide', 'TourGuide.Profile')
		));

		$this->set(array(
			'tours' => $this->paginate('Tour')
		));
	}

	function export()
	{
		if(!empty($this->data))
		{
			$this->Tour->set($this->data);
			if($this->Tour->validates())
			{
				$dateRangeStart = date('Y-m-d', strtotime($this->data['Tour']['startdate']));
				$dateRangeEnd= date('Y-m-d', strtotime($this->data['Tour']['enddate']));

				$tours = $this->Tour->find('all', array(
					'recursive' => 2,
					'conditions' => array(
						'AND' => array(
							'startdate >=' => $dateRangeStart,
							'startdate <=' => $dateRangeEnd,
							'TourStatus.key' => array(Tourstatus::FIXED, TourStatus::PUBLISHED)
						)
					),
					'order' => array('startdate' => 'ASC'),
					'contain' => array('TourGuide', 'TourGuide.Profile', 'ConditionalRequisite', 'TourType', 'Difficulty', 'TourStatus')
				));

				if(empty($tours))
				{
					$this->Session->setFlash(__('Für die angegebenen Kriterien wurden keine Touren gefunden.', true));
				}
				else
				{
					$this->viewPath = Inflector::underscore($this->name) . DS . 'csv';
					$this->set(compact('tours'));
				}
			}
		}
	}

	function search()
	{
		if(!isset($this->params['url']['deadline']))
		{
			$this->params['url']['deadline'] = date('Y-m-d');
		}

		$tourIds = $this->Tour->searchTours($this->params['url'], array(
			'TourStatus.key' => array(TourStatus::PUBLISHED, TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED, TourStatus::CARRIED_OUT)
		));

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('Tour.id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array('TourStatus', 'TourType', 'Difficulty', 'ConditionalRequisite', 'TourGuide.Profile'),
		));

		$this->data['Tour'] = $this->params['url'];
		unset($this->data['Tour']['url']);

		$this->set(array(
			'tours' => $this->paginate('Tour'),
			'tourGuides' => $this->Tour->TourGuide->getUsersByRole(Role::TOURLEADER, array(
				'contain' => array('Profile')
			)),
			'filtersCollapsed' => !empty($this->data['Tour']['deadline'])
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
			Tour::WIDGET_CONDITIONAL_REQUISITE, Tour::WIDGET_DIFFICULTY
		)));
	}

	function view($id)
	{
		$tour = $this->Tour->find('first', array(
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourStatus', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty', 'TourGuide.Profile')
		));

		$publishedTourStatus = $this->Tour->TourStatus->findByKey(TourStatus::PUBLISHED);

		if(empty($tour) || $tour['TourStatus']['rank'] < $publishedTourStatus['TourStatus']['rank'])
		{
			$this->Session->setFlash(__('Diese Tour wurde nicht gefunden.', true));
			$this->redirect('/');
		}

		$registrationOpen = $this->Tour->isRegistrationOpen($id);
		$currentUserAlreadySignedUp = $this->Auth->user() ? $this->Tour->TourParticipation->tourParticipationExists($id, $this->Auth->user('id')) : false;

		if($currentUserAlreadySignedUp)
		{
			$currentUsersTourParticipation = $this->Tour->TourParticipation->getTourParticipation($id, $this->Auth->user('id'));

			$this->Tour->TourParticipation->set($currentUsersTourParticipation);

			$this->set(array(
				'currentUsersTourParticipation' => $currentUsersTourParticipation,
				'mayBeCanceledByUser' => $this->Tour->TourParticipation->mayBeCanceledByUser()
			));
		}

		$this->paginate['TourParticipation'] = array(
			'contain' => array('User.Profile', 'TourParticipationStatus')
		);
		$tourParticipations = $tour['Tour']['tour_guide_id'] == $this->Auth->user('id')
			? $this->paginate('TourParticipation', array(
				'TourParticipation.tour_id' => $tour['Tour']['id']
			))
			: array();

		$this->set(compact('tour', 'registrationOpen', 'currentUserAlreadySignedUp', 'tourParticipations'));
	}

	function closeRegistration($id)
	{
		if(!empty($this->data))
		{
			$registrationClosedStatusId = $this->Tour->TourStatus->field('id', array('key' => TourStatus::REGISTRATION_CLOSED));
	
			$this->__changeTourStatus($id, $registrationClosedStatusId);
	
			$this->Session->setFlash(__('Die Anmeldung für diese Tour wurde geschlossen.', true));
			$this->redirect(array('action' => 'view', $id));
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

	function cancel($id)
	{
		$tour = $this->Tour->find('first', array(
			'fields' => array('Tour.id', 'Tour.title'),
			'conditions' => array('Tour.id' => $id),
			'contain' => false
		));
		$this->set(compact('tour'));

		if(!empty($this->data))
		{
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

			$this->set(compact('tour'));

			foreach($tourParticipations as $tourParticipation)
			{
				$this->set(array(
					'tourParticipation' => $tourParticipation,
					'message' => $this->data['Tour']['message']
				));
	
				$this->_sendEmail($tourParticipation['User']['email'], sprintf(__('Die Tour "%s" wurde abgesagt', true), $tour['Tour']['title']), 'tours/cancel_tour_participant');
			}

			$this->Session->setFlash(__('Die Tour wurde abgesagt.', true));
			$this->redirect($this->referer(null, true));
		}
		else
		{
			$this->data = $tour;
		}
	}

	function carriedOut($id)
	{
		$carriedOutStatusId = $this->Tour->TourStatus->field('id', array('key' => TourStatus::CARRIED_OUT));

		$this->__changeTourStatus($id, $carriedOutStatusId);

		$this->Session->setFlash(__('Die Tour wurde als durchgeführt markiert.', true));
		$this->redirect($this->referer(null, true));
	}

	function signUp($id)
	{
		if($this->Tour->TourParticipation->tourParticipationExists($id, $this->Auth->user('id')))
		{
			$this->Session->setFlash(__('Du bist bereits für diese Tour angemeldet.', true));
			$this->redirect(array('action' => 'view', $id));
		}

		$count = $this->Tour->find('count', array(
			'conditions' => array('Tour.id' => $id),
		));

		if(!$count)
		{
			$this->Session->setFlash(__('Diese Tour wurde nicht gefunden.', true));
			$this->redirect('/');
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
						'contain' => array('TourGuide', 'TourGuide.Profile', 'TourType')
					));

					$user = $this->User->find('first', array(
						'conditions' => array('User.id' => $this->Auth->user('id')),
						'contain' => array(
							'Profile', 'Profile.Country', 'Profile.LeadClimbNiveau', 'Profile.SecondClimbNiveau',
							'Profile.AlpineTourNiveau', 'Profile.SkiTourNiveau'
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

		$this->set(array(
			'tour' => $this->Tour->find('first', array(
				'conditions' => array('Tour.id' => $id),
				'contain' => array()
			)),
			'countries' => $this->Country->find('list', array(
				'order' => array('name' => 'ASC')
			)),
			'climbingDifficulties' => $this->Tour->Difficulty->getRockClimbingDifficulties(),
			'skiAndAlpineTourDifficulties' => $this->Tour->Difficulty->getSkiAndAlpineTourDifficulties()
		));
	}

	function exportParticipantList($id)
	{
		if(!empty($this->data))
		{
			$tour = $this->Tour->find('first', array(
				'conditions' => array('Tour.id' => $id),
				'contain' => array('TourGuide', 'TourGuide.Profile')
			));

			$tourParticipations = $this->Tour->TourParticipation->find('all', array(
				'conditions' => array('TourParticipation.tour_id' => $id),
				'contain' => array(
					'User', 'User.Profile', 'User.Profile.LeadClimbNiveau', 'User.Profile.SecondClimbNiveau',
					'User.Profile.AlpineTourNiveau', 'User.Profile.SkiTourNiveau'
				)
			));

			$this->viewPath = Inflector::underscore($this->name) . DS . 'xls';
			$this->set(array(
				'tour' => $tour,
				'tourParticipations' => $tourParticipations
			));
		}

		$this->data = $this->Tour->find('first', array(
			'fields' => array('Tour.id', 'Tour.title'),
			'conditions' => array('Tour.id' => $id),
			'contain' => array()
		));
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
}