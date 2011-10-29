<?php
class M4ea09da0da184b50bc6407181b2c2a9b extends CakeMigration {

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
				'countries' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'isocode2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'isocode3' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tour_participation_statuses' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'statusname' => array('type' => 'string', 'null' => 'false', 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'key' => array('type' => 'string', 'null' => 'false', 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'rank' => array('type' => 'integer', 'null' => 'false', 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				)
			),
			'create_field' => array(
				'profiles' => array(
					'street' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'lastname'),
					'housenumber' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'street'),
					'extraaddressline' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'housenumber'),
					'zip' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'extraaddressline'),
					'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'zip'),
					'country_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'city'),
					'phoneprivate' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'country_id'),
					'phonebusiness' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'phoneprivate'),
					'cellphone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'phonebusiness'),
					'emergencycontact1_address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'cellphone'),
					'emergencycontact1_phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact1_address'),
					'emergencycontact1_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact1_phone'),
					'emergencycontact2_address' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact1_email'),
					'emergencycontact2_phone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 24, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact2_address'),
					'emergencycontact2_email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'emergencycontact2_phone')
				),
				'tour_participations' => array(
					'tour_participation_status_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'tour_participant_id')
				)
			),
			'rename_field' => array(
				'tour_participations' => array(
					'tour_participant_id' => 'user_id'
				)
			)
		),
		'down' => array(
			'drop_table' => array(
				'countries'
			),
			'drop_field' => array(
				'profiles' => array(
					'street', 'housenumber', 'extraaddressline', 'zip', 'city',
					'country_id', 'phoneprivate', 'phonebusiness', 'cellphone',
					'emergencycontact1_address', 'emergencycontact1_phone', 'emergencycontact1_email',
					'emergencycontact2_address', 'emergencycontact2_phone', 'emergencycontact2_email'
				)
			),
			'rename_field' => array(
				'tour_participations' => array(
					'user_id' => array('name' => 'tour_participant_id')
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
		if($direction == 'up')
		{
			$Privilege = $this->generateModel('Privilege');
			$privilege = array(
				'Privilege' => array(
					'id' => '4ea85fd3-3420-4955-a6a2-11e01b2c2a9b',
					'key' => 'tours:signUp',
					'label' => 'Touren: Anmelden'
				)
			);

			$Privilege->save($privilege);

			$Country = $this->generateModel('Country');
			$countries = array(
				array(
					'Country' => array(
						'id' => '4ea87007-a80c-42f4-85a1-11e01b2c2a9b',
						'name' => 'Schweiz',
						'isocode2' => 'CH',
						'isocode3' => 'CHE'
					)
				),
				array(
					'Country' => array(
						'id' => '4ea87037-4a40-4643-b58a-11e01b2c2a9b',
						'name' => 'Deutschland',
						'isocode2' => 'DE',
						'isocode3' => 'DEU'
					)
				),
				array(
					'Country' => array(
						'id' => '4ea87058-0e00-4261-b95e-11e01b2c2a9b',
						'name' => 'Frankreich',
						'isocode2' => 'FR',
						'isocode3' => 'FRA'
					)
				),
				array(
					'Country' => array(
						'id' => '4ea87075-3704-412b-852f-11e01b2c2a9b',
						'name' => 'Italien',
						'isocode2' => 'IT',
						'isocode3' => 'ITA'
					)
				)
			);

			$Country->saveAll($countries);

			$TourParticipationStatus = $this->generateModel('TourParticipationStatus');
			$tourParticipationStatuses = array(
				array(
					'TourParticipationStatus' => array(
						'id' => '4eac501c-92b0-4a21-96db-0ac41b2c2a9b',
						'statusname' => 'Angemeldet',
						'key' => 'registered',
						'rank' => 1
					),
				),
				array(
					'TourParticipationStatus' => array(
						'id' => '4eac5025-074c-4c1f-8eca-0ac41b2c2a9b',
						'statusname' => 'Bestätigt',
						'key' => 'affirmed',
						'rank' => 2
					),
				),
				array(
					'TourParticipationStatus' => array(
						'id' => '4eac502b-256c-4381-8cb7-0ac41b2c2a9b',
						'statusname' => 'Warteliste',
						'key' => 'waitinglist',
						'rank' => 3
					),
				),
				array(
					'TourParticipationStatus' => array(
						'id' => '4eac502f-ac6c-4c14-8cb5-0ac41b2c2a9b',
						'statusname' => 'Storniert',
						'key' => 'canceled',
						'rank' => 4
					),
				),
				array(
					'TourParticipationStatus' => array(
						'id' => '4eac5036-45a4-4ebd-a597-0ac41b2c2a9b',
						'statusname' => 'Abgelehnt',
						'key' => 'rejected',
						'rank' => 5
					)
				)
			);

			$TourParticipationStatus->saveAll($tourParticipationStatuses);
		}

		if($direction == 'down')
		{
			$Privilege = $this->generateModel('Privilege');
			$Privilege->delete('4ea85fd3-3420-4955-a6a2-11e01b2c2a9b');
		}

		return true;
	}
}
?>