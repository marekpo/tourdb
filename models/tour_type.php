<?php
class TourType extends AppModel
{
	const CAVE_TOUR	= 'cave_tour';

	var $name = 'TourType';

	var $belongsTo = array('Difficulty');

	var $hasAndBelongsToMany = array('Tour');
}