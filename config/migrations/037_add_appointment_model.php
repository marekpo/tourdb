<?php
class M4fc511d086284e15b77f06881b2c2a9b extends CakeMigration {

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
				'appointments' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'location' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'startdate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'enddate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
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
			'drop_table' => array(
				'appointments'
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
		$Menu = $this->generateModel('Menu');

		$separatorId = '4fc52c09-9a08-4c37-b8a7-0f4c1b2c2a9b';
		$indexActionId = '4fc52c3c-9f90-4360-be33-0f4c1b2c2a9b';
		$addActionId = '4fc52c4e-e5b4-435b-8959-0f4c1b2c2a9b';
		$exportActionId = '4ff35812-237c-4b20-9ba4-1bf01b2c2a9b';
		$separatorRank = 9;

		if($direction == 'up')
		{

			$appointmentMenuEntries = array(
				array(
					'id' => $separatorId,
					'separator' => true,
					'caption' => '',
					'controller' => '',
					'action' => '',
					'protected' => false,
					'rank' => $separatorRank
				),
				array(
					'id' => $addActionId,
					'separator' => false,
					'caption' => 'Anlass hinzufügen',
					'controller' => 'appointments',
					'action' => 'add',
					'protected' => true,
					'rank' => $separatorRank + 1
				),
				array(
					'id' => $indexActionId,
					'separator' => false,
					'caption' => 'Alle Anlässe',
					'controller' => 'appointments',
					'action' => 'index',
					'protected' => true,
					'rank' => $separatorRank + 2
				),
				array(
					'id' => $exportActionId,
					'separator' => false,
					'caption' => 'Anlässe exportieren',
					'controller' => 'appointments',
					'action' => 'export',
					'protected' => true,
					'rank' => $separatorRank + 3
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 4'), array('rank >=' => $separatorRank));
			$Menu->saveAll($appointmentMenuEntries);
		}

		if($direction == 'down')
		{
			$Menu->deleteAll(array('Menu.id' => array($separatorId, $indexActionId, $addActionId, $exportActionId)));
			$Menu->updateAll(array('rank' => 'rank - 4'), array('rank >=' => $separatorRank));
		}

		return true;
	}
}
?>