<?php
class Role extends AppModel
{
	var $name = 'Role';

	var $displayField = 'rolename';

	var $hasAndBelongsToMany = array('User', 'Privilege');

	function init()
	{
		$roles = array(
			'Systemadmin',
			'Administrator Sektion',
			'Tourenchef',
			'Tourenleiter',
			'Redakteur',
			'SAC-Mitglied',
			'Benutzer',
		);

		$this->deleteAll(array('1' => '1'));

		foreach($roles as $rank => $role)
		{
			$this->create();
			$this->save(array(
				'Role' => array(
					'rolename' => $role,
					'rank' => $rank
				)
			));
		}
	}
}