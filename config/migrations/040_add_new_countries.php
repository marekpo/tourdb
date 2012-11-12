<?php
class M506553e6c86c4195919715fc1b2c2a9b extends CakeMigration {

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

		$countryAtId = '23cd9984-0940-11e2-877e-a222c574f56e';
		$countryLuId = 'bf7d8e94-0940-11e2-877e-a222c574f56e';
		$countryLiId = 'd28a04c7-0940-11e2-877e-a222c574f56e';
		
		$Country = $this->generateModel('Country');

		if($direction == 'up')
		{
			
			$newCountries = array(
				array(
					'Country' => array(
						'id' => $countryAtId,
						'name' => 'Österrreich',
						'isocode2' => 'AT',
						'isocode3' => 'AUT'
					)
				),
				array(
					'Country' => array(
						'id' => $countryLuId,
						'name' => 'Luxemburg',
						'isocode2' => 'LU',
						'isocode3' => 'LUX'
					)
				),
				array(
					'Country' => array(
						'id' => $countryLiId,
						'name' => 'Liechtenstein',
						'isocode2' => 'LI',
						'isocode3' => 'LIE'
					)
				),
			);
			$Country->saveAll($newCountries);
		}

		if($direction == 'down')
		{
			$Country->delete($countryAtId);
			$Country->delete($countryLuId);
			$Country->delete($countryLiId);
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
	public function after($direction) {
		return true;
	}
}
?>