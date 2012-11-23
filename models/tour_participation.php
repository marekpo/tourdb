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

	function createTourParticipation($tourId, $userId, $signupUserId, $email, $data = array())
	{
		$tourParticipationStatusId = $this->TourParticipationStatus->field('id', array('key' => TourParticipationStatus::REGISTERED));

		$this->create(array(
			'TourParticipation' => array_merge($data, array(
				'tour_id' => $tourId,
				'user_id' => $userId,
				'signup_user_id' => $signupUserId,
				'email' => $email,
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