<?php
class M4f319b027cc04dd5ab3006dc1b2c2a9b extends CakeMigration {

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
					'id' => '4f319b67-c8b4-4bc0-be44-11381b2c2a9b',
					'key' => 'tours:exportParticipantList',
					'label' => 'Touren: Teilnehmerliste exportieren'
				)
			);
			$Privilege->save($newPrivilege);
		}

		if($direction == 'down')
		{
			$Privilege->delete('4f319b67-c8b4-4bc0-be44-11381b2c2a9b');
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