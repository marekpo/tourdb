<?php
class M4e50e7e6ce3847f7823115e01b2c2a9b extends CakeMigration {

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
			$Menu = $this->generateModel('Menu');
			$Menu->Behaviors->attach('Tree');
			$menuEntry = array(
				'Menu' => array(
					'id' => '4e50e8d4-55e4-4779-9488-0cc01b2c2a9b',
					'caption' => 'Touren exportieren',
					'controller' => 'tours',
					'action' => 'export',
					'protected' => '1',
					'parent_id' => '4e285def-8ae4-4cc1-8caa-088c1b2c2a9b'
				)
			);
			$Menu->save($menuEntry);

			$Privilege = $this->generateModel('Privilege');
			$exportPrivilege = array(
				'Privilege' => array(
					'id' => '4e50e9a3-0688-4fd8-b0ae-0cc01b2c2a9b',
					'key' => 'tours:export',
					'label' => 'Touren: Exportieren'
				)
			);
			$Privilege->save($exportPrivilege);
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