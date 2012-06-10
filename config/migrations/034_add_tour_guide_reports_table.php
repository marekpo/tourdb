<?php
class M4fcb5dd082b049d0a63717141b2c2a9b extends CakeMigration {

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
				'tour_guide_reports' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'tour_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'substitute_tour' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'expenses_organsiation' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'expenses_transport' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'expenses_accommodation' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'expenses_others1' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'expenses_others2' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'driven_km' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5),
					'paid_tourguide' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'paid_donation' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'paid_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
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
				'tour_guide_reports'
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
		$TourStatus = $this->generateModel('TourStatus');
		$newTourStatusId = 'dec21bcd-930e-11e1-ab93-40bdf79c26ea';

		if($direction == 'up')
		{
			$tourStatuses = array(
				'TourStatus' => array(
					'id' => $newTourStatusId,
					'statusname' => 'Nicht durchgeführt',
					'key' => 'not_carried_out',
					'rank' => 6
				)
			);

			$TourStatus->save($tourStatuses);
		}

		if($direction == 'down')
		{
			$TourStatus->delete($newTourStatusId);
		}

		return true;
	}
}
?>