<?php
class CalendarBehavior extends ModelBehavior
{
	function setup(&$model, $settings = array())
	{
		$this->settings[$model->alias] = array_merge(array(
			'startdate' => 'startdate', 'enddate' => 'enddate', 'title' => $model->displayField
		), $settings);
	}

	function getCalendarData(&$model, $year, $month, $findOptions = array())
	{
		$firstDayInCalendar = date('Y-m-d', strtotime(date('o-\WW', mktime(0, 0, 0, $month, 1, $year))));
		$lastDayInCalendar = date('Y-m-d', strtotime('sunday', mktime(0, 0, 0, $month, cal_days_in_month(CAL_GREGORIAN, $month, $year), $year)));

		return $model->find('all', array_merge($findOptions, array(
			'conditions' => array(
				'NOT' => array(
					'AND' => array(
						array($this->settings[$model->alias]['startdate'] . ' >' => $lastDayInCalendar),
						array($this->settings[$model->alias]['enddate'] . ' <' => $firstDayInCalendar)
					)
				)
			),
			'order' => array($this->settings[$model->alias]['startdate'] => 'ASC')
		)));
	}
}