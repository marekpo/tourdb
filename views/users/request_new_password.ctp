<?php
$this->set('title_for_layout', __('Neues Passwort anfordern', true));
$this->Html->addCrumb(__('Neues Passwort anfordern', true));

echo $this->Html->para('', __('Hier kannst du dir ein neues Passwort generieren lassen, falls du dein Passwort vergessen haben solltest. Dazu musst du in das untestehende Formular deine E-Mail-Adresse eingeben.', true));

echo $this->Form->create('User');

echo $this->Form->input('email', array('label' => __('E-Mail-Adresse', true)));

echo $this->Form->end(__('Passwort anfordern', true));