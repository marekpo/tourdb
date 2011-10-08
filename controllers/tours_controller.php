<?php
class ToursController extends AppController
{
	var $name = 'Tours';

	var $components = array('RequestHandler');

	var $helpers = array('Widget', 'Time', 'TourDisplay', 'Display', 'Csv');

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('search');

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
		$this->__setFormContent();
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
		else
		{
			$this->data = $this->Tour->findById($id);
			$this->data['Tour']['startdate'] = date('d.m.Y', strtotime($this->data['Tour']['startdate']));
			$this->data['Tour']['enddate'] = date('d.m.Y', strtotime($this->data['Tour']['enddate']));

			$this->Session->write('referer.tours.edit', $this->referer(null, true));
		}

		$this->set(compact('whitelist', 'newStatusOptions'));
		$this->__setFormContent();
	}

	function listMine()
	{
		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('tour_guide_id' => $this->Auth->user('id'))
		));

		$this->set(array(
			'tours' => $this->paginate('Tour')
		));
	}

	function index()
	{
		$this->paginate = array_merge($this->paginate, array(
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
		$tourIds = $this->Tour->searchTours($this->params['url']);

		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('Tour.id' => Set::extract('/Tour/id', $tourIds)),
			'contain' => array('TourStatus', 'TourType', 'Difficulty', 'ConditionalRequisite', 'TourGuide.Profile'),
		));

		$this->set(array(
			'tours' => $this->paginate('Tour'),
		));

		$this->data['Tour'] = $this->params['url'];

		$this->set(array(
			'tourGuides' => $this->Tour->TourGuide->getUsersByRole(Role::TOURLEADER, array(
				'contain' => array('Profile')
			))
		));

		$this->__setFormContent();
	}

	function __setFormContent()
	{
		$this->set(array(
			'tourTypes' => $this->Tour->TourType->find('list', array(
				'fields' => array('acronym')
			)),
			'conditionalRequisites' => $this->Tour->ConditionalRequisite->find('list', array(
				'fields' => array('acronym'),
				'order' => array('acronym' => 'ASC')
			)),
			'difficultiesSkiAndAlpineTour' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::SKI_AND_ALPINE_TOUR),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesAlpineTour' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ALPINE_TOUR),
				'order' => array('rank' => 'ASC')
			)),
			'difficultiesHike' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::HIKE),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesSnowshowTour' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::SNOWSHOE_TOUR),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesViaFerrata' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::VIA_FERRATA),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesRockClimbing' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesIceClimbing' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ICE_CLIMBING),
				'order' => array('rank' => 'ASC')
			))
		));
	}
}