<?php
class Appointment extends AppModel
{
	var $name = 'Appointment';

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
		'startdate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'enddate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
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
			$this->data['Appointment']['startdate'] = date('Y-m-d', strtotime($this->data['Appointment']['startdate']));
		}
		
		if(isset($this->data['Appointment']['enddate']))
		{
			$this->data['Appointment']['enddate'] = date('Y-m-d', strtotime($this->data['Appointment']['enddate']));
		}

		return true;
	}
}