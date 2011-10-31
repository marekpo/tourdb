<?php
class M4eaef5c2588046c997fc0e001b2c2a9b extends CakeMigration {

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
			if($direction == 'up')
		{
			$Menu = $this->generateModel('Menu');
			$newMenuEntry = array(
				'Menu' => array(
					'id' => '4eaef5fd-26f0-4053-bf75-12d01b2c2a9b',
					'separator' => 0,
					'caption' => 'Meine Tourenanmeldungen',
					'controller' => 'tour_participations',
					'action' => 'listMine',
					'protected' => 1,
					'rank' => 11
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 1'), array('rank >=' => 11));
			$Menu->save($newMenuEntry);

			$Privilege = $this->generateModel('Privilege');
			$newPrivilege = array(
				'Privilege' => array(
					'id' => '4eaef76a-a5d0-4a9a-ac05-12d01b2c2a9b',
					'key' => 'tour_participations:listMine',
					'label' => 'Tourenanmeldungen: Eigene auflisten'
				)
			);

			$Privilege->save($newPrivilege);
		}

		if($direction == 'down')
		{
			$Menu = $this->generateModel('Menu');
			$Menu->delete('4eaef5fd-26f0-4053-bf75-12d01b2c2a9b');
			$Menu->updateAll(array('rank' => 'rank - 1'), array('rank >' => 11));

			$Privilege = $this->generateModel('Privilege');
			$Privilege->delete('4eaef76a-a5d0-4a9a-ac05-12d01b2c2a9b');
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