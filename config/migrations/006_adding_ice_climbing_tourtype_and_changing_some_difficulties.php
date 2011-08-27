<?php
class M4e58c8b65a484965a9040dbc1b2c2a9b extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction)
	{
		if($direction == 'up')
		{
			$this->addIceClimbingTourTypeAndDifficulties();
			$this->changeSkiAndAlpineTourDifficulties();
			$this->changeAlpineTourDiffuculties();
		}

		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction)
	{
		return true;
	}

	private function addIceClimbingTourTypeAndDifficulties()
	{
		if(!class_exists('Difficulty'))
		{
			App::import('Model', 'Difficulty');
		}
		
		$Difficulty = $this->generateModel('Difficulty');
		$difficulties = array(
			array(
				'Difficulty' => array(
					'name' => 'Wi1',
					'rank' => 1,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi2',
					'rank' => 2,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi3-',
					'rank' => 3,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi3',
					'rank' => 4,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi3+',
					'rank' => 5,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi4-',
					'rank' => 6,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi4',
					'rank' => 7,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi4+',
					'rank' => 8,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi5-',
					'rank' => 9,
					'group' => Difficulty::ICE_CLIMBING
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'Wi5',
					'rank' => 10,
					'group' => Difficulty::ICE_CLIMBING
				)
			)
		);
		$Difficulty->saveAll($difficulties);
			
		$TourType = $this->generateModel('TourType');
		$courseTourType = array(
						'TourType' => array(
							'title' => 'Eisklettern',
							'acronym' => 'E'
		)
		);
		$TourType->save($courseTourType);
	}

	private function changeSkiAndAlpineTourDifficulties()
	{
		if(!class_exists('Difficulty'))
		{
			App::import('Model', 'Difficulty');
		}

		$Difficulty = new Difficulty();
		$difficulties = array(
			array(
				'Difficulty' => array(
					'name' => 'WS+',
					'rank' => 3,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'ZS-',
					'rank' => 4,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'ZS+',
					'rank' => 6,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'S-',
					'rank' => 7,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'S+',
					'rank' => 9,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'SS-',
					'rank' => 10,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'SS+',
					'rank' => 12,
					'group' => Difficulty::SKI_AND_ALPINE_TOUR
				)
			)
		);
		$Difficulty->saveAll($difficulties);

		file_put_contents('d:\temp\test.txt', print_r($Difficulty, true));

		$Difficulty->updateAll(array('rank' => 5), array('name' => 'ZS', 'group' => Difficulty::SKI_AND_ALPINE_TOUR));
		$Difficulty->updateAll(array('rank' => 8), array('name' => 'S', 'group' => Difficulty::SKI_AND_ALPINE_TOUR));
		$Difficulty->updateAll(array('rank' => 11), array('name' => 'SS', 'group' => Difficulty::SKI_AND_ALPINE_TOUR));

		$difficultyIdsToDelete = $Difficulty->find('list', array(
			'conditions' => array('Difficulty.name' => array('AS', 'EX'), 'Difficulty.group' => Difficulty::SKI_AND_ALPINE_TOUR)
		));

		$Difficulty->DifficultiesTour->deleteAll(array('DifficultiesTour.difficulty_id' => $difficultyIdsToDelete));

		$Difficulty->deleteAll(array('name' => array('AS', 'EX'), 'group' => Difficulty::SKI_AND_ALPINE_TOUR));
	}

	private function changeAlpineTourDiffuculties()
	{
		if(!class_exists('Difficulty'))
		{
			App::import('Model', 'Difficulty');
		}

		$Difficulty = $this->generateModel('Difficulty');
		$difficulties = array(
			array(
				'Difficulty' => array(
					'name' => 'II-',
					'rank' => 2,
					'group' => Difficulty::ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'II+',
					'rank' => 4,
					'group' => Difficulty::ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'III-',
					'rank' => 5,
					'group' => Difficulty::ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'III+',
					'rank' => 7,
					'group' => Difficulty::ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'IV-',
					'rank' => 8,
					'group' => Difficulty::ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'IV+',
					'rank' => 10,
					'group' => Difficulty::ALPINE_TOUR
				)
			),
			array(
				'Difficulty' => array(
					'name' => 'V-',
					'rank' => 11,
					'group' => Difficulty::ALPINE_TOUR
				)
			)
		);
		$Difficulty->saveAll($difficulties);
		
		$Difficulty->updateAll(array('rank' => 3), array('name' => 'II', 'group' => Difficulty::ALPINE_TOUR));
		$Difficulty->updateAll(array('rank' => 6), array('name' => 'III', 'group' => Difficulty::ALPINE_TOUR));
		$Difficulty->updateAll(array('rank' => 9), array('name' => 'IV', 'group' => Difficulty::ALPINE_TOUR));
		$Difficulty->updateAll(array('rank' => 12), array('name' => 'V', 'group' => Difficulty::ALPINE_TOUR));
	}
}
?>