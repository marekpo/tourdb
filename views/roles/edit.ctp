<?php
$pageTitle = sprintf(__('Rolle "%s" bearbeiten', true), $this->data['Role']['rolename']);
$this->set('title_for_layout', $pageTitle);
$this->Html->addCrumb($pageTitle);

echo $this->Form->create('Role');
echo $this->Form->hidden('id');

echo $this->Widget->dragDrop('Privilege');

echo $this->Form->end(__('Speichern', true));