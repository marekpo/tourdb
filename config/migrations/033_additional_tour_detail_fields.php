<?php
class M4fc5463c8d384643acc423241b2c2a9b extends CakeMigration {

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
					'maps' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'deadline'),
					'timeframe' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'maps'),
					'meetingplace' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'timeframe'),
					'meetingtime' => array('type' => 'time', 'null' => false, 'default' => NULL, 'after' => 'meetingplace'),
					'transport' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'meetingtime'),
					'equipment' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'transport'),
					'food' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'equipment'),
					'auxiliarymaterial' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'food'),
					'travelcosts' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '5,2', 'after' => 'auxiliarymaterial'),
					'accomodationcosts' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '5,2', 'after' => 'travelcosts'),
					'accomodation' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'accomodationcosts'),
					'planneddeparture' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'accomodation'),
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'tours' => array(
					'maps', 'timeframe', 'meetingplace', 'meetingtime', 'transport', 'equipment', 'food', 'auxiliarymaterial', 'travelcosts', 'accomodationcosts', 'accomodation', 'planneddeparture'
				)
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
		return true;
	}
}
?>