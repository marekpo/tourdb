<?php
class M4e4eb38ed56048c98b6c12ec1b2c2a9b extends CakeMigration {

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
			if(!class_exists('Difficulty'))
			{
				App::import('Model', 'Difficulty');
			}

			$Difficulty = $this->generateModel('Difficulty');
			$difficulties = array(
				array(
					'Difficulty' => array(
						'name' => 'III',
						'rank' => 3,
						'group' => Difficulty::ALPINE_TOUR
					)
				),
				array(
					'Difficulty' => array(
						'name' => 'IV',
						'rank' => 4,
						'group' => Difficulty::ALPINE_TOUR
					)
				),
				array(
					'Difficulty' => array(
						'name' => 'V',
						'rank' => 5,
						'group' => Difficulty::ALPINE_TOUR
					)
				)
			);
			$Difficulty->saveAll($difficulties);

			$TourType = $this->generateModel('TourType');
			$courseTourType = array(
				'TourType' => array(
					'title' => 'Kurs',
					'acronym' => 'Kurs'
				)
			);
			$TourType->save($courseTourType);
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
}
?>