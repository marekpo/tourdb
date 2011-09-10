<?php
class M4e6b8e70690845cdae141cb81b2c2a9b extends CakeMigration {

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

			$Difficulty->updateAll(array('name' => "'3a'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 1));
			$Difficulty->updateAll(array('name' => "'3b'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 2));
			$Difficulty->updateAll(array('name' => "'3c'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 3));
			$Difficulty->updateAll(array('name' => "'4a'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 4));
			$Difficulty->updateAll(array('name' => "'4b'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 5));
			$Difficulty->updateAll(array('name' => "'4c'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 6));
			$Difficulty->updateAll(array('name' => "'5a'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 7));
			$Difficulty->updateAll(array('name' => "'5b'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 8));
			$Difficulty->updateAll(array('name' => "'5c'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 9));
			$Difficulty->updateAll(array('name' => "'5c+'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 10));
			$Difficulty->updateAll(array('name' => "'6a-'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 11));
			$Difficulty->updateAll(array('name' => "'6a'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 12));
			$Difficulty->updateAll(array('name' => "'6a+'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 13));
			$Difficulty->updateAll(array('name' => "'6b'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 14));
			$Difficulty->updateAll(array('name' => "'6b+'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 15));
			$Difficulty->updateAll(array('name' => "'6c'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 16));
			$Difficulty->updateAll(array('name' => "'6c+'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 17));
			$Difficulty->updateAll(array('name' => "'7a'"), array('group' => Difficulty::ROCK_CLIMBING, 'rank' => 18));
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