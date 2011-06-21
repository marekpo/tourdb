<?php
class Difficulty extends AppModel
{
	const SKI_AND_ALPINE_TOUR	= 1;
	const HIKE					= 2;
	const SNOWSHOE_TOUR			= 3;
	const VIA_FERRATA			= 4;
	const ROCK_CLIMBING			= 5;

	var $name = 'Difficulty';

	var $hasAndBelongsToMany = array('Tour');

	function init()
	{
		$difficulties = array(
			array(
				'name' => 'L',
				'rank' => 1,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'WS',
				'rank' => 2,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'ZS',
				'rank' => 3,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'S',
				'rank' => 4,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'SS',
				'rank' => 5,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'AS',
				'rank' => 6,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'EX',
				'rank' => 7,
				'group' => self::SKI_AND_ALPINE_TOUR
			),
			array(
				'name' => 'T1',
				'rank' => 1,
				'group' => self::HIKE
			),
			array(
				'name' => 'T2',
				'rank' => 2,
				'group' => self::HIKE
			),
			array(
				'name' => 'T3',
				'rank' => 3,
				'group' => self::HIKE
			),
			array(
				'name' => 'T4',
				'rank' => 4,
				'group' => self::HIKE
			),
			array(
				'name' => 'T5',
				'rank' => 5,
				'group' => self::HIKE
			),
			array(
				'name' => 'T6',
				'rank' => 6,
				'group' => self::HIKE
			),
			array(
				'name' => 'WT1',
				'rank' => 1,
				'group' => self::SNOWSHOE_TOUR
			),
			array(
				'name' => 'WT2',
				'rank' => 2,
				'group' => self::SNOWSHOE_TOUR
			),
			array(
				'name' => 'WT3',
				'rank' => 3,
				'group' => self::SNOWSHOE_TOUR
			),
			array(
				'name' => 'WT4',
				'rank' => 4,
				'group' => self::SNOWSHOE_TOUR
			),
			array(
				'name' => 'WT5',
				'rank' => 5,
				'group' => self::SNOWSHOE_TOUR
			),
			array(
				'name' => 'WT6',
				'rank' => 6,
				'group' => self::SNOWSHOE_TOUR
			),
			array(
				'name' => 'K1',
				'rank' => 1,
				'group' => self::VIA_FERRATA
			),
			array(
				'name' => 'K2',
				'rank' => 2,
				'group' => self::VIA_FERRATA
			),
			array(
				'name' => 'K3',
				'rank' => 3,
				'group' => self::VIA_FERRATA
			),
			array(
				'name' => 'K4',
				'rank' => 4,
				'group' => self::VIA_FERRATA
			),
			array(
				'name' => 'K5',
				'rank' => 5,
				'group' => self::VIA_FERRATA
			),
			array(
				'name' => 'K6',
				'rank' => 6,
				'group' => self::VIA_FERRATA
			),
			array(
				'name' => '3a',
				'rank' => 1,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '3b',
				'rank' => 2,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '3c',
				'rank' => 3,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '4a',
				'rank' => 4,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '4b',
				'rank' => 5,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '4c',
				'rank' => 6,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '5a',
				'rank' => 7,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '5b',
				'rank' => 8,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '5c',
				'rank' => 9,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '5c+',
				'rank' => 10,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6a-',
				'rank' => 11,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6a',
				'rank' => 12,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6a+',
				'rank' => 13,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6b',
				'rank' => 14,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6b+',
				'rank' => 15,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6c',
				'rank' => 16,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '6c+',
				'rank' => 17,
				'group' => self::ROCK_CLIMBING
			),
			array(
				'name' => '7a',
				'rank' => 18,
				'group' => self::ROCK_CLIMBING
			),
		);

		$this->deleteAll(array('1' => '1'));

		foreach($difficulties as $difficulty)
		{
			$this->create();
			$this->save(array('Difficulty' => $difficulty));
		}
	}
}