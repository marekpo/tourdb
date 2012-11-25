<?php
class M50b1eff42fb04a38bb9813a41b2c2a9b extends CakeMigration {

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
		$Menu = $this->generateModel('Menu');
		$menuexportStatisticsToursOverviewId = '2b7f3d6c-3646-11e2-8220-8321191a3ad6';
		$menuexportStatisticsToursOverviewRank = 10;

		if($direction == 'up')
		{
			$menuexportStatisticsToursOverview = array(
				'Menu' => array(
					'id' => $menuexportStatisticsToursOverviewId,
					'separator' => 0,
					'caption' => 'Statistik Tourenübersicht',
					'controller' => 'tours',
					'action' => 'exportStatisticsToursOverview',
					'protected' => 1,
					'rank' => $menuexportStatisticsToursOverviewRank
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 1'), array('rank >=' => $menuexportStatisticsToursOverviewRank));
			$Menu->save($menuexportStatisticsToursOverview);
		}

		if($direction == 'down')
		{
			$Menu->delete($menuexportStatisticsToursOverviewId);
			$Menu->updateAll(array('rank' => 'rank - 1'), array('rank >' => $menuexportStatisticsToursOverviewRank));
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