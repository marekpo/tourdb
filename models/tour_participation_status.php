<?php
class TourParticipationStatus extends AppModel
{
	const REGISTERED = 'registered';
	const AFFIRMED = 'affirmed';
	const WAITINGLIST = 'waitinglist';
	const CANCELED = 'canceled';
	const REJECTED = 'rejected';

	var $name = 'TourParticipationStatus';

	var $displayField = 'statusname';

	var $hasMany = array('TourParticipation');
}