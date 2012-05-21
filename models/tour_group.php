<?php
class TourGroup extends AppModel
{
	const SECTION	= 'section';
	const YOUTH		= 'youth';
	const SENIORS	= 'seniors';

	var $name = 'TourGroup';

	var $displayField = 'tourgroupname';

	var $hasMany = array('Tour');
}