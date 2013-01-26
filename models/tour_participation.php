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

	function createTourParticipation($tourId, $userId, $signupUserId, $data = array())
	{
		$tourParticipationStatusId = $this->TourParticipationStatus->field('id', array('key' => TourParticipationStatus::REGISTERED));

		$this->create(array(
			'TourParticipation' => array_merge($data, array(
				'tour_id' => $tourId,
				'user_id' => $userId,
				'signup_user_id' => $signupUserId,
				'tour_participation_status_id' => $tourParticipationStatusId
			))
		));

		return $this->save();
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