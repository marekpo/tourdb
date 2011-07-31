<?php
$pageTitle = sprintf(__('Benutzerkonto "%s" bearbeiten', true), $this->data['User']['username']);
$this->set('title_for_layout', $pageTitle);
$this->Html->addCrumb($pageTitle);

echo $this->Form->create('User');
echo $this->Form->hidden('id');

echo $this->Form->input('username', array(
	'label' => __('Benutzername', true),
	'error' => array(
		'alphaNumeric' => __('Der Benutzername darf nur Buchstaben und Zahlen enthalten.', true),
		'isUnique' => __('Dieser Benutzername wird bereits verwendet.', true),
		'length' => __('Der Benutzername muss zwischen 5 und 15 Zeichen lang sein.', true)
	)
));

echo $this->Form->input('email', array(
	'label' => __('E-Mail-Adresse', true),
	'error' => array(
		'email' => __('Dies ist keine gültige E-Mail-Adresse.', true),
		'isUnique' => __('Diese E-Mail-Adresse wird bereits verwendet.', true)
	)
));

echo $this->Form->input('active', array('label' => __('Aktiviert', true)));

echo $this->Widget->dragDrop('Role');

echo $this->Form->end(__('Speichern', true));