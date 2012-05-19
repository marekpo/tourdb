<?php
class TourType extends AppModel
{
	const ALPINE_TOUR		= 'alpine_tour';
	const VIA_FERRATA		= 'via_ferrata';
	const SNOWSHOE_TOUR		= 'snowshoe_tour';
	const MOUNTAINBIKE_TOUR	= 'mountainbike_tour';
	const ROCK_CLIMBING		= 'rock_climbing';
	const HIKE				= 'hike';
	const PLAISIR_CLIMBING	= 'plaisir_climbing';
	const SKI_TOUR			= 'ski_tour';
	const LANGLAUF			= 'langlauf';
	const COURSE			= 'course';
	const EXCURSION			= 'excursion';
	const ICE_CLIMBING		= 'ice_climbing';

	var $name = 'TourType';

	var $belongsTo = array('Difficulty');

	var $hasAndBelongsToMany = array('Tour');
}