<?php
class Profile extends AppModel
{
	var $name = 'Profile';

	var $belongsTo = array(
		'User',
		'Country',
		'LeadClimbNiveau' => array(
			'className' => 'Difficulty',
		),
		'SecondClimbNiveau' => array(
			'className' => 'Difficulty',
		),
		'AlpineTourNiveau' => array(
			'className' => 'Difficulty',
		),
		'SkiTourNiveau' => array(
			'className' => 'Difficulty',
		)
	);

	var $validate = array(
		'firstname' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'correctFormat' => array(
				'rule' => '/^[a-z][a-z\-\. ]+$/i'
			),
		),
		'lastname' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'correctFormat' => array(
				'rule' => '/[a-z][a-z\- ]+/i'
			),
		),
		'street' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'zip' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'validRange' => array(
				'rule' => '/[1-9]\d{3,4}/'
			)
		),
		'city' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'country_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'phoneprivate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'emergencycontact1_address' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'emergencycontact1_phone' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'emergencycontact1_email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'correctFormat' => array(
				'rule' => 'email'
			)
		),		
		'emergencycontact2_email' => array(
			'correctFormat' => array(
				'rule' => 'email',
				'allowEmpty' => true
			)
		),
		'lead_climb_niveau_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'second_climb_niveau_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'alpine_tour_niveau_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'ski_tour_niveau_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		)
	);
}