<?php
class Tour extends AppModel
{
	var $name = 'Tour';

	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty' 
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