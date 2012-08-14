<?php
$this->set('title_for_layout', __('Anlässe exportieren', true));
$this->Html->addCrumb(__('Anlässe exportieren', true));

echo $this->Form->create();

echo $this->Widget->dateTime('startdate', array(
	'label' => __('Startdatum', true),
	'error' => array(
		'correctDate' => __('Das Startdatum muss ein korrektes Datum sein (TT.MM.YYYY).', true)
	)
));
echo $this->Widget->dateTime('enddate', array(
	'label' => __('Enddatum', true),
	'error' => array(
		'correctDate' => __('Das Enddatum muss ein korrektes Datum sein (TT.MM.YYYY).', true),
		'greaterOrEqualStartDate' => __('Das Enddatum muss größer oder gleich dem Startdatum sein.', true)
	)
));

echo $this->Form->end(__('Exportieren', true));
$this->Js->buffer("$('#AppointmentStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#AppointmentEnddate').datepicker('option', 'minDate', dateText); });");