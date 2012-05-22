<?php
class M4fb9093d12204cddb03d1fb01b2c2a9b extends CakeMigration {

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
		$safetyCommitteeRoleId = '4fb90ee3-60bc-4812-bbff-0a0c1b2c2a9b';
		$safetyCommitteeRoleRank = 5;

		if($direction == 'up')
		{
			$safetyCommitteeRole = array(
				'Role' => array(
					'id' => $safetyCommitteeRoleId,
					'rolename' => 'Sicherheitskomitee',
					'key' => 'safetycommittee',
					'rank' => $safetyCommitteeRoleRank
				)
			);

			$query = sprintf('UPDATE `%s%s` SET `rank` = `rank` + 1 WHERE `rank` >= %d ORDER BY `rank` DESC', $Role->tablePrefix, $Role->table, $safetyCommitteeRoleRank);
			$Role->query($query);
			
			$Role->save($safetyCommitteeRole);
		}

		if($direction == 'down')
		{
			$Role->delete($safetyCommitteeRoleId);
			$Role->updateAll(array('rank' => 'rank - 1'), array('rank >' => $safetyCommitteeRoleRank));
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