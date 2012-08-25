<?php
class M4e554d18f3804380bebf0efc1b2c2a9b extends CakeMigration {

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
			'create_table' => array(
				'profiles' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'firstname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'profiles'
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
		if($direction == 'up')
		{
			$Menu = $this->generateModel('Menu');
			$Menu->Behaviors->attach('Tree');
			$menuEntry = array(
				'Menu' => array(
					'id' => '4e554da6-43a8-4cab-ae54-11301b2c2a9b',
					'caption' => 'Profil bearbeiten',
					'controller' => 'profiles',
					'action' => 'edit',
					'protected' => '1',
					'parent_id' => '4e3e8ce5-b67c-41b8-b6ff-12001b2c2a9b'
				)
			);
			$Menu->save($menuEntry);

			$Privilege = $this->generateModel('Privilege');
			$exportPrivilege = array(
				'Privilege' => array(
					'id' => '4e554e06-6e90-413e-83fa-11301b2c2a9b',
					'key' => 'profiles:edit',
						'label' => 'Profil: bearbeiten'
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