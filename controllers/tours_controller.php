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
			))
		));
	}
}