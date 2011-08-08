<?php
class M4e402452ce1844988b9003d41b2c2a9b extends CakeMigration {

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
				'roles' => array(
					'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'rolename'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'roles' => array('key',),
			),
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
		if($direction == 'up')
		{
			$Role = $this->generateModel('Role');
			$roles = array(
				array(
					'id' => '4dcafc83-fe44-4643-9b20-08b41b2c2a9b',
					'key' => 'systemadmin',
				),
				array(
					'id' => '4dcafc83-8c90-4205-bcfd-08b41b2c2a9b',
					'key' => 'sectionadmin',
				),
				array(
					'id' => '4dcafc83-23a4-446c-b974-08b41b2c2a9b',
					'key' => 'tourchief',
				),
				array(
					'id' => '4dcafc83-fd30-4786-a214-08b41b2c2a9b',
					'key' => 'tourleader',
				),
				array(
					'id' => '4dcafc83-73a8-496a-9fe1-08b41b2c2a9b',
					'key' => 'editor',
				),
				array(
					'id' => '4dcafc83-39d0-4030-b602-08b41b2c2a9b',
					'key' => 'sacmember',
				),
				array(
					'id' => '4dcafc83-8744-4e1c-983f-08b41b2c2a9b',
					'key' => 'user',
				),
			);
			$Role->saveAll($roles);
		}

		return true;
	}
}
?>