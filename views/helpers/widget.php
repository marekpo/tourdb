<?php
class WidgetHelper extends AppHelper
{
	var $helpers = array('Html', 'Form', 'Js', 'Time', 'TourDisplay', 'Text');

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
		$options = array_merge(array(
			'type' => 'text',
			'class' => 'dateTime',
			'mode' => 'date'
		), $options);

		$inputAttributes = $this->_initInputField($name);

		$datePickerOptions = array('showButtonPanel' => true);

		if(isset($options['datepicker']))
		{
			$datePickerOptions = array_merge($datePickerOptions, $options['datepicker']);
		}

		$datePickerOptionParts = array();

		foreach($datePickerOptions as $key => $value)
		{
			$datePickerOptionParts[] = sprintf('%s: %s', $key, $value);
		}

		$this->Html->script('jquery.ui.datepicker-de', array('inline' => false));

		if($options['mode'] == 'time' || $options['mode'] == 'datetime')
		{
			$this->Html->script('jquery-ui-timepicker-addon.js', array('inline' => false));
		}

		$pickerFunction = sprintf('%spicker', $options['mode']);

		$this->Js->buffer(sprintf("$('#{$inputAttributes['id']}').%s({%s});", $pickerFunction, implode(', ', $datePickerOptionParts)));

		return $this->Form->input($name, $options);
	}

	function includeCalendarScripts()
	{
		$this->Html->script('widgets/adjacenttours', array('inline' => false));
		$this->Html->script('widgets/calendar', array('inline' => false));
	}

	function calendar($events, $options = array())
	{
		$options = array_merge(array(
			'month' => date('m'),
			'year' => date('Y'),
			'ajax' => true,
			'viewlinks' => false
		), $options);

		$calendar = array();

		$appointments = $this->__buildAppointmentTree($events);

		$currentMonthTimestamp = strtotime(sprintf('%s-%s', $options['year'], $options['month']));

		list($previousMonthYear, $previousMonth) = preg_split('/-/', date('Y-m', strtotime('-1 month', $currentMonthTimestamp)));
		list($nextMonthYear, $nextMonth) = preg_split('/-/', date('Y-m', strtotime('+1 month', $currentMonthTimestamp)));

		$calendar[] = $this->Html->div('title',
			$this->Html->div('previous', $this->Html->link(__('vorheriger', true), Router::url(array('action' => $this->action, $previousMonthYear, $previousMonth))))
			. $this->Html->div('next', $this->Html->link(__('nächster', true), Router::url(array('action' => $this->action, $nextMonthYear, $nextMonth))))
			. $this->Time->format(strtotime(sprintf('%d-%02d-%02d', $options['year'], $options['month'], 1)), '%B %Y')
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
							$slotAppointments[] = $this->__renderAppointment($appointment, $options);
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

		$calendar[] = $this->Html->scriptBlock(sprintf("$('#%s').calendar({'ajax': %s});", $calendarId, $options['ajax'] ? 'true' : 'false'));

		return $this->Html->div('calendar', implode("\n", $calendar), array('id' => $calendarId));
	}

	function stripHidden($text)
	{
		return preg_replace('/<input.*?type="hidden".*?>/', '', $text);
	}

	function collapsibleFieldset($legend, $content, $collapsed = false)
	{
		$fieldsetId = 'fieldset' . String::uuid();

		$this->Html->script('widgets/collapsible_fieldset', array('inline' => false));
		$this->Js->buffer(sprintf("$('#%s').collapsibleFieldset({ collapsed: %s });", $fieldsetId, ($collapsed ? 'true' : 'false')));

		return $this->Html->tag('fieldset',
			$this->Html->tag('legend',
				$this->Html->tag('span', sprintf(__('%s ausklappen',true), $legend), array('class' => 'collapsedtext'))
				. $this->Html->tag('span', sprintf(__('%s einklappen',true), $legend), array('class' => 'expandedtext'))
			)
			. $this->Html->div('', $content),
			array('id' => $fieldsetId)
		);
	}

	function table($tableHeaders, $tableCells)
	{
		return $this->Html->tag('table',
			$this->Html->tableHeaders($tableHeaders) . $this->Html->tableCells($tableCells, array(), array('class' => 'even'), false, false),
			array('class' => 'list')
		);
	}

	function tourTypes($options = array())
	{
		$view =& ClassRegistry::getObject('view');

		$options = array_merge(array(
			'fieldName' => 'Tour.TourType',
			'label' => __('Tourentyp', true),
			'options' => $view->getVar('tourTypes'),
			'disabled' => false,
			'error' => false,
			'get' => false
		), $options);

		if(empty($options['options']))
		{
			$options['options'] = array();
		}

		$fieldName = $options['fieldName'];
		unset($options['fieldName']);

		$label = $options['label'];
		unset($options['label']);

		$tourTypes = $options['options'];
		unset($options['options']);

		$disabled = $options['disabled'];
		unset($options['disabled']);

		$error = $options['error'];
		unset($options['error']);

		$this->setEntity($fieldName, true);

		if($options['get'])
		{
			$fieldName = array_pop(explode('.', $fieldName));
		}

		$inputFieldInitInfo = $this->_initInputField($fieldName);
		$nameAttributeValue = $options['get'] ? $fieldName : $inputFieldInitInfo['name'];

		$inputs = array();
		$inputs[] = $this->Form->hidden($fieldName, array('value' => '', 'disabled' => $disabled));

		foreach($tourTypes as $tourType)
		{
			$inputs[] = $this->Html->div('checkbox',
				$this->Form->checkbox($fieldName, array(
					'id' => sprintf('%s%s', $inputFieldInitInfo['id'], $tourType['TourType']['id']),
					'name' => sprintf('%s[]', $nameAttributeValue),
					'hiddenField' => false, 'value' => $tourType['TourType']['id'],
					'checked' => !empty($inputFieldInitInfo['value']) && in_array($tourType['TourType']['id'], $inputFieldInitInfo['value']),
					'disabled' => $disabled, 'class' => sprintf('tt-%s', $tourType['TourType']['key'])
				))
				. $this->Html->tag('label', $tourType['TourType']['acronym'], array(
					'for' => sprintf('%s%s', $inputFieldInitInfo['id'], $tourType['TourType']['id'])
				)), array('title' => $tourType['TourType']['title'])
			);
		}

		$options['class'] = 'input select required';

		$out = array();
		$out[] = $this->Html->div('checkbox-container', $this->Html->div('', implode("\n", $inputs)), array('id' => 'tourtypes'));

		$out[] = $this->Html->div('', '', array('style' => 'clear: left'));

		if($error !== false)
		{
			$errorMessage = $this->Form->error($fieldName, $error);
			if($errorMessage)
			{
				$options = $this->addClass($options, 'error');
				$out[] = $errorMessage;
			}
		}

		array_unshift($out, $this->Form->label($fieldName, $label));

		return $this->Html->tag('div', implode("\n", $out), $options);
	}

	function conditionalRequisites($options = array())
	{
		$view =& ClassRegistry::getObject('view');

		$options = array_merge(array(
			'fieldName' => 'Tour.ConditionalRequisite',
			'label' => __('Anforderung', true),
			'options' => $view->getVar('conditionalRequisites'),
			'disabled' => false,
			'error' => false,
			'get' => false
		), $options);

		if(empty($options['options']))
		{
			$options['options'] = array();
		}

		$fieldName = $options['fieldName'];
		unset($options['fieldName']);

		$label = $options['label'];
		unset($options['label']);

		$conditionalRequisites = $options['options'];
		unset($options['options']);

		$disabled = $options['disabled'];
		unset($options['disabled']);

		$error = $options['error'];
		unset($options['error']);

		$this->setEntity($fieldName, true);

		if($options['get'])
		{
			$fieldName = array_pop(explode('.', $fieldName));
		}

		$out = array();

		$out[] = $this->Form->label($fieldName, $label);
		$out[] = $this->Form->hidden($fieldName, array('value' => '', 'disabled' => $disabled));

		$inputFieldInitInfo = $this->_initInputField($fieldName);

		$nameAttributeValue = $options['get'] ? $fieldName : $inputFieldInitInfo['name'];

		foreach($conditionalRequisites as $conditionalRequisite)
		{
			$out[] = $this->Html->div('checkbox',
				$this->Form->checkbox($fieldName, array(
					'id' => sprintf('%s%s', $inputFieldInitInfo['id'], $conditionalRequisite['ConditionalRequisite']['id']),
					'name' => sprintf('%s[]', $nameAttributeValue),
					'hiddenField' => false, 'value' => $conditionalRequisite['ConditionalRequisite']['id'],
					'checked' => !empty($inputFieldInitInfo['value']) && in_array($conditionalRequisite['ConditionalRequisite']['id'], $inputFieldInitInfo['value']),
					'disabled' => $disabled
				))
				. $this->Html->tag('label', $conditionalRequisite['ConditionalRequisite']['acronym'], array(
					'for' => sprintf('%s%s', $inputFieldInitInfo['id'], $conditionalRequisite['ConditionalRequisite']['id'])
				)), array('title' => $conditionalRequisite['ConditionalRequisite']['description']));
		}

		$options['class'] = 'input select required';

		$out[] = $this->Html->div('', '', array('style' => 'clear: left'));

		if($error !== false)
		{
			$errorMessage = $this->Form->error($fieldName, $error);
			if($errorMessage)
			{
				$options = $this->addClass($options, 'error');
				$out[] = $errorMessage;
			}
		}

		return $this->Html->tag('div', implode("\n", $out), $options);
	}

	function __createItem($key, $label, $itemClass)
	{
		return $this->Html->div(sprintf('item %s', $itemClass), $label, array('id' => sprintf('item-%s', $key)));
	}

	function __buildAppointmentTree($events)
	{
		if(count($events) == 0)
		{
			return array();
		}

		$appointments = $slotMap = array();

		foreach($events as $event)
		{
			$appointmentModel = $this->__getAppointmentModel($event);

			$startTimestamp = strtotime($this->Time->format($event[$appointmentModel]['startdate'], '%Y-%m-%d'));
			$endTimestamp = strtotime($this->Time->format($event[$appointmentModel]['enddate'], '%Y-%m-%d'));

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
								'length' => $length,
								'event' => $event
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

	function __getAppointmentModel($data)
	{
		return array_shift(array_keys($data));
	}

	function __renderAppointment($appointment, $options)
	{
		$appointmentModel = $this->__getAppointmentModel($appointment['event']);

		$titleRenderFunction = sprintf('__render%sTitle', $appointmentModel);
		$popupRenderFunction = sprintf('__render%sPopup', $appointmentModel);

		return $this->Html->div(sprintf('event event%s offset%d width%d', $appointment['id'], $appointment['offset'], $appointment['length']),
			$this->Html->div(sprintf('popup model-%s', strtolower($appointmentModel)), $this->{$popupRenderFunction}($appointment, $options))
			. $this->Html->div(sprintf('label model-%s', strtolower($appointmentModel)), $this->{$titleRenderFunction}($appointment, $options))
		);
	}

	function __renderTourTitle($appointment, $options)
	{
		if($options['viewlinks'])
		{
			return $this->Html->link($appointment['title'], array('controller' => 'tours', 'action' => 'view', $appointment['id']));
		}

		return $appointment['title'];
	}

	function __renderTourPopup($appointment, $options)
	{
		$rows = array(
			array(
				array(
					__('TourenleiterIn', true),
					array('class' => 'label')
				),
				$this->TourDisplay->getTourGuide($appointment['event'])
			),
			array(
				array(
					__('Gruppe', true),
					array('class' => 'label')
				),
				$appointment['event']['TourGroup']['tourgroupname']
			),
			array(
				array(
					__('Tourstatus', true),
					array('class' => 'label')
				),
				$appointment['event']['TourStatus']['statusname']
			),
			array(
				array(
					__('Tourencode', true),
					array('class' => 'label')
				),
				$this->TourDisplay->getClassification($appointment['event'])
			),
			array(
				array(
					__('Datum', true),
					array('class' => 'label')
				),
				sprintf('%s - %s',
					strftime('%d.%m.%Y', strtotime($appointment['event']['Tour']['startdate'])),
					strftime('%d.%m.%Y', strtotime($appointment['event']['Tour']['enddate'])))
			),
			array(
				array(
					__('Beschreibung', true),
					array('class' => 'label')
				),
				$this->Text->truncate($appointment['event']['Tour']['description'])
			)
		);

		return $this->Html->div('title', $appointment['title'])
			. $this->Html->div('body', $this->Html->tag('table', $this->Html->tableCells($rows)));
	}

	function __renderAppointmentTitle($appointment, $options)
	{
		if($options['viewlinks'])
		{
			return $this->Html->link($appointment['title'], array('controller' => 'appointments', 'action' => 'view', $appointment['id']));
		}

		return $appointment['title'];
	}

	function __renderAppointmentPopup($appointment, $options)
	{
		$rows = array(
			array(
				array(
					__('Ort', true),
					array('class' => 'label')
				),
				$appointment['event']['Appointment']['location']
			),
			array(
				array(
					__('Start', true),
					array('class' => 'label')
				),
				strftime('%d.%m.%Y %H:%M', strtotime($appointment['event']['Appointment']['startdate']))
			),
			array(
				array(
					__('Ende', true),
					array('class' => 'label')
				),
				strftime('%d.%m.%Y %H:%M', strtotime($appointment['event']['Appointment']['enddate']))
			)
		);

		return $this->Html->div('title', $appointment['title'])
			. $this->Html->div('body', $this->Html->tag('table', $this->Html->tableCells($rows)));
	}
}