<?php
class ModelChange extends AppModel
{
	var $name = 'ModelChange';

	var $belongsTo = array('User');

	var $hasMany = array('ModelChangeDetail');
}