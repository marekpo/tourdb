<?php
class RolesController extends AppController
{
	var $name = 'Roles';

	var $helpers = array('Widget', 'Js');

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
			$this->Role->save($this->data);
			$this->Session->setFlash(__('Gespeichert', true));
			$this->redirect(array('action' => 'index'));
		}
		else
		{
			$this->data = $this->Role->find('first', array(
				'conditions' => array('Role.id' => $id),
			));
		}

		$this->set(array(
			'privileges' => $this->Role->Privilege->find('list')
		));
	}
}