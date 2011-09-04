<?php
class Profile extends AppModel
{
	var $name = 'Profile';

	var $belongsTo = array('User');
}