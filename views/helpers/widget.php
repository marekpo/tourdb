<?php
class WidgetHelper extends AppHelper
{
	var $helpers = array('Html', 'Form', 'Js');

	function dragDrop($name, $options = array())
	{
		if(isset($options['itemClass']))
		{
			$itemClass = $options['itemClass'];
			unset($options['itemClass']);
		}
		else
		{
			$itemClass = Inflector::underscore($name);
		}

		if(!isset($options['options']))
		{
			$view =& ClassRegistry::getObject('view');
			$varName = Inflector::variable(Inflector::pluralize($name));
			$options['options'] = $view->getVar($varName);
		}

		$attributes = $this->_initInputField($name, array('type' => 'hidden'));

		$value = $attributes['value'];
		unset($attributes['value']); 

		$forUniqueId = Inflector::underscore($name);

		$ddWidget = $this->Html->tag('input', '', $attributes);

		$availableItems = '';
		foreach($options['options'] as $key => $label)
		{
			if(!in_array($key, $value))
			{
				$availableItems .= $this->__createItem($key, $label, $itemClass);
			}
		}
		$ddWidget .= $this->Html->div('dd-all', $availableItems, array('id' => sprintf('all-items-%s', $forUniqueId)));

		$associatedItems = '';
		$associatedItemsInputs = '';
		foreach($value as $key)
		{
			$associatedItems .= $this->__createItem($key, $options['options'][$key], $itemClass);
			$associatedItemsInputs .= $this->Html->tag('input', '', array('type' => 'hidden', 'name' => sprintf('%s[]', $attributes['name']), 'value' => $key));
		}

		$ddWidget .= $this->Html->div('dd-assoc', $associatedItems, array('id' => sprintf('assoc-items-%s', $forUniqueId)));
		$ddWidget .= $this->Html->div('', $associatedItemsInputs, array('id' => sprintf('assoc-items-inputs-%s', $forUniqueId), 'style' => 'display:none'));

		$ddWidget .= $this->Html->div('', '', array('style' => 'clear: both'));

		$ddWidget = $this->Html->div('dd-container', $ddWidget, array('id' => sprintf('dd-%s', $forUniqueId)));

		$this->Html->script('widgets/dragdrop', array('inline' => false));

		$this->Js->get(sprintf('#all-items-%s', $forUniqueId));
		$this->Js->drop(array(
			'accept' => sprintf('#assoc-items-%s > .item', $forUniqueId),
			'drop' => sprintf('TourDB_DragDrop.removeItem(ui.draggable, \'%s\');', $forUniqueId),
			'activeClass' => 'active',
			'hoverClass' => 'hover'
		));
		
		$this->Js->get(sprintf('#assoc-items-%s', $forUniqueId));
		$this->Js->drop(array(
			'accept' => sprintf('#all-items-%s > .item', $forUniqueId),
			'drop' => sprintf('TourDB_DragDrop.addItem(ui.draggable, \'%s\', \'%s\');', $forUniqueId, $attributes['name']),
			'activeClass' => 'active',
			'hoverClass' => 'hover'
		));
		
		$this->Js->get(sprintf('#dd-%s .item', $forUniqueId));
		$this->Js->drag(array('revert' => 'invalid', 'helper' => 'clone'));
		
		return $ddWidget;
	}

	function dateTime($name, $options = array())
	{
		$options = array_merge($options, array(
			'type' => 'text',
			'class' => 'dateTime'
		));

		$inputAttributes = $this->_initInputField($name);

		$this->Html->script('jquery.ui.datepicker-de', array('inline' => false));
		$this->Js->buffer("$('#{$inputAttributes['id']}').datepicker({
			showButtonPanel: true
		});");

		return $this->Form->input($name, $options);
	}

	function calendar($events, $options = array())
	{
		$options = array_merge(array('month' => date('m'), 'year' => date('Y')), $options);
		$options['month'] = (int)$options['month'];
		$options['year'] = (int)$options['year'];
		$calendar = array();

		$weekDayOfFirstDayInMonth = date('N', strtotime(sprintf('%d-%02d-%02d', $options['year'], $options['month'], 1)));
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $options['month'], $options['year']);

		$appointments = $this->__buildAppointmentTree($events);

		$previousMonth = $options['month'] - 1;
		$previousMonthYear = $options['year'];

		if($previousMonth < 1)
		{
			$previousMonth = 12;
			$previousMonthYear--;
		}

		$weekDayOfLastDayInMonth = date('N', strtotime(sprintf('%d-%02d-%02d', $options['year'], $options['month'], $daysInMonth)));

		$nextMonth = $options['month'] + 1;
		$nextMonthYear = $options['year'];

		if($nextMonth > 12)
		{
			$nextMonth = 1;
			$nextMonthYear++;
		}

		$calendar[] = $this->Html->div('title',
			$this->Html->div('previous', $this->Html->link(__('vorheriger', true), Router::url(array('action' => $this->action, $previousMonthYear, $previousMonth))))
			. $this->Html->div('next', $this->Html->link(__('nächster', true), Router::url(array('action' => $this->action, $nextMonthYear, $nextMonth))))
			. date('F Y', strtotime(sprintf('%d-%02d-%02d', $options['year'], $options['month'], 1)))
		);

		if($weekDayOfFirstDayInMonth != 1)
		{
			$daysInPreviousMonth = cal_days_in_month(CAL_GREGORIAN, $previousMonth, $previousMonthYear);
			$firstDayOfPreviousMonthInCalendar = $daysInPreviousMonth - $weekDayOfFirstDayInMonth + 2;

			if($firstDayOfPreviousMonthInCalendar <= $daysInPreviousMonth)
			{
				for($calendarDay = $firstDayOfPreviousMonthInCalendar; $calendarDay <= $daysInPreviousMonth; $calendarDay++)
				{
					$calendar[] = $this->__createDayElement($calendarDay, $previousMonth, $previousMonthYear, $appointments, 'previousMonth');
				}
			}
		}

		for($calendarDay = 1; $calendarDay <= $daysInMonth; $calendarDay++)
		{
			$calendar[] = $this->__createDayElement($calendarDay, $options['month'], $options['year'], $appointments);
		}

		if($weekDayOfLastDayInMonth != 7)
		{
			for($calendarDay = 1; $weekDayOfLastDayInMonth + $calendarDay <= 7; $calendarDay++)
			{
				$calendar[] = $this->__createDayElement($calendarDay, $nextMonth, $nextMonthYear, $appointments, 'nextMonth');
			}
		}

		$calendar[] = $this->Html->div('', '', array('style' => 'clear: left'));

		$calendarId = 'calendar' . String::uuid();

		$calendar[] = $this->Html->scriptBlock(sprintf('
			$(\'#%1$s .title .previous a\').click(function() {
				$(\'#%1$s\').parent().load(this.href);
				return false;
			});

			$(\'#%1$s .title .next a\').click(function() {
				$(\'#%1$s\').parent().load(this.href);
				return false;
			});
		', $calendarId));

		return $this->Html->div('calendar', implode("\n", $calendar), array('id' => $calendarId));
	}

	function stripHidden($text)
	{
		return preg_replace('/<input.*?type="hidden".*?>/', '', $text);
	}

	function __createItem($key, $label, $itemClass)
	{
		return $this->Html->div(sprintf('item %s', $itemClass), $label, array('id' => sprintf('item-%s', $key)));
	}

	function __createDayElement($day, $month, $year, $appointments, $additionalClass = '')
	{
		$content = array();
		if(isset($appointments[$year][$month][$day]))
		{
			foreach($appointments[$year][$month][$day] as $slot => $slotInfo)
			{
				$slotClass = array(
					'slot', sprintf('slot%d', $slot)
				);

				if($slotInfo['start'])
				{
					$slotClass[] = 'start';
				}

				if($slotInfo['end'])
				{
					$slotClass[] = 'end';
				}

				$content[] = $this->Html->div(implode(' ', $slotClass), ($slotInfo['start'] ? $slotInfo['title'] : ''), array('title' => $slotInfo['title']));
			}
		}
		
		$elementClass = implode(' ', array('day %s', $additionalClass));
		return $this->Html->div(
			sprintf($elementClass, strtolower(date('l',
				strtotime(sprintf('%d-%02d-%02d', $year, $month, $day))
			))),
			$this->Html->div('calendarDay', $day) . implode("\n", $content)
		);
	}

	function __buildAppointmentTree($events)
	{
		if(count($events) == 0)
		{
			return array();
		}

		$appointments = array();

		$appointmentModel = array_pop(array_keys($events[0]));

		foreach($events as $event)
		{
			list($startYear, $startMonth, $startDay) = preg_split('/-/', date('Y-m-d', strtotime($event[$appointmentModel]['startdate'])));
			list($endYear, $endMonth, $endDay) = preg_split('/-/', date('Y-m-d', strtotime($event[$appointmentModel]['enddate'])));

			$year = (int)$startYear;
			$month = (int)$startMonth;
			$day = (int)$startDay;
			$slot = 0;
			$slotFound = false;
			$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			while(!$slotFound)
			{
				$endIteration = false;

				while(!$endIteration)
				{
					if(isset($appointments[$year][$month][$day][$slot]))
					{
						break;
					}

					$endIteration = ($year == $endYear && $month == $endMonth && $day == $endDay);

					$day++;

					if($day > $daysInCurrentMonth)
					{
						$month++;

						if($month > 12)
						{
							$year++;
							$month = 1;
						}

						$day = 1;
						$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
					}
				}

				if($endIteration)
				{
					$slotFound = true;
					break;
				}

				$slot++;
			}

			$year = (int)$startYear;
			$month = (int)$startMonth;
			$day = (int)$startDay;
			$endIteration = false;
			$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

			while(!$endIteration)
			{
				$appointments[$year][$month][$day][$slot] = array(
					'start' => ($year == $startYear && $month == $startMonth && $day == $startDay),
					'end' => ($year == $endYear && $month == $endMonth && $day == $endDay),
					'title' => $event[$appointmentModel]['title']
				);

				$endIteration = ($year == $endYear && $month == $endMonth && $day == $endDay);

				$day++;

				if($day > $daysInCurrentMonth)
				{
					$month++;

					if($month > 12)
					{
						$year++;
						$month = 1;
					}

					$day = 1;
					$daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				}

			}
		}

		return $appointments;
	}
}