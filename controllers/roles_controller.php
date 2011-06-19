<?php
class RolesController extends AppController
{
	var $name = 'Roles';

	var $helpers = array('Js');

	var $scaffold;

	function initRoles()
	{
		$this->Role->init();
		die;
	}

	function index()
	{
		$this->set(array(
			'roles' => $this->Role->find('all', array(
				'order' => array('Role.rank' => 'ASC'),
				'contain' => array()
			))
		));
	}

	function edit($id)
	{
		if(!empty($this->data))
		{
			
		}
		else
		{
			$this->data = $this->Role->find('first', array(
				'conditions' => array('Role.id' => $id)
			));
		}

		
	}
}