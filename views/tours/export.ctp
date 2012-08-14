<?php
$this->set('title_for_layout', __('Touren exportieren', true));
$this->Html->addCrumb(__('Touren exportieren', true));

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


echo $this->Form->input('Tour.tour_group_id', array(
		'type' => 'select', 'label' => __('Tourengruppe', true),
		'empty' => ''
));

echo $this->Form->end(__('Exportieren', true));
$this->Js->buffer("$('#TourStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#TourEnddate').datepicker('option', 'minDate', dateText); });");