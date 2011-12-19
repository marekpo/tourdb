<?php
$this->set('title_for_layout', __('Anmeldung schliessen', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Anmeldung schliessen', true));

echo $this->Form->create();

echo $this->Form->input('Tour.confirm', array('type' => 'hidden', 'value' => 1));

echo $this->Html->para('', __('Bist du sicher? Wenn du die Anmeldung jetzt abschliesst, kann sich niemand mehr anmelden!', true));

echo $this->Form->end(__('Anmeldung schliessen', true));