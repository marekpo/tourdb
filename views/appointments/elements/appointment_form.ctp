<?php
echo $this->Form->create();

if(!empty($this->data['Appointment']['id']))
{
	echo $this->Form->hidden('Appointment.id');
}

echo $this->Form->input('Appointment.title', array(
	'label' => __('Titel', true), 'error' => array(
		'notEmpty' => __('Der Titel eines Anlasses darf nicht leer sein.', true)
	)
));
echo $this->Form->input('Appointment.description', array(
	'label' => __('Beschreibung', true), 'error' => array(
		'notEmpty' => __('Die Beschreibung eines Anlasses darf nicht leer sein.', true)
	)
));
echo $this->Form->input('Appointment.location', array(
	'label' => __('Ort', true), 'error' => array(
		'notEmpty' => __('Für den Anlass muss angegeben werden, wo dieser stattfindet.', true)
	)
));

echo $this->Widget->dateTime('Appointment.startdate', array(
	'mode' => 'datetime',
	'label' => __('Beginn', true), 'error' => array(
		'notEmpty' => __('Das Startdatum des Anlasses darf nicht leer sein.', true),
		'correctDateRange' => sprintf(__('Das Startdatum des Anlasses muss zwischen heute und dem %s liegen.', true), $this->Time->format('d.m.Y', '+2 years'))
	)
));
echo $this->Widget->dateTime('Appointment.enddate', array(
	'mode' => 'datetime',
	'label' => __('Ende', true), 'error' => array(
		'notEmpty' => __('Das Enddatum des Anlasses darf nicht leer sein.', true),
		'greaterOrEqualStartDate' => __('Das Enddatum muss größer oder gleich dem Startdatum sein.', true),
		'correctDateRange' => sprintf(__('Das Enddatum des Anlasses muss zwischen heute und dem %s liegen.', true), $this->Time->format('d.m.Y', '+2 years'))
	)
));

echo $this->Form->end(__('Speichern', true));