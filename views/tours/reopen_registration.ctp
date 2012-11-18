<?php
$this->set('title_for_layout', __('Anmeldung wiedereröffnen', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Anmeldung wiedereröffnen', true));

echo $this->Form->create();

echo $this->Form->input('Tour.confirm', array('type' => 'hidden', 'value' => 1));

echo $this->Html->para('', __('Bist du sicher? Wenn du die Anmeldung jetzt wiedereröffnest, kann man sich wieder anmelden!', true));

echo $this->Html->div('submit',
	$this->Form->submit(__('Abbrechen', true), array('name' => 'data[Tour][cancel]', 'div' => false, 'class' => 'cancel'))
	. $this->Form->submit(__('Anmeldung wiedereröffnen', true), array('div' => false))
);
