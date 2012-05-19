<?php
class M4fb768bbc9c84bb4be5e1d101b2c2a9b extends CakeMigration {

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
				'tour_types' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'acronym')
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'tour_types' => array('key')
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
			$TourType = $this->generateModel('TourType');
			$tourTypeUpdates = array(
				array(
					'id' => '4dfe29a0-fe40-4433-a676-12201b2c2a9b', 
					'key' => 'alpine_tour'
				),
				array(
					'id' => '4e6680c6-0a2c-4893-8836-08f01b2c2a9b', 
					'key' => 'via_ferrata'
				),
				array(
					'id' => '4e6680c6-2e58-47a9-a961-08f01b2c2a9b', 
					'key' => 'snowshoe_tour'
				),
				array(
					'id' => '4e6680c6-3090-4dbd-becc-08f01b2c2a9b', 
					'key' => 'mountainbike_tour'
				),
				array(
					'id' => '4e6680c6-3964-48e7-ac6b-08f01b2c2a9b', 
					'key' => 'climbing_tour'
				),
				array(
					'id' => '4e6680c6-4600-45f3-80c6-08f01b2c2a9b', 
					'key' => 'hike'
				),
				array(
					'id' => '4e6680c6-8d10-45aa-935f-08f01b2c2a9b', 
					'key' => 'plaisir_tour'
				),
				array(
					'id' => '4e6680c6-9004-4c0b-9022-08f01b2c2a9b', 
					'key' => 'ski_tour'
				),
				array(
					'id' => '4e6680c6-9a74-4f04-b05f-08f01b2c2a9b', 
					'key' => 'langlauf'
				),
				array(
					'id' => '4e6680c6-9bf8-4da9-a532-08f01b2c2a9b', 
					'key' => 'course'
				),
				array(
					'id' => '4e6680c6-d4c8-4d69-a0b8-08f01b2c2a9b', 
					'key' => 'excursion'
				),
				array(
					'id' => '4e6680c6-f6cc-4ed4-a685-08f01b2c2a9b', 
					'key' => 'ice_climbing'
				)
			);

			$TourType->saveAll($tourTypeUpdates);
		}

		return true;
	}
}
?>