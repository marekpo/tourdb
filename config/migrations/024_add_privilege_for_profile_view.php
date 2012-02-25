<?php
class M4f46b0b152f849828be606401b2c2a9b extends CakeMigration {

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
		$Privilege = $this->generateModel('Privilege');

		if($direction == 'up')
		{
			$newPrivilege = array(
				'Privilege' => array(
					'id' => '4f46b0ec-6978-4120-8b2b-0b4c1b2c2a9b',
					'key' => 'profiles:view',
					'label' => 'Profil: Ansehen'
				)
			);
			$Privilege->save($newPrivilege);
		}

		if($direction == 'down')
		{
			$Privilege->delete('4f46b0ec-6978-4120-8b2b-0b4c1b2c2a9b');
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