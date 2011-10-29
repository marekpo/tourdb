<?php
class TourParticipationStatus extends AppModel
{
	const NEW_ = 'new';
	const FIXED = 'fixed';
	const PUBLISHED = 'published';
	const CANCELED = 'canceled';
	const REGISTRATION_CLOSED = 'registration_closed';
	const CARRIED_OUT = 'carried_out';

	var $name = 'TourParticipationStatus';
}