<?php
class M50483ec8fd5c47afbe4b0f201b2c2a9b extends CakeMigration {

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
				'tour_participations' => array(
					'signup_user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'user_id'),
					'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'tour_participation_status_id'),
					'firstname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'email'),
					'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'firstname'),
					'street' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'lastname'),
					'housenumber' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'street'),
					'extraaddressline' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'housenumber'),
					'zip' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'extraaddressline'),
					'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'zip'),
					'country_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'city'),
					'phoneprivate' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'country_id'),
					'phonebusiness' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'phoneprivate'),
					'cellphone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'phonebusiness'),
					'emergencycontact1_address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'cellphone'),
					'emergencycontact1_phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact1_address'),
					'emergencycontact1_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact1_phone'),
					'emergencycontact2_address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact1_email'),
					'emergencycontact2_phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact2_address'),
					'emergencycontact2_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact2_phone'),
					'sac_member' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'emergencycontact2_email'),
					'sac_membership_number' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_member'),
					'sac_main_section_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_membership_number'),
					'sac_additional_section1_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_main_section_id'),
					'sac_additional_section2_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_additional_section1_id'),
					'sac_additional_section3_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'sac_additional_section2_id'),
					'experience_rope_guide' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'sac_additional_section3_id'),
					'experience_knot_technique' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'experience_rope_guide'),
					'experience_rope_handling' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'experience_knot_technique'),
					'experience_avalanche_training' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'after' => 'experience_rope_handling'),
					'lead_climb_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'experience_avalanche_training'),
					'second_climb_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'lead_climb_niveau_id'),
					'alpine_tour_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'second_climb_niveau_id'),
					'ski_tour_niveau_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'alpine_tour_niveau_id')
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'tour_participations' => array(
					'signup_user_id', 'email', 'firstname', 'lastname', 'street', 'housenumber',
					'extraaddressline', 'zip', 'city', 'country_id', 'phoneprivate', 'phonebusiness', 'cellphone',
					'emergencycontact1_address', 'emergencycontact1_phone', 'emergencycontact1_email',
					'emergencycontact2_address', 'emergencycontact2_phone', 'emergencycontact2_email',
					'sac_member', 'sac_membership_number', 'sac_main_section_id', 'sac_additional_section1_id',
					'sac_additional_section2_id', 'sac_additional_section3_id', 'experience_rope_guide',
					'experience_knot_technique', 'experience_rope_handling', 'experience_avalanche_training',
					'lead_climb_niveau_id', 'second_climb_niveau_id', 'alpine_tour_niveau_id', 'ski_tour_niveau_id'
				)
			)
		)
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
			$TourParticipation = $this->generateModel('TourParticipation');
			$User = $this->generateModel('User');
			$Profile = $this->generateModel('Profile');

			$tourParticipations = $TourParticipation->find('all');

			foreach($tourParticipations as $tourParticipation)
			{
				$userId = $tourParticipation['TourParticipation']['user_id'];
				$user = $User->findById($userId);
				$profile = $Profile->findByUserId($userId);

				$tourParticipation['TourParticipation'] = array_merge($tourParticipation['TourParticipation'], array(
					'signup_user_id' => $userId,
					'email' => $user['User']['email'],
					'firstname' => $profile['Profile']['firstname'],
					'lastname' => $profile['Profile']['lastname'],
					'street' => $profile['Profile']['street'],
					'housenumber' => $profile['Profile']['housenumber'],
					'extraaddressline' => $profile['Profile']['extraaddressline'],
					'zip' => $profile['Profile']['zip'],
					'city' => $profile['Profile']['city'],
					'country_id' => $profile['Profile']['country_id'],
					'phoneprivate' => $profile['Profile']['phoneprivate'],
					'phonebusiness' => $profile['Profile']['phonebusiness'],
					'cellphone' => $profile['Profile']['cellphone'],
					'emergencycontact1_address' => $profile['Profile']['emergencycontact1_address'],
					'emergencycontact1_phone' => $profile['Profile']['emergencycontact1_phone'],
					'emergencycontact1_email' => $profile['Profile']['emergencycontact1_email'],
					'emergencycontact2_address' => $profile['Profile']['emergencycontact2_address'],
					'emergencycontact2_phone' => $profile['Profile']['emergencycontact2_phone'],
					'emergencycontact2_email' => $profile['Profile']['emergencycontact2_email'],
					'sac_member' => $profile['Profile']['sac_member'],
					'sac_membership_number' => $profile['Profile']['sac_membership_number'],
					'sac_main_section_id' => $profile['Profile']['sac_main_section_id'],
					'sac_additional_section1_id' => $profile['Profile']['sac_additional_section1_id'],
					'sac_additional_section2_id' => $profile['Profile']['sac_additional_section2_id'],
					'sac_additional_section3_id' => $profile['Profile']['sac_additional_section3_id'],
					'experience_rope_guide' => $profile['Profile']['experience_rope_guide'],
					'experience_knot_technique' => $profile['Profile']['experience_knot_technique'],
					'experience_rope_handling' => $profile['Profile']['experience_rope_handling'],
					'experience_avalanche_training' => $profile['Profile']['experience_avalanche_training'],
					'lead_climb_niveau_id' => $profile['Profile']['lead_climb_niveau_id'],
					'second_climb_niveau_id' => $profile['Profile']['second_climb_niveau_id'],
					'alpine_tour_niveau_id' => $profile['Profile']['alpine_tour_niveau_id'],
					'ski_tour_niveau_id' => $profile['Profile']['ski_tour_niveau_id']
				));

				$TourParticipation->save($tourParticipation);
			}
		}

		return true;
	}
}
?>