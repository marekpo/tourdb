<?php
class TourStatus extends AppModel
{
	const NEW_ = 'new';
	const PUBLISHED = 'published';
	const CANCELED = 'canceled';
	const REGISTRATION_CLOSED = 'registration_closed';
	const CARRIED_OUT = 'carried_out';

	var $name = 'TourStatus';

	var $displayField = 'statusname';

	var $hasMany = array('Tour');
}