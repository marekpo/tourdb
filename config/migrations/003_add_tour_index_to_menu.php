<?php
class M4e42c4d6b6504f13b53616541b2c2a9b extends CakeMigration {

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
			if(!class_exists('Menu'))
			{
				App::import('Model', 'Menu');
			}
	
			$Menu = new Menu();
			$menuEntry = array(
				'Menu' => array(
					'id' => '4e42c672-e10c-4896-abe8-12241b2c2a9b',
					'caption' => 'Alle Touren',
					'controller' => 'tours',
					'action' => 'index',
					'protected' => '1'
				)
			);
			var_dump($Menu->save($menuEntry));
			var_dump($Menu->validationErrors);

			$Menu->id = '4e42c672-e10c-4896-abe8-12241b2c2a9b';
			$Menu->save(array(
				'parent_id' => '4e285def-8ae4-4cc1-8caa-088c1b2c2a9b'
			));
		}

		return true;
	}
}
?>