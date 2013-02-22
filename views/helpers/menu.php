<?php
class MenuHelper extends AppHelper
{
	var $helpers = array('Html', 'Session', 'Authorization');

	function renderMenu()
	{
		App::import('Model', 'Menu');
		$Menu = new Menu();
		$allMenuEntries = $Menu->find('all', array(
			'order' => array('rank' => 'ASC')
		));

		$loggedIn = $this->Session->check('Auth.User');

		$menuEntries = array();
		$insertSeparator = false;

		foreach($allMenuEntries as $menuEntry)
		{
			$menuLink = false;

			$url = array(
				'controller' => $menuEntry['Menu']['controller'],
				'action' => $menuEntry['Menu']['action']
			);

			if(!empty($menuEntry['Menu']['parameters']))
			{
				$url = array_merge($url, explode(';', $menuEntry['Menu']['parameters']));
			}

			if(!$menuEntry['Menu']['protected'] || $menuEntry['Menu']['separator'])
			{
				$menuLink = $this->Html->link($menuEntry['Menu']['caption'], $url);
			}
			elseif($menuEntry['Menu']['protected'] && $loggedIn)
			{
				$menuLink = $this->Authorization->link($menuEntry['Menu']['caption'], $url);
			}

			if($menuLink)
			{
				if($menuEntry['Menu']['separator'])
				{
					$insertSeparator = true;
				}
				else
				{
					if($insertSeparator)
					{
						$insertSeparator = false;
						$menuEntries[] = $this->Html->tag('li', $this->Html->tag('hr', ''));
					}

					$menuEntries[] = $this->Html->tag('li', $menuLink);
				}
			}
		}

		return $this->Html->tag('ul', implode("\n", $menuEntries), array('class' => 'menu'));
	}
}