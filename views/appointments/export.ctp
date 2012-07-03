<?php
$this->set('title_for_layout', __('Anlässe exportieren', true));
$this->Html->addCrumb(__('Anlässe exportieren', true));

echo $this->Form->create();

echo $this->Widget->dateTime('startdate', array(
	'label' => __('Startdatum', true),
	'error' => array(
		'notEmpty' => __('Das Startdatum für den Export darf nicht leer sein.', true)
	)
));
echo $this->Widget->dateTime('enddate', array(
	'label' => __('Enddatum', true),
	'error' => array(
		'notEmpty' => __('Das Enddatum für den Export darf nicht leer sein.', true),
		'greaterOrEqualStartDate' => __('Das Enddatum muss größer oder gleich dem Startdatum sein.', true)
	)
));

echo $this->Form->end(__('Exportieren', true));
$this->Js->buffer("$('#AppointmentStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#AppointmentEnddate').datepicker('option', 'minDate', dateText); });");