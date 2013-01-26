<?php
class TourParticipation extends AppModel
{
	var $name = 'TourParticipation';

	var $belongsTo = array(
		'Tour',
		'User',
		'SignupUser' => array(
			'className' => 'User'
		),
		'TourParticipationStatus',
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
		'email' => array(
			'validEmail' => array(
				'rule' => 'email',
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
		'sac_member' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
	);

	function beforeSave($options = array())
	{
		if(isset($this->data['TourParticipation']['sac_member']) && !$this->data['TourParticipation']['sac_member'])
		{
			$this->data['TourParticipation']['sac_membership_number'] = null;
			$this->data['TourParticipation']['sac_main_section_id'] = null;
			$this->data['TourParticipation']['sac_additional_section1_id'] = null;
			$this->data['TourParticipation']['sac_additional_section2_id'] = null;
			$this->data['TourParticipation']['sac_additional_section3_id'] = null;
		}

		if(isset($this->data['TourParticipation']['ownpassengercar']) && !$this->data['TourParticipation']['ownpassengercar'])
		{
			$this->data['TourParticipation']['freeseatsinpassengercar'] = null;
		}

		if(isset($this->data['TourParticipation']['ownsinglerope']) && !$this->data['TourParticipation']['ownsinglerope'])
		{
			$this->data['TourParticipation']['lengthsinglerope'] = null;
		}

		if(isset($this->data['TourParticipation']['ownhalfrope']) && !$this->data['TourParticipation']['ownhalfrope'])
		{
			$this->data['TourParticipation']['lengthhalfrope'] = null;
		}

		return true;
	}

	/**
	 * This method creates a new tour participation. If the parameter
	 * $updateProfile is set to true, the
	 *
	 * @param string $tourId
	 * 		The id of the tour the new tour participation should be created
	 * 		for.
	 * @param string $userId
	 * 		The id of the user the new tour participation should be created
	 * 		for (may be null).
	 * @param string $signupUserId
	 * 		The id of the user that creates the new tour participation.
	 * @param array $data
	 * 		An array containing the data for the new tour participation.
	 * @param boolean $updateProfile
	 * 		Indicates, whether the user's profile should be updated after the
	 * 		new tour participation has been created successfully.
	 *
	 * @return array|boolean
	 *		If the new tour participation has been created successfully, the
	 *		created record is returned. If the creation was not successfull,
	 *		false will be returned.
	 */
	function createTourParticipation($tourId, $userId, $signupUserId, $data = array(), $updateProfile = false)
	{
		$tourParticipationStatusId = $this->TourParticipationStatus->field('id', array('key' => TourParticipationStatus::REGISTERED));

		$newTourParticipationData = $data;
		$newTourParticipationData['TourParticipation']['tour_id'] = $tourId;
		$newTourParticipationData['TourParticipation']['user_id'] = $userId;
		$newTourParticipationData['TourParticipation']['signup_user_id'] = $signupUserId;
		$newTourParticipationData['TourParticipation']['tour_participation_status_id'] = $tourParticipationStatusId;

		$saveResult = $this->save($newTourParticipationData);

		if($updateProfile && !empty($userId) && $saveResult !== false)
		{
			$this->User->Profile->updateProfile($userId, array('Profile' => $data['TourParticipation']));
		}

		return $saveResult;
	}

	function tourParticipationExists($tourId, $userId)
	{
		$count = $this->find('count', array(
			'conditions' => array(
				'tour_id' => $tourId,
				'user_id' => $userId
			)
		));

		return $count > 0;
	}

	function getTourParticipation($tourId, $userId)
	{
		return $this->find('first', array(
			'conditions' => array(
				'tour_id' => $tourId,
				'user_id' => $userId
			),
			'contain' => array('TourParticipationStatus')
		));
	}

	/**
	 * This method returns the initial tour participation data from the
	 * specified user's profile.
	 *
	 * @param string $userId
	 * 		The id of the user that you want to get the initial tour
	 * 		participation data for.
	 *
	 * @return array|null
	 * 		Returns the initial tour participation data, or null, if the user
	 * 		currently has no profile.
	 */
	function getInitialTourParticipationData($userId)
	{
		$profile = $this->User->Profile->find('first', array(
			'fields' => array(
				'Profile.firstname', 'Profile.lastname', 'Profile.street', 'Profile.housenumber',
				'Profile.extraaddressline', 'Profile.zip', 'Profile.city', 'Profile.country_id',
				'Profile.phoneprivate', 'Profile.phonebusiness', 'Profile.cellphone', 'Profile.emergencycontact1_address',
				'Profile.emergencycontact1_phone', 'Profile.emergencycontact1_email', 'Profile.emergencycontact2_address',
				'Profile.emergencycontact2_phone', 'Profile.emergencycontact2_email', 'Profile.sac_member',
				'Profile.sac_membership_number', 'Profile.sac_main_section_id', 'Profile.sac_additional_section1_id',
				'Profile.sac_additional_section2_id', 'Profile.sac_additional_section3_id', 'Profile.experience_rope_guide',
				'Profile.experience_knot_technique', 'Profile.experience_rope_handling', 'Profile.experience_avalanche_training',
				'Profile.lead_climb_niveau_id', 'Profile.second_climb_niveau_id', 'Profile.alpine_tour_niveau_id',
				'Profile.ski_tour_niveau_id', 'Profile.publictransportsubscription', 'Profile.ownpassengercar',
				'Profile.freeseatsinpassengercar', 'Profile.ownsinglerope', 'Profile.lengthsinglerope',
				'Profile.ownhalfrope', 'Profile.lengthhalfrope', 'Profile.owntent', 'Profile.additionalequipment',
			),
			'conditions' => array('Profile.user_id' => $userId),
			'contain' => array()
		));

		return !empty($profile) ? array('TourParticipation' => $profile['Profile']) : null;
	}

	function mayBeCanceledByUser($id = null)
	{
		if(!$id)
		{
			$id =  $this->id;
		}

		if($id)
		{
			$this->read(null, $id);
		}

		if(isset($this->data['TourParticipation']['tour_id']))
		{
			$tour = $this->Tour->find('first', array(
				'fields' => array('Tour.startdate'),
				'conditions' => array('Tour.id' => $this->data['TourParticipation']['tour_id']),
				'contain' => array()
			));

			return strtotime($tour['Tour']['startdate']) >= strtotime('+10 days');
		}

		return false;
	}

	function isParticipantRule($userId, $tourParticipationId)
	{
		return $this->find('count', array(
			'conditions' => array(
				'TourParticipation.id' => $tourParticipationId,
				'TourParticipation.user_id' => $userId
			)
		)) > 0;
	}

	function isTourGuideOfRespectiveTourRule($userId, $tourParticipationId)
	{
		return $this->find('count', array(
			'conditions' => array(
				'TourParticipation.id' => $tourParticipationId,
				'Tour.tour_guide_id' => $userId
			),
			'contain' => 'Tour'
		)) > 0;
	}
}