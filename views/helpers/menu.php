<?php
class MenuHelper extends AppHelper
{
	var $helpers = array('Html', 'Session');

	function renderMenu()
	{
		App::import('Model', 'Menu');
		$Menu = new Menu();
		$allMenuEntries = $Menu->find('all', array(
			'order' => array('rank' => 'ASC')
		));

		$privileges = $this->Session->read('Auth.Privileges');

		$menuEntries = array();
		$insertSeparator = false;

		foreach($allMenuEntries as $menuEntry)
		{
			$allowedAction = false;

			if(!$menuEntry['Menu']['protected'] || $menuEntry['Menu']['separator'])
			{
				$allowedAction = true;
			}
			elseif($menuEntry['Menu']['protected'] && !empty($privileges))
			{
				foreach($privileges as $privilege)
				{
					list($privilegeController, $privilegeAction) = explode(':', $privilege['Privilege']['key']);
		
					if($privilegeController == $menuEntry['Menu']['controller']
						&& ($privilegeAction == $menuEntry['Menu']['action'] || $privilegeAction == '*'))
					{
						$allowedAction = true;
						break;
					}
				}
			}

			if($allowedAction)
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

					$menuEntries[] = $this->Html->tag('li', $this->Html->link(
						$menuEntry['Menu']['caption'], array(
							'controller' => $menuEntry['Menu']['controller'],
							'action' => $menuEntry['Menu']['action']
						)
					));
				}
			}
		}

		return $this->Html->tag('ul', implode("\n", $menuEntries), array('class' => 'menu'));
	}
}