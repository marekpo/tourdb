<?php
class M4fd4e0f6e33448a29a0b18d81b2c2a9b extends CakeMigration {

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
		$Menu = $this->generateModel('Menu');
		$menulistToursWithoutReportId = '2fdc91f3-b397-11e1-87b7-add00ac1a90b';
		$menulistToursWithoutReportRank = 8;

		if($direction == 'up')
		{
			$menulistToursWithoutReport = array(
				'Menu' => array(
					'id' => $menulistToursWithoutReportId,
					'separator' => 0,
					'caption' => 'Touren ohne Tourenrapport',
					'controller' => 'tours',
					'action' => 'listToursWithoutReport',
					'protected' => 1,
					'rank' => $menulistToursWithoutReportRank
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 1'), array('rank >=' => $menulistToursWithoutReportRank));
			$Menu->save($menulistToursWithoutReport);
		}

		if($direction == 'down')
		{
			$Menu->delete($menulistToursWithoutReportId);
			$Menu->updateAll(array('rank' => 'rank - 1'), array('rank >' => $menulistToursWithoutReportRank));
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