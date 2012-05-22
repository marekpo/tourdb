<?php
class M4fb9168749e84a82837919281b2c2a9b extends CakeMigration {

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
			'create_field' => array(
				'tours' => array(
					'tour_group_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'title'),
					
				)
			),
			'create_table' => array(
				'tour_groups' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tourgroupname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'rank' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'tours' => array('tour_group_id')
			),
			'drop_table' => array(
				'tour_groups'
			)
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
			$TourGroup = $this->generateModel('TourGroup');
			$sectionGroupId = '4fb91b04-13d0-435f-b0cb-15a81b2c2a9b';
			$tourGroups = array(
				array(
					'id' => $sectionGroupId,
					'tourgroupname' => 'Sektion',
					'key' => 'section',
					'rank' => 0
				),
				array(
					'id' => '4fb91b0f-d2b4-4957-9314-15a81b2c2a9b',
					'tourgroupname' => 'Jugend (JO)',
					'key' => 'youth',
					'rank' => 1
				),
				array(
					'id' => '4fb91b17-03a8-44cc-a423-15a81b2c2a9b',
					'tourgroupname' => 'Senioren',
					'key' => 'seniors',
					'rank' => 2
				)
			);

			$TourGroup->saveAll($tourGroups);

			$Tour = $this->generateModel('Tour');
			$Tour->updateAll(array('tour_group_id' => sprintf("'%s'", $sectionGroupId)));
		}

		return true;
	}
}
?>