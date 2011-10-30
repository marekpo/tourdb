<?php
class TourParticipation extends AppModel
{
	var $name = 'TourParticipation';

	var $belongsTo = array('Tour', 'User', 'TourParticipationStatus');

	function createTourParticipation($tourId, $userId)
	{
		$tourParticipationStatusId = $this->TourParticipationStatus->field('id', array('key' => TourParticipationStatus::REGISTERED));

		$this->create(array(
			'TourParticipation' => array(
				'tour_id' => $tourId,
				'user_id' => $userId,
				'tour_participation_status_id' => $tourParticipationStatusId
			)
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
}