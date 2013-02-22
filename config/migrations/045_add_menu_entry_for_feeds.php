<?php
class M51179e7406a4483eb429235c1b2c2a9b extends CakeMigration {

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
				'menus' => array(
					'parameters' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'action')
				)
			)
		),
		'down' => array(
			'drop_field' => array(
				'menus' => array('parameters')
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
		$Menu = $this->generateModel('Menu');
		$menuFeedsId = 'c64cbcdf-d9cf-4789-92ea-d9b611a57fef';
		$menuFeedsRank = 4;

		if($direction == 'up')
		{
			$menuFeeds = array(
				'Menu' => array(
					'id' => $menuFeedsId,
					'separator' => 0,
					'caption' => 'Rss Feeds',
					'controller' => 'pages',
					'action' => 'display',
					'parameters' => 'feeds',
					'protected' => 0,
					'rank' => $menuFeedsRank
				)
			);

			$Menu->updateAll(array('rank' => 'rank + 1'), array('rank >=' => $menuFeedsRank));
			$Menu->save($menuFeeds);
		}

		if($direction == 'down')
		{
			$Menu->delete($menuFeedsId);
			$Menu->updateAll(array('rank' => 'rank - 1'), array('rank >' => $menuFeedsRank));
		}

		return true;
	}
}
?>