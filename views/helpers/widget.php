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
		$calendar = array();

		$appointments = $this->__buildAppointmentTree($events);

		$currentMonthTimestamp = strtotime(sprintf('%s-%s', $options['year'], $options['month']));

		list($previousMonthYear, $previousMonth) = preg_split('/-/', date('Y-m', strtotime('-1 month', $currentMonthTimestamp)));
		list($nextMonthYear, $nextMonth) = preg_split('/-/', date('Y-m', strtotime('+1 month', $currentMonthTimestamp)));

		$calendar[] = $this->Html->div('title',
			$this->Html->div('previous', $this->Html->link(__('vorheriger', true), Router::url(array('action' => $this->action, $previousMonthYear, $previousMonth))))
			. $this->Html->div('next', $this->Html->link(__('nächster', true), Router::url(array('action' => $this->action, $nextMonthYear, $nextMonth))))
			. date('F Y', strtotime(sprintf('%d-%02d-%02d', $options['year'], $options['month'], 1)))
		);

		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $options['month'], $options['year']);

		$startTimestamp = $currentTimestamp = strtotime(date('o-\WW', mktime(0, 0, 0, $options['month'], 1, $options['year'])));
		$endTimestamp = strtotime('sunday', mktime(0, 0, 0, $options['month'], $daysInMonth, $options['year']));

		$endIteration = false;
		$week = null;

		while(!$endIteration)
		{
			$currentWeek = date('W', $currentTimestamp);

			if($week != $currentWeek)
			{
				$week = $currentWeek;

				$calendar[] = $this->Html->div('week');
			}

			$calendar[] = $this->Html->div(sprintf('day %s', strtolower(date('l', $currentTimestamp))), date('j', $currentTimestamp));

			$endIteration = $currentTimestamp >= $endTimestamp;

			$lastTimestamp = $currentTimestamp;
			$currentTimestamp = strtotime('+ 1 day', $currentTimestamp);

			$weekOfNextDay = date('W', $currentTimestamp);

			if($weekOfNextDay != $currentWeek)
			{
				$week = date('o-\WW', $lastTimestamp);

				if(isset($appointments[$week]))
				{
					$slots = array();
	
					foreach($appointments[$week] as $slot => $slotContent)
					{
						$slotAppointments = array();

						foreach($slotContent as $appointment)
						{
							$slotAppointments[] = $this->Html->div(sprintf('appointment offset%d width%d', $appointment['offset'], $appointment['length']), 
								$this->Html->div('label', $appointment['title'])
							);
						}

						$slots[] = $this->Html->div(sprintf('slot slot%d', $slot), implode("\n", $slotAppointments));
					}
	
					$calendar[] = $this->Html->div('slotcontainer',
						$this->Html->div('slotscroller', implode("\n", $slots))
					);
				}
				$calendar[] = sprintf($this->Html->tags['tagend'], 'div');
			}
		}

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

		$appointments = $slotMap = array();

		$appointmentModel = array_pop(array_keys($events[0]));

		foreach($events as $event)
		{
			$startTimestamp = strtotime($event[$appointmentModel]['startdate']);
			$endTimestamp = strtotime($event[$appointmentModel]['enddate']);

			for($slot = 0; true; $slot++)
			{
				$slotFound = true;
				$currentTimestamp = $startTimestamp;
				$endIteration = false;

				while(!$endIteration)
				{
					$year = (int)date('Y', $currentTimestamp);
					$month = (int)date('n', $currentTimestamp);
					$day = (int)date('j', $currentTimestamp);

					if(isset($slotMap[$year][$month][$day][$slot]))
					{
						$slotFound = false;
						break;
					}

					$endIteration = $currentTimestamp >= $endTimestamp;

					$currentTimestamp = strtotime('+ 1 day', $currentTimestamp);
				}

				if($slotFound)
				{
					$currentTimestamp = $startTimestamp;
					$currentWeek = date('\WW', $currentTimestamp);
					$endIteration = false;

					$previousWeek = null;

					while(!$endIteration)
					{
						$year = (int)date('Y', $currentTimestamp);
						$month = (int)date('n', $currentTimestamp);
						$day = (int)date('j', $currentTimestamp);

						if($currentWeek != $previousWeek)
						{
							$sundayTimestamp = strtotime('sunday', $currentTimestamp);
							$length = ($endTimestamp > $sundayTimestamp ? $sundayTimestamp - $currentTimestamp : $endTimestamp - $currentTimestamp) / 86400 + 1;

							$week = date('o-\WW', $currentTimestamp);

							if(!isset($appointments[$week][$slot]))
							{
								$appointments[$week][$slot] = array();
							}

							$appointments[$week][$slot][] = array(
								'id' => $event[$appointmentModel]['id'],
								'title' => $event[$appointmentModel]['title'],
								'offset' => (int)date('w', $currentTimestamp),
								'length' => $length
							);
						}

						$slotMap[$year][$month][$day][$slot] = true;

						$endIteration = $currentTimestamp >= $endTimestamp;

						$currentTimestamp = strtotime('+ 1 day', $currentTimestamp);
						$previousWeek = $currentWeek;
						$currentWeek = date('\WW', $currentTimestamp);
					}

					break;
				}
			}
		}

		return $appointments;
	}
}