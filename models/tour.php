<?php
class Tour extends AppModel
{
	var $name = 'Tour';

	var $belongsTo = array(
		'TourGuide' => array(
			'className' => 'User'
		)
	);

	var $hasMany = array('TourParticipation');
}