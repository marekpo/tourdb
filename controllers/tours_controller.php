<?php
class ToursController extends AppController
{
	var $name = 'Tours';

	var $components = array('RequestHandler');

	var $helpers = array('Widget', 'Time');

	var $scaffold;

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('index', 'view', 'delete');
	}

	function add()
	{
		if(!empty($this->data))
		{
			$this->data['Tour']['tour_guide_id'] = $this->Auth->user('id');

			$this->Tour->create($this->data);
			if($this->Tour->validates())
			{
				$this->data['Tour']['startdate'] = date('Y-m-d', strtotime($this->data['Tour']['startdate']));
				$this->data['Tour']['enddate'] = date('Y-m-d', strtotime($this->data['Tour']['enddate']));

				$this->data['TourType'] = $this->data['Tour']['TourType'];
				$this->data['ConditionalRequisite'] = $this->data['Tour']['ConditionalRequisite'];
				$this->data['Difficulty'] = $this->data['Tour']['Difficulty'];
				unset(
					$this->data['Tour']['TourType'],
					$this->data['Tour']['ConditionalRequisite'],
					$this->data['Tour']['Difficulty']
				);

				$this->Tour->save($this->data, array('validate' => false));

				$this->redirect(array('action' => 'index'));
			}
		}

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
			'difficultiesRockClimbing1' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING, 'rank <=' => 6),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesRockClimbing2' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING, 'rank >' => 6, 'rank <=' => 11),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesRockClimbing3' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING, 'rank >' => 11, 'rank <=' => 16),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesRockClimbing4' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING, 'rank >' => 16, 'rank <=' => 18),
				'order' => array('rank' => 'ASC'),
			))
		));
	}

	function getAdjacentTours($startDate, $endDate)
	{
		$smallestEndDate = date('Y-m-d', strtotime('-1 week', strtotime($startDate)));
		$biggestStartDate = date('Y-m-d', strtotime('+1 week', strtotime($endDate)));

		$this->set(array(
			'adjacentTours' => $this->Tour->find('all', array(
				'fields' => array('title', 'startdate', 'enddate'),
				'conditions' => array(
					'OR' => array(
						array('enddate >=' => $smallestEndDate, 'enddate <=' => $endDate),
						array('startdate <=' => $biggestStartDate, 'startdate >=' => $startDate)
					)
				),
				'order' => array('startdate' => 'ASC'),
				'contain' => array('TourGuide.id', 'TourGuide.username')
			))
		)); 
	}
}