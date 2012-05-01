<?php
$this->set('title_for_layout', __('Tourenrapport', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Tourenrapport', true));

echo $this->Html->para('', sprintf(__('Hier kannst du Tourenrapport für deine Tour "%s" ausfüllen und speichern.', true), $this->data['Tour']['title']));

echo $this->Form->create();

echo $this->Form->hidden('Tour.id');

echo $this->Form->input('change_status', array('label' => __('Tour wurde', true), 'options' => $reportStatusOptions));

echo $this->Form->end(__('Tourenrapport speichern', true));