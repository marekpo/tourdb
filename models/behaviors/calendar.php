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

		$options = array(
			'conditions' => array(array(
				'NOT' => array(
					'OR' => array(
						array($this->settings[$model->alias]['startdate'] . ' >' => $lastDayInCalendar),
						array($this->settings[$model->alias]['enddate'] . ' <' => $firstDayInCalendar)
					)
				)
			))
		);

		if(isset($findOptions['conditions']) && !empty($findOptions['conditions']))
		{
			$options['conditions'] = array_merge($options['conditions'], $findOptions['conditions']);
		}

		unset($findOptions['conditions']);

		$options = array_merge($options, $findOptions);

		return $model->find('all', array_merge($options, array(
			'order' => array($this->settings[$model->alias]['startdate'] => 'ASC')
		)));
	}

	function sortRecords()
	{
		$recordListsToSort = array();
		$numRecordLists = 0;

		foreach(func_get_args() as $recordList)
		{
			if(is_array($recordList) && !empty($recordList))
			{
				$recordListsToSort[] = $recordList;
				$numRecordLists++;
			}
		}

		if($numRecordLists == 0)
		{
			return array();
		}

		$sortedRecords = array();

		$topAppointments = array();

		for($i = 0; $i < $numRecordLists; $i++)
		{
			$topAppointments[] = $this->__getStartTimestamp($recordListsToSort[$i][0]);
		}

		while(count($recordListsToSort))
		{
			$nextRecordListIndex = $this->__getMinValueIndex($topAppointments);
			$sortedRecords[] = array_shift($recordListsToSort[$nextRecordListIndex]);

			if(!empty($recordListsToSort[$nextRecordListIndex]))
			{
				$topAppointments[$nextRecordListIndex] = $this->__getStartTimestamp($recordListsToSort[$nextRecordListIndex][0]);
			}
			else
			{
				unset($recordListsToSort[$nextRecordListIndex]);
			}

			if(count($recordListsToSort) == 1)
			{
				$sortedRecords = array_merge($sortedRecords, array_shift($recordListsToSort));
				break;
			}
		}

		return $sortedRecords;
	}

	function __getStartTimestamp($record)
	{
		$model = array_shift(array_keys($record));

		return strtotime($record[$model]['startdate']);
	}

	function __getMinValueIndex($values = array())
	{
		$minValueIndex = null;
		$previousValue = PHP_INT_MAX;

		foreach($values as $key => $value)
		{
			if($value < $previousValue)
			{
				$minValueIndex = $key;
			}

			$previousValue = $value;
		}

		return $minValueIndex;
	}
}