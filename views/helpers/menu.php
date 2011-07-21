<?php
class MenuHelper extends AppHelper
{
	var $helpers = array('Html', 'Session');

	function renderMenu()
	{
		App::import('Model', 'Menu');
		$Menu = new Menu();
		$menu = $Menu->find('threaded');

		$privileges = $this->Session->read('Privileges');

		$renderedMenu = '';

		foreach($menu as $menuEntry)
		{
			$childMenuItems = '';

			foreach($menuEntry['children'] as $child)
			{
				$allowedAction = false;

				if($child['Menu']['protected'] == 0)
				{
					$allowedAction = true;
				}
				elseif($child['Menu']['protected'] == 1 && !empty($privileges))
				{
					foreach($privileges as $privilege)
					{
						list($privilegeController, $privilegeAction) = explode(':', $privilege['Privilege']['key']);
			
						if($privilegeController == $child['Menu']['controller']
							&& ($privilegeAction == $child['Menu']['action'] || $privilegeAction == '*'))
						{
							$allowedAction = true;
							break;
						}
					}
				}

				if($allowedAction)
				{
					$childMenuItems .= $this->Html->tag('li', $this->Html->link(
						$child['Menu']['caption'], array(
							'controller' => $child['Menu']['controller'],
							'action' => $child['Menu']['action']
						)
					));
				}
			}

			if(!empty($childMenuItems))
			{
				$renderedMenu .= $this->Html->tag('li',
					$this->Html->tag('span', $menuEntry['Menu']['caption'], array('class' => 'caption'))
					. $this->Html->tag('ul', $childMenuItems)
				);
			}
		}

		return $this->Html->tag('ul', $renderedMenu, array('class' => 'menu'));
	}
}