<?php
class M4e667dfaf18444e19a8914541b2c2a9b extends CakeMigration {

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
				'tour_statuses' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'statusname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'rank' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				)
			),
			'create_field' => array(
				'tours' => array(
					'tour_status_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'title'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'tour_statuses'
			),
			'drop_field' => array(
				'tours' => array('tour_status_id',),
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
			$TourStatus = $this->generateModel('TourStatus');
			$tourStatuses = array(
				array(
					'TourStatus' => array(
						'id' => '4e6685af-eab4-4d32-b2f9-120c1b2c2a9b',
						'statusname' => 'Neu',
						'key' => 'new',
						'rank' => 0
					)
				),
				array(
					'TourStatus' => array(
						'id' => '4e6a6af8-1334-4252-819f-13f41b2c2a9b',
						'statusname' => 'Fixiert',
						'key' => 'fixed',
						'rank' => 1
					)
				),
				array(
					'TourStatus' => array(
						'id' => '4e6686d7-c2f8-46de-ac3d-120c1b2c2a9b',
						'statusname' => 'Veröffentlicht',
						'key' => 'published',
						'rank' => 2
					)
				),
				array(
					'TourStatus' => array(
						'id' => '4e6686ea-fdb8-492a-8cd6-120c1b2c2a9b',
						'statusname' => 'Abgesagt',
						'key' => 'canceled',
						'rank' => 3
					)
				),
				array(
					'TourStatus' => array(
						'id' => '4e668740-e7d4-4cfe-8230-120c1b2c2a9b',
						'statusname' => 'Anmeldung geschlossen',
						'key' => 'registration_closed',
						'rank' => 4
					)
				),
				array(
					'TourStatus' => array(
						'id' => '4e6688e2-0084-4f23-9e29-120c1b2c2a9b',
						'statusname' => 'Durchgeführt',
						'key' => 'carried_out',
						'rank' => 5
					)
				),
			);
			$TourStatus->saveAll($tourStatuses);

			$Tour = $this->generateModel('Tour');
			$Tour->updateAll(array('tour_status_id' => "'4e6685af-eab4-4d32-b2f9-120c1b2c2a9b'"));
		}

		return true;
	}
}
?>