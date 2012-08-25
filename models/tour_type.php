<?php
class TourType extends AppModel
{
	const ALPINE_TOUR		= 'alpine_tour';
	const VIA_FERRATA		= 'via_ferrata';
	const SNOWSHOE_TOUR		= 'snowshoe_tour';
	const MOUNTAINBIKE_TOUR	= 'mountainbike_tour';
	const ROCK_CLIMBING		= 'climbing_tour';
	const HIKE				= 'hike';
	const PLAISIR_CLIMBING	= 'plaisir_tour';
	const SKI_TOUR			= 'ski_tour';
	const CROSS_COUNTRY		= 'cross_country';
	const TRAINING_COURSE	= 'training_course';
	const EXCURSION			= 'excursion';
	const ICE_CLIMBING		= 'ice_climbing';
	const CAVE_TOUR			= 'cave_tour';

	var $name = 'TourType';

	var $belongsTo = array('Difficulty');

	var $hasAndBelongsToMany = array('Tour');
}