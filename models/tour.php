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
		)
	);

	var $hasMany = array(
		'TourParticipation'
	);

	var $hasAndBelongsToMany = array(
		'TourType',
		'ConditionalRequisite',
		'Difficulty'
	);

	function beforeSave()
	{
		$this->data['TourType'] = $this->data['Tour']['TourType'];
		$this->data['ConditionalRequisite'] = $this->data['Tour']['ConditionalRequisite'];
		$this->data['Difficulty'] = $this->data['Tour']['Difficulty'];

		unset(
			$this->data['Tour']['TourType'],
			$this->data['Tour']['ConditionalRequisite'],
			$this->data['Tour']['Difficulty']
		);

		return true;
	}
}