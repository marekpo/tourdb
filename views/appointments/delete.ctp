<?php
$this->set('title_for_layout', __('Anlass löschen', true));
$this->Html->addCrumb($this->data['Appointment']['title']);
$this->Html->addCrumb(__('Anlass löschen', true));

echo $this->Html->para('', sprintf(
	__('Hiermit wird der Anlass "%s" endgültig gelöscht.', true),
	$this->data['Appointment']['title']
));

echo $this->Html->para('', __('Möchtest du fortfahren?', true));

echo $this->Form->create();
echo $this->Form->input('Appointment.confirm', array('type' => 'hidden', 'value' => 1));
echo $this->Html->div('submit',
	$this->Form->submit(__('Abbrechen', true), array('name' => 'data[Appointment][cancel]', 'div' => false, 'class' => 'cancel'))
	. $this->Form->submit(__('Anlass löschen', true), array('div' => false))
);