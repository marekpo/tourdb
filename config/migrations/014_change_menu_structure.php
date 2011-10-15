<?php
class M4e9993942ff049219fe30e7c1b2c2a9b extends CakeMigration {

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
			'drop_field' => array(
				'menus' => array('parent_id', 'lft', 'rght'),
			),
			'create_field' => array(
				'menus' => array(
					'separator' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'after' => 'id'),
					'rank' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'protected'),
				)
			)
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
			$Menu->deleteAll(array('1' => '1'));
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
		if($direction == 'up')
		{
			$Menu = $this->generateModel('Menu');
			$menus = array(
				array(
					'id' => '4e285def-8ae4-4cc1-8caa-088c1b2c2a9b',
					'separator' => 0,
					'caption' => 'Tourensuche',
					'controller' => 'tours',
					'action' => 'search',
					'protected' => 0,
					'rank' => 1
				),
				array(
					'id' => '4e285e58-8cd0-496e-8b3b-07b01b2c2a9b',
					'separator' => 1,
					'caption' => '',
					'controller' => '',
					'action' => '',
					'protected' => 0,
					'rank' => 2
				),
				array(
					'id' => '4e285e76-c564-4226-bccf-0aa41b2c2a9b',
					'separator' => 0,
					'caption' => 'Neue Tour',
					'controller' => 'tours',
					'action' => 'add',
					'protected' => 1,
					'rank' => 3
				),
				array(
					'id' => '4e285e84-fcfc-4beb-9200-05741b2c2a9b',
					'separator' => 0,
					'caption' => 'Meine Touren',
					'controller' => 'tours',
					'action' => 'listMine',
					'protected' => 1,
					'rank' => 4
				),
				array(
					'id' => '4e285e8f-97b0-4451-9524-0f301b2c2a9b',
					'separator' => 0,
					'caption' => 'Alle Touren',
					'controller' => 'tours',
					'action' => 'index',
					'protected' => 1,
					'rank' => 5
				),
				array(
					'id' => '4e285e9a-3884-43c3-8430-05c81b2c2a9b',
					'separator' => 0,
					'caption' => 'Touren exportieren',
					'controller' => 'tours',
					'action' => 'export',
					'protected' => 1,
					'rank' => 6
				),
				array(
					'id' => '4e3e8c78-ca24-4c86-91b8-13a01b2c2a9b',
					'separator' => 1,
					'caption' => '',
					'controller' => '',
					'action' => '',
					'protected' => 0,
					'rank' => 7
				),
				array(
					'id' => '4e3e8ce5-b67c-41b8-b6ff-12001b2c2a9b',
					'separator' => 0,
					'caption' => 'Benutzer verwalten',
					'controller' => 'users',
					'action' => 'index',
					'protected' => 1,
					'rank' => 8
				),
				array(
					'id' => '4e42c672-e10c-4896-abe8-12241b2c2a9b',
					'separator' => 0,
					'caption' => 'Rollen verwalten',
					'controller' => 'roles',
					'action' => 'index',
					'protected' => 1,
					'rank' => 9
				),
				array(
					'id' => '4e50e8d4-55e4-4779-9488-0cc01b2c2a9b',
					'separator' => 1,
					'caption' => '',
					'controller' => '',
					'action' => '',
					'protected' => 0,
					'rank' => 10
				),
				array(
					'id' => '4e554da6-43a8-4cab-ae54-11301b2c2a9b',
					'separator' => 0,
					'caption' => 'Benutzerkonto bearbeiten',
					'controller' => 'users',
					'action' => 'editAccount',
					'protected' => 1,
					'rank' => 11
				),
				array(
					'id' => '4e99999f-e244-41fb-806c-11b41b2c2a9b',
					'separator' => 0,
					'caption' => 'Profil bearbeiten',
					'controller' => 'profiles',
					'action' => 'edit',
					'protected' => 1,
					'rank' => 12
				),
			);

			$Menu->saveAll($menus);
		}

		return true;
	}
}
?>