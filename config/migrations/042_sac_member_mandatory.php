<?php
class M5065eb2f50e44e7c92eb15401b2c2a9b extends CakeMigration {

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
			'alter_field' => array(
				'profiles' => array(
					'sac_member' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'profiles' => array(
					'sac_member' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
				),
			),
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
		$Profile = $this->generateModel('Profile');

		if($direction == 'up')
		{
			$Profile->updateAll(array('sac_member' => null), array('sac_member' => 0));
		}

		if($direction == 'down')
		{
			$Profile->updateAll(array('sac_member' => 0), array('sac_member' => null));
		}

		return true;
	}
}
?>