<?php
class M4ebd98395bc04e96991715541b2c2a9b extends CakeMigration {

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
					'id' => '4ebd98e0-854c-4996-a887-11dc1b2c2a9b',
					'key' => 'tour_participations:changeStatus',
					'label' => 'Tourenanmeldungen: Status ändern'
				)
			);
			$Privilege->save($newPrivilege);
		}

		if($direction == 'down')
		{
			$Privilege->delete('4ebd98e0-854c-4996-a887-11dc1b2c2a9b');
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