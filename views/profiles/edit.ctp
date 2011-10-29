<?php
$this->set('title_for_layout', __('Profil bearbeiten', true));
$this->Html->addCrumb(__('Profil bearbeiten', true));

echo $this->Form->create();

echo $this->element('../profiles/elements/contact_data');

echo $this->Form->end(__('Speichern', true));