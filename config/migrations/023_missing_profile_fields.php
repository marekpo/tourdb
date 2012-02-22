<?php
class M4f414238ace84cb583830dd41b2c2a9b extends CakeMigration {

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
				'profiles' => array(
					'publictransportsubscription' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'ski_tour_niveau_id'),
					'ownpassengercar' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'publictransportsubscription'),
					'freeseatsinpassengercar' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'ownpassengercar'),
					'ownsinglerope' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'freeseatsinpassengercar'),
					'lengthsinglerope' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'ownsinglerope'),
					'ownhalfrope' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'lengthsinglerope'),
					'lengthhalfrope' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'ownhalfrope'),
					'owntent' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'lengthhalfrope'),
					'additionalequipment' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'owntent'),
					'birthdate' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'additionalequipment'),
					'sex' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'birthdate'),
					'healthinformation' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'sex')
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'profiles' => array(
					'publictransportsubscription',  'ownpassengercar',  'freeseatsinpassengercar', 
					'ownsinglerope',  'lengthsinglerope',  'ownhalfrope',  'lengthhalfrope', 
					'owntent',  'additionalequipment',  'birthdate',  'sex',  'healthinformation'
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