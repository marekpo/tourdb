<?php
class AppointmentsController extends AppController
{
	var $name = 'Appointments';

	var $components = array('RequestHandler');

	var $helpers = array('Widget', 'Display', 'Excel');

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('view', 'upcomingAppointments');
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
				'conditions' => array('Appointment.id' => $id),
				'contain' => array()
			));
		}

		$this->data['Appointment']['startdate'] = date('d.m.Y H:i', strtotime($this->data['Appointment']['startdate']));
		$this->data['Appointment']['enddate'] = date('d.m.Y H:i', strtotime($this->data['Appointment']['enddate']));
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
			$redirect = array('action' => 'index');

			if(isset($this->data['Appointment']['cancel']) && $this->data['Appointment']['cancel'])
			{
				$this->redirect($redirect);
			}

			if(!$this->Appointment->delete($id))
			{
				$this->Session->setFlash(__('Der Anlass konnte nicht gelöscht werden.', true));
			}

			$this->Session->setFlash(__('Der Anlass wurde gelöscht.', true));
			$this->redirect($redirect);
		}

		$this->data = $this->Appointment->find('first', array(
			'conditions' => array('Appointment.id' => $id),
			'contain' => array()
		));
	}

	/**
	 * @auth:requireRole(editor)
	 */
	function export()
	{
		if(!empty($this->data))
		{
			$valid = true;

			if(!isset($this->data['Appointment']['startdate']) || empty($this->data['Appointment']['startdate']) || strtotime($this->data['Appointment']['startdate']) === false)
			{
				$this->Appointment->invalidate('startdate', 'correctDate');
				$valid = false;
			}

			if(!isset($this->data['Appointment']['enddate']) || empty($this->data['Appointment']['enddate']) || strtotime($this->data['Appointment']['enddate']) === false)
			{
				$this->Appointment->invalidate('enddate', 'correctDate');
				$valid = false;
			}

			if($valid && strtotime($this->data['Appointment']['startdate']) > strtotime($this->data['Appointment']['enddate']))
			{
				$this->Appointment->invalidate('enddate', 'greaterOrEqualStartDate');
				$valid = false;
			}

			if($valid)
			{
				$dateRangeStart = date('Y-m-d', strtotime($this->data['Appointment']['startdate']));
				$dateRangeEnd = date('Y-m-d', strtotime($this->data['Appointment']['enddate']));

				$appointments = $this->Appointment->find('all', array(
					'conditions' => array(
						'startdate >=' => $dateRangeStart,
						'startdate <=' => $dateRangeEnd
					),
					'order' => array('Appointment.startdate' => 'ASC'),
					'contain' => array()
				));

				if(empty($appointments))
				{
					$this->Session->setFlash(__('Für die angegebenen Kriterien wurden keine Anlässe gefunden', true));
				}
				else
				{
					$this->viewPath = Inflector::underscore($this->name) . DS . 'xls';
					$this->set(compact('appointments'));
				}
			}
		}
	}

	/**
	 * @auth:allowed()
	 */
	function upcomingAppointments()
	{
		$appointments = $this->Appointment->find('all', array(
			'conditions' => array('DATE(Appointment.startdate) >=' => date('Y-m-d')),
			'order' => array('Appointment.startdate' => 'ASC'),
			'contain' => array()
		));

		$this->set(compact('appointments'));
	}
}