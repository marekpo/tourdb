<?php
class M4e7345863dd04a90b9fb156c1b2c2a9b extends CakeMigration {

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
			$Privilege = $this->generateModel('Privilege');
			$privileges = array(
				array(
					'id' => '4e74c391-307c-49d5-8e57-118c1b2c2a9b',
					'key' => 'tours:closeRegistration',
					'label' => 'Touren: Anmeldung schliessen'
				),
				array(
					'id' => '4e74c39c-12ac-46a2-8c3c-118c1b2c2a9b',
					'key' => 'tours:cancel',
					'label' => 'Touren: Absagen'
				),
				array(
					'id' => '4e74c3a4-b60c-46fb-b3e3-118c1b2c2a9b',
					'key' => 'tours:carriedOut',
					'label' => 'Touren: Als Durchgeführt markieren'
				)
			);
			$Privilege->saveAll($privileges);
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