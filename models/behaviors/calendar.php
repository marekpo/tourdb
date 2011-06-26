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
		$firstDayInCalendar = sprintf('%4d-%02d-%02d', $year, $month, 1);

		$firstWeekdayInMonth = (int)date('N', strtotime($firstDayInCalendar));

		if($firstWeekdayInMonth != 1)
		{
			$previousMonth = $month - 1;
			$previousMonthYear = $year;

			if($previousMonth < 1)
			{
				$previousMonthYear--;
				$previousMonth = 12;
			}

			$daysInPreviousMonth = cal_days_in_month(CAL_GREGORIAN, $previousMonth, $previousMonthYear);

			$firstDayInCalendar = sprintf('%4d-%02d-%02d', $previousMonthYear, $previousMonth, $daysInPreviousMonth - $firstWeekdayInMonth + 2);
		}

		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$lastDayInCalendar = sprintf('%4d-%02d-%02d', $year, $month, $daysInMonth);
		
		$lastWeekdayInMonth = (int)date('N', strtotime($lastDayInCalendar));

		if($lastWeekdayInMonth != 7)
		{
			$nextMonth = $month + 1;
			$nextMonthYear = $year;

			if($nextMonth > 12)
			{
				$nextMonthYear++;
				$nextMonth = 1;
			}

			$lastDayInCalendar = sprintf('%4d-%02d-%02d', $nextMonthYear, $nextMonth, 7 - $lastWeekdayInMonth);
		}

		return $model->find('all', array_merge($findOptions, array(
			'conditions' => array(
				'OR' => array(
					array($this->settings[$model->alias]['startdate'] . ' >=' => $firstDayInCalendar),
					array($this->settings[$model->alias]['enddate'] . ' >=' => $firstDayInCalendar),
					array($this->settings[$model->alias]['startdate'] . ' <=' => $lastDayInCalendar),
					array($this->settings[$model->alias]['enddate'] . ' <=' => $lastDayInCalendar)
				)
			),
			'order' => array($this->settings[$model->alias]['startdate'] => 'ASC')
		)));
	}
}