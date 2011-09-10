<?php
class Tour extends AppModel
{
	var $name = 'Tour';

	var $actsAs = array('Calendar');

	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty' 
			)
		),
		'TourType' => array(
			'rightQuanitity' => array(
				'rule' => array('multiple', array('min' => 1, 'max' => 2))
			)
		),
		'ConditionalRequisite' => array(
			'rightQuanitity' => array(
				'rule' => array('multiple', array('min' => 1, 'max' => 2))
			)
		),
		'Difficulty' => array(
			'atMostTwo' => array(
				'rule' => array('multiple', array('min' => 1, 'max' => 2)),
				'allowEmpty' => true
			)
		),
		'startdate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'enddate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'greaterOrEqualStartDate' => array(
				'rule' => array('compareToDateField', '>=', 'startdate')
			)
		)
	);

	var $belongsTo = array(
		'TourGuide' => array(
			'className' => 'User'
		),
		'TourStatus'
	);

	var $hasMany = array(
		'TourParticipation'
	);

	var $hasAndBelongsToMany = array(
		'TourType',
		'ConditionalRequisite',
		'Difficulty'
	);

	function beforeSave($options = array())
	{
		if(isset($this->data['Tour']['startdate']))
		{
			$this->data['Tour']['startdate'] = date('Y-m-d', strtotime($this->data['Tour']['startdate']));
		}

		if(isset($this->data['Tour']['enddate']))
		{
			$this->data['Tour']['enddate'] = date('Y-m-d', strtotime($this->data['Tour']['enddate']));
		}

		if(in_array('TourType', $options['fieldList']) && isset($this->data['Tour']['TourType']))
		{
			$this->data['TourType'] = $this->data['Tour']['TourType'];
		}
		unset($this->data['Tour']['TourType']);
		
		if(in_array('ConditionalRequisite', $options['fieldList']) && isset($this->data['Tour']['ConditionalRequisite']))
		{
			$this->data['ConditionalRequisite'] = $this->data['Tour']['ConditionalRequisite'];
		}
		unset($this->data['Tour']['ConditionalRequisite']);
		
		if(in_array('Difficulty', $options['fieldList']) && isset($this->data['Tour']['Difficulty']))
		{
			$this->data['Difficulty'] = $this->data['Tour']['Difficulty'];
		}
		unset($this->data['Tour']['Difficulty']);

		if(empty($this->id) && empty($this->data['Tour']['id']) && empty($this->data['Tour']['tour_status_id']))
		{
			$this->data['Tour']['tour_status_id'] = $this->TourStatus->field('id', array('key' => TourStatus::NEW_));
		}

		return true;
	}

	function getEditWhitelist($id = null)
	{
		if($id == null)
		{
			$id = $this->id;
		}

		$tourStatus = $this->find('first', array(
			'fields' => array('TourStatus.rank'),
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourStatus')
		));

		$fixedTourStatus = $this->TourStatus->findByKey(TourStatus::FIXED);

		$whitelist = null;

		if($tourStatus['TourStatus']['rank'] < $fixedTourStatus['TourStatus']['rank'])
		{
			$whitelist = array_keys($this->schema());
			$whitelist[] = 'TourType';
			$whitelist[] = 'ConditionalRequisite';
			$whitelist[] = 'Difficulty';
		}
		elseif($tourStatus['TourStatus']['rank'] == $fixedTourStatus['TourStatus']['rank'])
		{
			$whitelist = array('description', 'tour_status_id');
		}
		else
		{
			$whitelist = array();
		}

		return $whitelist;
	}
}