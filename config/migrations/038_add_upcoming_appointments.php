<?php
class M50234f26cd3042e2b1f50b181b2c2a9b extends CakeMigration {

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
		$menuUpcomingAppointmentsId = '50234ffc-e600-4153-bfda-18c01b2c2a9b';
		$menuUpcomingAppointmentsRank = 3;

		if($direction == 'up')
		{
			$upcomingAppointmentsMenuEntry = array(
				'Menu' => array(
					'id' => $menuUpcomingAppointmentsId,
					'separator' => 0,
					'caption' => 'Aktuelle Anlässe',
					'controller' => 'appointments',
					'action' => 'upcomingAppointments',
					'protected' => 0,
					'rank' => $menuUpcomingAppointmentsRank
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 1'), array('rank >=' => $menuUpcomingAppointmentsRank));
			$Menu->save($upcomingAppointmentsMenuEntry);
		}

		if($direction == 'down')
		{
			$Menu->delete($menuUpcomingAppointmentsId);
			$Menu->updateAll(array('rank' => 'rank - 1'), array('rank >' => $menuUpcomingAppointmentsRank));
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