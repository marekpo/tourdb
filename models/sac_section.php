<?php
class SacSection extends AppModel
{
	var $name = 'SacSection';

	var $hasMany = array('Profile');
}