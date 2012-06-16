<?php
class M4fd4d1d3c5f0461e899315341b2c2a9b extends CakeMigration {

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
		$Role = $this->generateModel('Role');
		$bookkeeperRoleId = 'b340f5e3-b396-11e1-87b7-add00ac1a90b';
		$bookkeeperRoleRank = 6;

		if($direction == 'up')
		{
			$bookkeeperRole = array(
				'Role' => array(
					'id' => $bookkeeperRoleId,
					'rolename' => 'Buchhalter',
					'key' => 'bookkeeper',
					'rank' => $bookkeeperRoleRank
				)
			);

			$query = sprintf('UPDATE `%s%s` SET `rank` = `rank` + 1 WHERE `rank` >= %d ORDER BY `rank` DESC', $Role->tablePrefix, $Role->table, $bookkeeperRoleRank);
			$Role->query($query);
			
			$Role->save($bookkeeperRole);
		}

		if($direction == 'down')
		{
			$Role->delete($bookkeeperRoleId);
			$Role->updateAll(array('rank' => 'rank - 1'), array('rank >' => $bookkeeperRoleRank));
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