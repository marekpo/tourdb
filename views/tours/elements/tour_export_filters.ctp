<?php
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
echo $this->Form->input('Tour.tour_status_id', array(
	'label' => __('Tourenstatus', true), 'multiple' => 'checkbox', 'default' => $tourStatusDefault,
	'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => array(
		'notEmpty' => __('Es muss mindestens ein Tourenstatus ausgewählt sein.', true)
	)
));
?>