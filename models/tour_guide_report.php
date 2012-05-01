<?php
class TourGuideReport extends AppModel
{
	var $name = 'TourGuideReport';

	var $belongsTo = array('Tour', 'User');
	
	function createTourGuideReport($tourId, $userId, $data = array())
	{
			
		$this->create(array(
				'TourGuideReport' => array_merge($data, array(
						'tour_id' => $tourId,
						'tour_guide_id' => $userId
				))
		));
	
		return $this->save();
	}	
	
	
	
}