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

	function call__($method, $params)
	{
		if(preg_match('/get([a-z]+?)Difficulties/i', $method, $matches))
		{
			$difficultyGroup = constant(sprintf('self::%s', strtoupper(Inflector::underscore($matches[1]))));

			if(!isset($params[0]))
			{
				$params[0] = 'list';
			}

			return $this->find($params[0], array(
				'conditions' => array('group' => $difficultyGroup),
				'order' => array('rank' => 'ASC'),
			));
		}

		return parent::call__($method, $params);
	}
}