<?php
class TourGuideReport extends AppModel
{
	var $name = 'TourGuideReport';

	var $belongsTo = array('Tour');

	var $validate = array(
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'expenses_organsiation' => array(
			'decnum' => array(
				'rule' => 'decimal',
				'allowEmpty' => true
			)
		),
		'driven_km' => array(
			'km' => array(
				'rule' => array('numeric', array('maxLength', 4)),
				'allowEmpty' => true
			)
		),
		'expenses_transport' => array(
			'decnum' => array(
				'rule' => 'decimal',
				'allowEmpty' => true
			)
		),
		'expenses_accommodation' => array(
			'decnum' => array(
				'rule' => 'decimal',
				'allowEmpty' => true
			)
		),
		'expenses_others1' => array(
			'decnum' => array(
				'rule' => 'decimal',
				'allowEmpty' => true
			)
		),
		'expenses_others2' => array(
			'decnum' => array(
				'rule' => 'decimal',
				'allowEmpty' => true
			)
		),
		'paid_donation' => array(
			'decnum' => array(
				'rule' => 'decimal',
				'allowEmpty' => true
			)
		)
	);

	function getReportStatusOptions()
	{
		$reportStatusOptions = array();

		$reportStatusOptions = $this->Tour->TourStatus->find('list', array(
			'conditions' => array('TourStatus.key' => array(TourStatus::CARRIED_OUT, TourStatus::NOT_CARRIED_OUT))
		));

		return $reportStatusOptions;
	}

	function getReportStatusDefault()
	{
		return $this->Tour->TourStatus->field('id', array('TourStatus.key' => TourStatus::CARRIED_OUT));
	}
}