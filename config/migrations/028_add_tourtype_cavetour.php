<?php
class M4fb787029e144a3096e923581b2c2a9b extends CakeMigration {

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
		),
		'down' => array(
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
		$TourType = $this->generateModel('TourType');
		$tourTypeCaveTourId = '4fb78b42-6f40-46fc-b2d0-238c1b2c2a9b';

		if($direction == 'up')
		{
			$tourTypeCaveTour = array(
				'TourType' => array(
					'id' => $tourTypeCaveTourId,
					'title' => 'Höhlentour',
					'acronym' => 'HOL',
					'key' => 'cave_tour'
				)
			);

			$TourType->save($tourTypeCaveTour);
		}

		if($direction == 'down')
		{
			$TourType->delete($tourTypeCaveTourId);
		}

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