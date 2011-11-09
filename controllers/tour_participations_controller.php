<?php
class TourParticipationsController extends AppController
{
	var $name = 'TourParticipations';

	var $helpers = array('Widget', 'Display');

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
}