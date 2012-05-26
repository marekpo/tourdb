<?php
class M4fbf410ccfe04447a0071f241b2c2a9b extends CakeMigration {

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
				'tours' => array(
					'signuprequired' => array('type' => 'boolean', 'null' => false, 'default' => 1, 'after' => 'withmountainguide'),
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'tours' => array('signuprequired')
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
		return true;
	}
}
?>