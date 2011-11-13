<?php
class M4ebfda668c504f028cfd11381b2c2a9b extends CakeMigration {

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
					'id' => '4ebfdae3-2eb8-4855-98ad-07241b2c2a9b',
					'key' => 'tour_participations:cancelTourParticipation',
					'label' => 'Tourenanmeldungen: Stornieren'
				)
			);
			$Privilege->save($newPrivilege);
		}

		if($direction == 'down')
		{
			$Privilege->delete('4ebfdae3-2eb8-4855-98ad-07241b2c2a9b');
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