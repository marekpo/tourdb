<?php
class ToursController extends AppController
{
	var $name = 'Tours';

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

			$this->Tour->save($this->data);
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
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING, 'rank <=' => 10),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesRockClimbing2' => $this->Tour->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING, 'rank >' => 10),
				'order' => array('rank' => 'ASC'),
			))
		));
	}
}