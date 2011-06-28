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
			'atLeastOne' => array(
				'rule' => array('multiple', array('min' => 1))
			)
		),
		'ConditionalRequisite' => array(
			'atLeastOne' => array(
				'rule' => array('multiple', array('min' => 1))
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
}