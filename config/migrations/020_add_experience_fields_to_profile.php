<?php
class M4ec6a6981dc445fcb6d60bb81b2c2a9b extends CakeMigration {

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
					'experience_rope_guide' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'emergencycontact2_email'),
					'experience_knot_technique' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'experience_rope_guide'),
					'experience_rope_handling' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'experience_knot_technique'),
					'experience_avalanche_training' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'experience_rope_handling'),
					'lead_climb_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'experience_avalanche_training'),
					'second_climb_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'lead_climb_niveau_id'),
					'alpine_tour_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'second_climb_niveau_id'),
					'ski_tour_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'alpine_tour_niveau_id'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'profiles' => array('experience_rope_guide', 'experience_knot_technique', 'experience_rope_handling', 'experience_avalanche_training', 'lead_climb_niveau_id', 'second_climb_niveau_id', 'alpine_tour_niveau_id', 'ski_tour_niveau_id',),
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
		return true;
	}
}
?>