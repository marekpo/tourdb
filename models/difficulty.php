<?php
class Difficulty extends AppModel
{
	const SKI_AND_ALPINE_TOUR	= 1;
	const HIKE					= 2;
	const SNOWSHOE_TOUR			= 3;
	const VIA_FERRATA			= 4;
	const ROCK_CLIMBING			= 5;
	const ALPINE_TOUR			= 6;
	const ICE_CLIMBING			= 7;

	var $name = 'Difficulty';

	var $hasAndBelongsToMany = array('Tour');
}