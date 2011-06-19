<?php
class Privilege extends AppModel
{
	var $name = 'Privilege';

	var $displayField = 'label';

	var $hasAndBelongsToMany = array('Role');
}