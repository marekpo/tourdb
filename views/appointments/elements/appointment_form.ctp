<?php
echo $this->Form->create();

if(!empty($this->data['Appointment']['id']))
{
	echo $this->Form->hidden('Appointment.id');
}

echo $this->Form->input('Appointment.title', array(
	'label' => __('Titel', true), 'error' => array(
		'notEmpty' => __('Der Titel eines Termins darf nicht leer sein.', true)
	)
));
echo $this->Form->input('Appointment.description', array(
	'label' => __('Beschreibung', true), 'error' => array(
		'notEmpty' => __('Die Beschreibung eines Termins darf nicht leer sein.', true)
	)
));

echo $this->Widget->dateTime('Appointment.startdate', array(
	'label' => __('Startdatum', true), 'error' => array(
		'notEmpty' => __('Das Startdatum des Termins darf nicht leer sein.', true)
	)
));
echo $this->Widget->dateTime('Appointment.enddate', array(
	'label' => __('Enddatum', true), 'error' => array(
		'notEmpty' => __('Das Enddatum des Termins darf nicht leer sein.', true),
		'greaterOrEqualStartDate' => __('Das Enddatum muss größer oder gleich dem Startdatum sein.', true)
	)
));

echo $this->Form->end(__('Speichern', true));