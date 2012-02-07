<?php
$this->set('title_for_layout', __('Teilnehmerliste exportieren', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Teilnehmerliste exportieren', true));

echo $this->Html->para('', sprintf(__('Hier kannst du eine Liste aller bisher angemeldeten Teilnehmer für die Tour "%s" herunterladen.', true), $this->data['Tour']['title']));

echo $this->Form->create();

echo $this->Form->hidden('Tour.id');

echo $this->Form->end(__('Liste erstellen', true));