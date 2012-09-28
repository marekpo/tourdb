<?php
class M50659d828130409d8af31be41b2c2a9b extends CakeMigration {

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
				'sac_members' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'sac_membership_number' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'sac_membership_number_family' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'sac_section_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'firstname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'extraaddressline' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'addressline' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'pobox' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'zip' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'city' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'country_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'birthdate' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'phonebusiness' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'phoneprivate' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'phoneinternal' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'cellphone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'fax' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'sex' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'job' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'language' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'membership_since' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 4),
					'beneficiary_section' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
					'honorary_member' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
					'category_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'info1' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'info2' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'info3' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'notice' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'balance' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '5,2'),
					'member_status' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'quantity_magazine' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'quantity_bulletin' => array('type' => 'integer', 'null' => true, 'default' => NULL),
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
				'sac_members'
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
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
?>