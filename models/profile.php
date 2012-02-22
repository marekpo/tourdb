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
				'rule' => 'validateName'
			),
		),
		'lastname' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'correctFormat' => array(
				'rule' => 'validateName'
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
			'correctFormat' => array(
				'rule' => 'email',
				'allowEmpty' => true
			)
		),		
		'emergencycontact2_email' => array(
			'correctFormat' => array(
				'rule' => 'email',
				'allowEmpty' => true
			)
		),
		'freeseatsinpassengercar' => array(
			'correctFormat' => array(
				'rule' => 'numeric',
				'allowEmpty' => true
			)
		),
		'lengthsinglerope' => array(
			'correctFormat' => array(
				'rule' => 'numeric',
				'allowEmpty' => true
			)
		),
		'lengthhalfrope' => array(
			'correctFormat' => array(
				'rule' => 'numeric',
				'allowEmpty' => true
			)
		)
	);

	function beforeSave($options = array())
	{
		if(isset($this->data['Profile']['ownpassengercar']) && !$this->data['Profile']['ownpassengercar'])
		{
			$this->data['Profile']['freeseatsinpassengercar'] = null;
		}

		if(isset($this->data['Profile']['ownsinglerope']) && !$this->data['Profile']['ownsinglerope'])
		{
			$this->data['Profile']['lengthsinglerope'] = null;
		}

		if(isset($this->data['Profile']['ownhalfrope']) && !$this->data['Profile']['ownhalfrope'])
		{
			$this->data['Profile']['lengthhalfrope'] = null;
		}

		if(isset($this->data['Profile']['birthdate']))
		{
			$this->data['Profile']['birthdate'] = empty($this->data['Profile']['birthdate']) ? null : date('Y-m-d', strtotime($this->data['Profile']['birthdate']));
		}

		return true;
	}
}