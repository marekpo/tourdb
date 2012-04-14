<?php
class M4f8986f10278421a883617581b2c2a9b extends CakeMigration {

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
			'drop_table' => array(
				'privileges', 'privileges_roles'
			),
		),
		'down' => array(
			'create_table' => array(
				'privileges' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'label' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'key_UNIQUE' => array('column' => 'key', 'unique' => 1),
						'label_UNIQUE' => array('column' => 'label', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'privileges_roles' => array(
					'privilege_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'role_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'privilege_id' => array('column' => 'privilege_id', 'unique' => 0),
						'role_id' => array('column' => 'role_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
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
		$Menu = $this->generateModel('Menu');

		if($direction == 'up')
		{
			$Menu->delete(array('Menu.id' => '4e42c672-e10c-4896-abe8-12241b2c2a9b'));
		}

		if($direction == 'down')
		{
			$manageRolesMenuEntry = array(
				'Menu' => array(
					'id' => '4e42c672-e10c-4896-abe8-12241b2c2a9b',
					'caption' => 'Rollen',
					'controller' => 'roles',
					'action' => 'index',
					'protected' => '1',
					'rank' => '9'
				)
			);

			$Menu->save($manageRolesMenuEntry);
		}

		return true;
	}
}
?>