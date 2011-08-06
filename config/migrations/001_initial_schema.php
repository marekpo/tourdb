<?php
class M4e3d23d689bc46578daa11d01b2c2a9b extends CakeMigration {

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
				'conditional_requisites' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'acronym' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'conditional_requisites_tours' => array(
					'conditional_requisite_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'conditional_requisite_id' => array('column' => 'conditional_requisite_id', 'unique' => 0),
						'tour_id' => array('column' => 'tour_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'difficulties' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 16, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'rank' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'group' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 16, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'difficulties_tours' => array(
					'difficulty_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'difficulty_id' => array('column' => 'difficulty_id', 'unique' => 0),
						'tour_id' => array('column' => 'tour_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'menus' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'caption' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'controller' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'action' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'protected' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
					'parent_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
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
					'privilege_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'role_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'privilege_id' => array('column' => 'privilege_id', 'unique' => 0),
						'role_id' => array('column' => 'role_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'rolename' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'rank' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'unique'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'rolename_UNIQUE' => array('column' => 'rolename', 'unique' => 1),
						'rank_UNIQUE' => array('column' => 'rank', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'roles_users' => array(
					'role_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'user_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'role_id' => array('column' => 'role_id', 'unique' => 0),
						'user_id' => array('column' => 'user_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tour_participations' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_participant_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tour_types' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'acronym' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tour_types_tours' => array(
					'tour_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'tour_type_id' => array('column' => 'tour_type_id', 'unique' => 0),
						'tour_id' => array('column' => 'tour_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tours' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_guide_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tourweek' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
					'withmountainguide' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
					'startdate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'enddate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'users' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'salt' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'active' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
					'last_login' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'new_password_token' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'username' => array('column' => 'username', 'unique' => 1),
						'email' => array('column' => 'email', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'conditional_requisites', 'conditional_requisites_tours', 'difficulties', 'difficulties_tours', 'menus', 'privileges', 'privileges_roles', 'roles', 'roles_users', 'tour_participations', 'tour_types', 'tour_types_tours', 'tours', 'users'
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
		if($direction == 'up')
		{
			$this->addRoleData();
			$this->addPrivilegeData();
			$this->addMenuData();
			$this->addTourMetaData();

			$this->setupRoles();
			$this->addSystemAdmin();
		}

		return true;
	}

	private function addRoleData()
	{
		$Role = $this->generateModel('Role');
		$roles = array(
			array(
				'id' => 'systemadmin',
				'rolename' => 'Systemadmin',
				'rank' => '0'
			),
			array(
				'id' => 'sectionadmin',
				'rolename' => 'Administrator Sektion',
				'rank' => '1'
			),
			array(
				'id' => 'tourchief',
				'rolename' => 'Tourenchef',
				'rank' => '2'
			),
			array(
				'id' => 'tourleader',
				'rolename' => 'Tourenleiter',
				'rank' => '3'
			),
			array(
				'id' => 'editor',
				'rolename' => 'Redakteur',
				'rank' => '4'
			),
			array(
				'id' => 'sacmember',
				'rolename' => 'SAC-Mitglied',
				'rank' => '5'
			),
			array(
				'id' => 'user',
				'rolename' => 'Benutzer',
				'rank' => '6'
			),
		);
		$Role->saveAll($roles);
	}

	private function addPrivilegeData()
	{
		$Privilege = $this->generateModel('Privilege');
		$privileges = array(
			array(
				'id' => '4dcd943d-de10-4f50-886f-11e81b2c2a9b',
				'key' => 'tours:add',
				'label' => 'Touren: Neu'
			),
			array(
				'id' => '4dfe00da-fca0-4907-9f06-12201b2c2a9b',
				'key' => 'roles:edit',
				'label' => 'System: Rollen bearbeiten'
			),
			array(
				'id' => '4dfe0356-3dbc-46ab-b776-12201b2c2a9b',
				'key' => 'roles:index',
				'label' => 'System: Alle Rollen anzeigen'
			),
			array(
				'id' => '4dfe066d-f32c-42fa-b2cf-12201b2c2a9b',
				'key' => 'users:index',
				'label' => 'System: Alle Benutzer anzeigen'
			),
			array(
				'id' => '4dfe0681-ea4c-48d3-ad78-12201b2c2a9b',
				'key' => 'users:edit',
				'label' => 'System: Benutzer bearbeiten'
			),
			array(
				'id' => '4e00ffca-57d4-471f-bd46-10781b2c2a9b',
				'key' => 'tours:formGetAdjacentTours',
				'label' => 'Touren: Neu - Angrenzende anzeigen'
			),
			array(
				'id' => '4e05e696-a1e0-4e43-8e95-13781b2c2a9b',
				'key' => 'tours:formGetTourCalendar',
				'label' => 'Touren: Neu - Tourenkalender'
			),
			array(
				'id' => '4e0a48d6-200c-4ff4-b597-03dc1b2c2a9b',
				'key' => 'tours:listMine',
				'label' => 'Touren: Eigene auflisten'
			),
			array(
				'id' => '4e1097a1-b92c-4d2b-ac3a-134c1b2c2a9b',
				'key' => 'tours:edit',
				'label' => 'Touren: Bearbeiten'
			),
			array(
				'id' => '4e271b48-1940-4c81-be78-14e41b2c2a9b',
				'key' => 'tours:index',
				'label' => 'Touren: Alle auflisten'
			)
		);
		$Privilege->saveAll($privileges);
	}

	private function addTourMetaData()
	{
		$TourType = $this->generateModel('TourType');
		$tourTypes = array(
			array(
				'title' => 'Exkursion',
				'acronym' => 'Exk'
			),
			array(
				'title' => 'Schneeschuhtour oder -wanderung',
				'acronym' => 'SS'
			),
			array(
				'title' => 'Klettertour',
				'acronym' => 'K'
			),
			array(
				'title' => 'Wanderung',
				'acronym' => 'W'
			),
			array(
				'title' => 'Plaisir-Tour',
				'acronym' => 'P'
			),
			array(
				'title' => 'Langlauf',
				'acronym' => 'LL'
			),
			array(
				'title' => 'Ski- oder Snowboardtour',
				'acronym' => 'S'
			),
			array(
				'title' => 'Klettersteigtour',
				'acronym' => 'KS'
			),
			array(
				'title' => 'Mountain Bike-Tour',
				'acronym' => 'MTB'
			),
			array(
				'id' => '4dfe29a0-fe40-4433-a676-12201b2c2a9b',
				'title' => 'Hochtour',
				'acronym' => 'H'
			)
		);
		$TourType->saveAll($tourTypes);

		$ConditionalRequisite = $this->generateModel('ConditionalRequisite');
		$conditionalRequisites = array(
			array(
				'title' => 'geringe Anforderungen',
				'acronym' => 'C',
				'description' => 'Für Beginner und Geniesser'
			),
			array(
				'title' => 'mittlere Anforderungen',
				'acronym' => 'B',
				'description' => 'Für Fortgeschrittene: mit mittlerer Ausdauer und/oder etwas Erfahrung in unwegsamem Gelände'
			),
			array(
				'title' => 'hohe Anforderungen',
				'acronym' => 'A',
				'description' => 'Für Könner: mit grosser Ausdauer und/oder Erfahrung in unwegsamem Gelände'
			)
		);
		$ConditionalRequisite->saveAll($conditionalRequisites);

		$Difficulty = $this->generateModel('Difficulty');
		$difficulties = array(
			array(
				'name' => '5c (VI-)',
				'rank' => '9',
				'group' => '5'
			),
			array(
				'name' => '6a- (VI/VI+)',
				'rank' => '11',
				'group' => '5'
			),
			array(
				'name' => '4a (IV)',
				'rank' => '4',
				'group' => '5'
			),
			array(
				'name' => 'T6',
				'rank' => '6',
				'group' => '2'
			),
			array(
				'name' => 'T3',
				'rank' => '3',
				'group' => '2'
			),
			array(
				'name' => 'WT6',
				'rank' => '6',
				'group' => '3'
			),
			array(
				'name' => '5a (V)',
				'rank' => '7',
				'group' => '5'
			),
			array(
				'name' => 'K3',
				'rank' => '3',
				'group' => '4'
			),
			array(
				'name' => 'AS',
				'rank' => '6',
				'group' => '1'
			),
			array(
				'name' => 'WT3',
				'rank' => '3',
				'group' => '3'
			),
			array(
				'name' => 'WT4',
				'rank' => '4',
				'group' => '3'
			),
			array(
				'name' => '5b (V+)',
				'rank' => '8',
				'group' => '5'
			),
			array(
				'name' => 'T2',
				'rank' => '2',
				'group' => '2'
			),
			array(
				'name' => 'K6',
				'rank' => '6',
				'group' => '4'
			),
			array(
				'name' => 'L',
				'rank' => '1',
				'group' => '1'
			),
			array(
				'name' => 'T4',
				'rank' => '4',
				'group' => '2'
			),
			array(
				'name' => 'K1',
				'rank' => '1',
				'group' => '4'
			),
			array(
				'name' => 'K5',
				'rank' => '5',
				'group' => '4'
			),
			array(
				'name' => 'WT1',
				'rank' => '1',
				'group' => '3'
			),
			array(
				'name' => '4b (IV+)',
				'rank' => '5',
				'group' => '5'
			),
			array(
				'name' => 'K4',
				'rank' => '4',
				'group' => '4'
			),
			array(
				'name' => '3b (III+)',
				'rank' => '2',
				'group' => '5'
			),
			array(
				'name' => '6b+ (VII/VII+)',
				'rank' => '15',
				'group' => '5'
			),
			array(
				'name' => 'WS',
				'rank' => '2',
				'group' => '1'
			),
			array(
				'name' => '6c (VII+)',
				'rank' => '16',
				'group' => '5'
			),
			array(
				'name' => '6a+ (VII-)',
				'rank' => '13',
				'group' => '5'
			),
			array(
				'name' => 'K2',
				'rank' => '2',
				'group' => '4'
			),
			array(
				'name' => '5c+ (VI)',
				'rank' => '10',
				'group' => '5'
			),
			array(
				'name' => '4c (V-)',
				'rank' => '6',
				'group' => '5'
			),
			array(
				'name' => 'S',
				'rank' => '4',
				'group' => '1'
			),
			array(
				'name' => 'T1',
				'rank' => '1',
				'group' => '2'
			),
			array(
				'name' => '3c (IV-)',
				'rank' => '3',
				'group' => '5'
			),
			array(
				'name' => 'WT5',
				'rank' => '5',
				'group' => '3'
			),
			array(
				'name' => '3a (III)',
				'rank' => '1',
				'group' => '5'
			),
			array(
				'name' => '6a (VI+)',
				'rank' => '12',
				'group' => '5'
			),
			array(
				'name' => 'T5',
				'rank' => '5',
				'group' => '2'
			),
			array(
				'name' => '6b (VII)',
				'rank' => '14',
				'group' => '5'
			),
			array(
				'name' => 'EX',
				'rank' => '7',
				'group' => '1'
			),
			array(
				'name' => 'SS',
				'rank' => '5',
				'group' => '1'
			),
			array(
				'name' => 'ZS',
				'rank' => '3',
				'group' => '1'
			),
			array(
				'name' => 'WT2',
				'rank' => '2',
				'group' => '3'
			),
			array(
				'name' => '7a (VIII)',
				'rank' => '18',
				'group' => '5'
			),
			array(
				'name' => '6c+ (VIII-)',
				'rank' => '17',
				'group' => '5'
			)
		);
		$Difficulty->saveAll($difficulties);
	}

	private function addMenuData()
	{
		$Menu = $this->generateModel('Menu');
		$menus = array(
			array(
				'id' => '4e285def-8ae4-4cc1-8caa-088c1b2c2a9b',
				'caption' => 'Touren',
				'controller' => 'NULL',
				'action' => 'NULL',
				'protected' => 'NULL',
				'parent_id' => 'NULL',
				'lft' => '1',
				'rght' => '6'
			),
			array(
				'id' => '4e285e58-8cd0-496e-8b3b-07b01b2c2a9b',
				'caption' => 'Benutzer',
				'controller' => 'users',
				'action' => 'index',
				'protected' => '1',
				'parent_id' => '4e285e8f-97b0-4451-9524-0f301b2c2a9b',
				'lft' => '9',
				'rght' => '10'
			),
			array(
				'id' => '4e285e76-c564-4226-bccf-0aa41b2c2a9b',
				'caption' => 'Meine Touren',
				'controller' => 'tours',
				'action' => 'listMine',
				'protected' => '1',
				'parent_id' => '4e285def-8ae4-4cc1-8caa-088c1b2c2a9b',
				'lft' => '2',
				'rght' => '5'
			),
			array(
				'id' => '4e285e84-fcfc-4beb-9200-05741b2c2a9b',
				'caption' => 'Neue Tour anlegen',
				'controller' => 'tours',
				'action' => 'add',
				'protected' => '1',
				'parent_id' => '4e285def-8ae4-4cc1-8caa-088c1b2c2a9b',
				'lft' => '3',
				'rght' => '4'
			),
			array(
				'id' => '4e285e8f-97b0-4451-9524-0f301b2c2a9b',
				'caption' => 'Benutzerverwaltung',
				'controller' => 'NULL',
				'action' => 'NULL',
				'protected' => 'NULL',
				'parent_id' => 'NULL',
				'lft' => '7',
				'rght' => '12'
			),
			array(
				'id' => '4e285e9a-3884-43c3-8430-05c81b2c2a9b',
				'caption' => 'Rollen',
				'controller' => 'roles',
				'action' => 'index',
				'protected' => '1',
				'parent_id' => '4e285e8f-97b0-4451-9524-0f301b2c2a9b',
				'lft' => '8',
				'rght' => '11'
			)
		);
		$Menu->saveAll($menus);
	}

	private function setupRoles()
	{
		$Role = $this->generateModel('Role');

		$Role->bindModel(array('hasAndBelongsToMany' => array('Privilege' => array('className' => 'Privilege'))));
		$rolesPrivileges = array(
			array(
				'Role' => array(
					'id' => 'systemadmin',
					'Privilege' => array(
						'4dfe0356-3dbc-46ab-b776-12201b2c2a9b', '4dfe00da-fca0-4907-9f06-12201b2c2a9b',
						'4dfe066d-f32c-42fa-b2cf-12201b2c2a9b', '4dfe0681-ea4c-48d3-ad78-12201b2c2a9b',
					)
				)
			)
		);

		foreach($rolesPrivileges as $rolesPrivilege)
		{
			$Role->save($rolesPrivilege);
		}
	}

	private function addSystemAdmin()
	{
		if(!class_exists('SecurityTools'))
		{
			App::import('Lib', 'SecurityTools');
		}
	
		if(!class_exists('Security'))
		{
			App::import('Core', 'Security');
		}
	
		$User = $this->generateModel('User');
		$salt = SecurityTools::generateRandomString();
		$user = array(
			'User' => array(
				'id' => 'superadmin',
				'username' => 'superadmin',
				'salt' => $salt,
				'password' => Security::hash($salt . 'superadmin', 'sha1', false),
				'email' => '',
				'active' => 1
			),
			'Role' => array(
				'id' => 'systemadmin'
			)
		);
		$User->save($user);
	}
}
?>