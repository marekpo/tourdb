<?php
class M4e496c54fb9845cea3ba04581b2c2a9b extends CakeMigration {

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
						'name' => 'I',
						'rank' => 1,
						'group' => Difficulty::ALPINE_TOUR
					)
				),
				array(
					'Difficulty' => array(
						'name' => 'II',
						'rank' => 2,
						'group' => Difficulty::ALPINE_TOUR
					)
				)
			);
			$Difficulty->saveAll($difficulties);
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