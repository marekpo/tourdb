<?php
class TourType extends AppModel
{
	var $name = 'TourType';

	var $belongsTo = array('Difficulty');

	var $hasAndBelongsToMany = array('Tour');
}