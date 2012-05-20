<?php
class M4fb78e7e184843f7b9da0d9c1b2c2a9b extends CakeMigration {

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
		$menuTourCalendarId = '4fb79152-007c-42ec-a22f-238c1b2c2a9b';
		$menuTourCalendarRank = 2;

		if($direction == 'up')
		{
			$menuTourCalendar = array(
				'Menu' => array(
					'id' => $menuTourCalendarId,
					'separator' => 0,
					'caption' => 'Tourenkalender',
					'controller' => 'tours',
					'action' => 'calendar',
					'protected' => 0,
					'rank' => $menuTourCalendarRank
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 1'), array('rank >=' => $menuTourCalendarRank));
			$Menu->save($menuTourCalendar);
		}

		if($direction == 'down')
		{
			$Menu->delete($menuTourCalendarId);
			$Menu->updateAll(array('rank' => 'rank - 1'), array('rank >' => $menuTourCalendarRank));
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