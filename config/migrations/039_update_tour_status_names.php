<?php
class M5052403ee05c45ca85a018b01b2c2a9b extends CakeMigration {

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
	public function before($direction) {
		$TourStatus = $this->generateModel('TourStatus');
		$TourStatusFixedId = '4e6a6af8-1334-4252-819f-13f41b2c2a9b';
		$TourStatusPublishedId = '4e6686d7-c2f8-46de-ac3d-120c1b2c2a9b';
		
		if($direction == 'up')
		{
			$TourStatus->updateAll(array('statusname' => "'Warten'"), array('id =' => $TourStatusFixedId));
			$TourStatus->updateAll(array('statusname' => "'Anmeldung'"), array('id =' => $TourStatusPublishedId));
			
		}
		
		if($direction == 'down')
		{
			$TourStatus->updateAll(array('statusname' => "'Fixiert'"), array('id =' => $TourStatusFixedId));
			$TourStatus->updateAll(array('statusname' => "'Veröffentlicht'"), array('id =' => $TourStatusPublishedId));
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