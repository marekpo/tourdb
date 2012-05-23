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
			$acronymKeys = array(
				'H' => 'alpine_tour',
				'KS' => 'via_ferrata',
				'SS' => 'snowshoe_tour',
				'MTB' => 'mountainbike_tour',
				'K' => 'climbing_tour',
				'W' => 'hike',
				'P' => 'plaisir_tour',
				'S' => 'ski_tour',
				'LL' => 'cross_country',
				'Kurs' => 'training_course',
				'Exk' => 'excursion',
				'E' => 'ice_climbing'
			);

			$TourType = $this->generateModel('TourType');

			foreach($acronymKeys as $acronym => $key)
			{
				$tourType = $TourType->find('first', array(
					'conditions' => array('TourType.acronym' => $acronym)
				));

				$tourType['TourType']['key'] = $key;

				$TourType->save($tourType);
			}
		}

		return true;
	}
}
?>