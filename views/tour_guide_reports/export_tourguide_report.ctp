<?php
$this->set('title_for_layout', __('Tourenrapport exportieren', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Tourenrapport exportieren', true));

echo $this->Html->para('', sprintf(__('Hier kannst du den Tourenrapport für die Tour "%s" herunterladen. Bitte danach noch kontrolieren und an die Tourenkommision per E-Mail abschicken!', true), $this->data['Tour']['title']));

echo $this->Form->create('TourGuideReport', array('url' => array($this->data['Tour']['id'])));

echo $this->Form->hidden('Tour.id');

echo $this->Form->end(__('Tourenrapport exportieren', true));
