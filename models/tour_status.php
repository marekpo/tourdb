<?php
class TourStatus extends AppModel
{
	const NEW_ = 'new';
	const FIXED = 'fixed';
	const PUBLISHED = 'published';
	const CANCELED = 'canceled';
	const REGISTRATION_CLOSED = 'registration_closed';
	const CARRIED_OUT = 'carried_out';
	const NOT_CARRIED_OUT = 'not_carried_out';

	var $name = 'TourStatus';

	var $displayField = 'statusname';

	var $hasMany = array('Tour');
}