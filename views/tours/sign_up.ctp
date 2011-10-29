<?php
$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

echo $this->Form->create(false, array('url' => array($tour['Tour']['id'])));

echo $this->element('../profiles/elements/contact_data');

echo $this->Form->end(__('Anmelden', true));