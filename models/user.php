<?php
class User extends AppModel
{
	var $name = 'User';

	var $displayField = 'fullname';

	var $virtualFields = array(
		'fullname' => 'CONCAT(firstname, " ", lastname)' 
	);

	var $hasMany = array(
		'Tour' => array(
			'foreignKey' => 'tour_guide_id'
		),
		'TourParticipation'
	);
}