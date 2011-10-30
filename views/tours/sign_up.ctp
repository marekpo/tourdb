<?php
$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

echo $this->Html->para('', __('Um dich zu dieser Tour anmelden zu können musst du zunächst deine Kontaktdaten überprüfen und ggf. ergänzen. Die mit einem Stern markierten Felder sind Pflichtfelder und müssen vor der Anmeldung ausgefüllt werden.', true));

echo $this->Form->create(false, array('url' => array($tour['Tour']['id'])));

echo $this->element('../profiles/elements/contact_data');

echo $this->Form->end(__('Anmelden', true));