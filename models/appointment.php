<?php
class Appointment extends AppModel
{
	var $name = 'Appointment';

	var $actsAs = array('Calendar');

	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'location' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'startdate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'correctDateRange' => array(
				'rule' => array('dateBetween', 'today', '+2 years')
			),
		),
		'enddate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'last' => true
			),
			'correctDateRange' => array(
				'rule' => array('dateBetween', 'today', '+2 years'),
				'last' => true
			),
			'greaterOrEqualStartDate' => array(
				'rule' => array('compareToDateField', '>=', 'startdate')
			)
		),
	);

	function beforeSave($options = array())
	{
		if(isset($this->data['Appointment']['startdate']))
		{
			$this->data['Appointment']['startdate'] = date('Y-m-d H:i:s', strtotime($this->data['Appointment']['startdate']));
		}

		if(isset($this->data['Appointment']['enddate']))
		{
			$this->data['Appointment']['enddate'] = date('Y-m-d H:i:s', strtotime($this->data['Appointment']['enddate']));
		}

		return true;
	}
}