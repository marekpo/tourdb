<?php
class TourParticipationsController extends AppController
{
	var $name = 'TourParticipations';

	var $helpers = array('Widget');

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
		$this->paginate = array_merge($this->paginate, array(
			'conditions' => array('TourParticipation.user_id' => $this->Auth->user('id')),
			'contain' => array(
				'Tour', 'Tour.TourGuide', 'Tour.TourGuide.Profile', 'Tour.TourType',
				'Tour.ConditionalRequisite', 'Tour.Difficulty', 'TourParticipationStatus'
			)
		));

		$tours = $this->paginate('TourParticipation');

		$this->set(array(
			'tours' => $tours
		));
	}
}