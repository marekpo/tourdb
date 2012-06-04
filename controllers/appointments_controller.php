<?php
class AppointmentsController extends AppController
{
	var $name = 'Appointments';

	var $components = array('RequestHandler');

	var $helpers = array('Widget', 'Display');

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('view');
	}
	/**
	 * @auth:requireRole(editor)
	 */
	function index()
	{
		$this->set(array(
			'appointments' => $this->paginate()
		));
	}

	/**
	 * @auth:requireRole(editor)
	 */
	function add()
	{
		if(!empty($this->data))
		{
			if($this->Appointment->save($this->data))
			{
				$this->Session->setFlash(__('Der Anlass wurde gespeichert.', true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	/**
	 * @auth:requireRole(editor)
	 */
	function edit($id)
	{
		if(!empty($this->data))
		{
			if($this->Appointment->save($this->data))
			{
				$this->Session->setFlash(__('Der Anlass wurde gespeichert.', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		else
		{
			$this->data = $this->Appointment->find('first', array(
				'conitions' => array('Appointment.id' => $id),
				'contain' => array()
			));
		}
	}

	/**
	 * @auth:allowed()
	 */
	function view($id)
	{
		$appointment = $this->Appointment->find('first', array(
			'conditions' => array('Appointment.id' => $id),
			'contain' => array()
		));

		if(empty($appointment))
		{
			$this->Session->setFlash(__('Der Anlass wurde nicht gefunden.', true));
			$this->redirect('/');
		}

		$this->set(compact('appointment'));
	}

	/**
	 * @auth:requireRole(editor)
	 */
	function delete($id)
	{
		if(!empty($this->data) && $this->data['Appointment']['confirm'])
		{
			if($this->Appointment->delete($id))
			{
				$this->Session->setFlash(__('Der Anlass wurde gelöscht.', true));
			}

			$this->redirect(array('action' => 'index'));
		}

		$this->data = $this->Appointment->find('first', array(
			'conditions' => array('Appointment.id' => $id),
			'contain' => array()
		));
	}
}