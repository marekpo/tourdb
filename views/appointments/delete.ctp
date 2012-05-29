<?php
$this->set('title_for_layout', __('Terminlöschen', true));
$this->Html->addCrumb($this->data['Appointment']['title']);
$this->Html->addCrumb(__('Termin löschen', true));

echo $this->Html->para('', sprintf(
	__('Hiermit wird der Termin "%s" endgültig gelöscht.', true),
	$this->data['Appointment']['title']
));

echo $this->Html->para('', __('Möchtest du fortfahren?', true));

echo $this->Form->create();
echo $this->Form->input('Appointment.confirm', array('type' => 'hidden', 'value' => 1));
echo $this->Form->end(__('Termin löschen', true));