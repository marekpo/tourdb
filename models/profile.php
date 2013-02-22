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
		),
		'SacMainSection' => array(
			'className' => 'SacSection'
		),
		'SacAdditionalSection1' => array(
			'className' => 'SacSection'
		),
		'SacAdditionalSection2' => array(
			'className' => 'SacSection'
		),
		'SacAdditionalSection3' => array(
			'className' => 'SacSection'
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
				'rule' => 'notEmpty',
				'last' => true
		),
			'validPhone' => array(
				'rule' => 'validatePhone'
			)
		),
		'phonebusiness' => array(
			'validPhone' => array(
				'rule' => 'validatePhone',
				'allowEmpty' => true
			)
		),
		'cellphone' => array(
			'validPhone' => array(
				'rule' => 'validatePhone',
				'allowEmpty' => true
			)
		),
		'emergencycontact1_address' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'emergencycontact1_phone' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
		),
			'validPhone' => array(
				'rule' => 'validatePhone'
			)
		),
		'emergencycontact2_phone' => array(
			'validPhone' => array(
				'rule' => 'validatePhone',
				'allowEmpty' => true
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
		),
		'sac_member' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'birthdate' => array(
			'correctDateOrEmpty' => array(
				'rule' => array('date','dmy'),
				'allowEmpty' => true
			)
		)
	);

	function beforeSave($options = array())
	{
		if(isset($this->data['Profile']['sac_member']) && !$this->data['Profile']['sac_member'])
		{
			$this->data['Profile']['sac_membership_number'] = null;
			$this->data['Profile']['sac_main_section_id'] = null;
			$this->data['Profile']['sac_additional_section1_id'] = null;
			$this->data['Profile']['sac_additional_section2_id'] = null;
			$this->data['Profile']['sac_additional_section3_id'] = null;
		}

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

	function afterFind($results, $primary = false)
	{
		if($primary)
		{
			foreach($results as $index => $profile)
			{
				if(!isset($profile['Profile']))
				{
					continue;
				}

				if(isset($profile['Profile']['birthdate']) && !empty($profile['Profile']['birthdate']))
				{
					$results[$index]['Profile']['age'] = $this->__calculateAge($profile['Profile']['birthdate']);
				}
			}
		}
		else
		{
			if(isset($results['birthdate']) && !empty($results['birthdate']))
			{
				$results['age'] = $this->__calculateAge($results['birthdate']);
			}
		}

		return $results;
	}

	/**
	 * This method updates the profile of the specified user with the supplied
	 * data.
	 *
	 * @param string $userId
	 * 		The id of the user whose profile should be updated.
	 * @param array $data
	 * 		An array containing the new data for the user's profile.
	 *
	 * @return array|boolean
	 * 		If the profile was updated successfully, the profile record is
	 * 		returned, else, false ist returned.
	 */
	function updateProfile($userId, $data)
	{
		$profileId = $this->field('id', array('Profile.user_id' => $userId));

		if(!empty($profileId))
		{
			$data['Profile']['id'] = $profileId;
		}

		$data['Profile']['user_id'] = $userId;

		return $this->save($data);
	}

	function __calculateAge($birthdate)
	{
		$birthDateTime = new DateTime($birthdate);
		return $birthDateTime->diff(new DateTime('now'))->y;
	}
}