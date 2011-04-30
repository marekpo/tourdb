<?php

echo $this->Form->create();

echo $this->Form->input('User.username', array(
	'label' => __('Benuztername', true),
	'error' => array(
		'alphaNumeric' => __('Der Benutzername darf nur Buchstaben und Zahlen enthalten.', true),
		'isUnique' => __('Der Benutzername ist bereits vergeben.', true),
		'length' => __('Der Benutzername muss zwischen 5 und 15 Zeichen lang sein.', true),
	)
));

echo $this->Form->input('User.email', array(
	'label' => __('E-Mail-Adresse', true),
	'error' => array(
		'email' => __('Gib bitte eine gültige E-Mail-Adresse ein.', true),
		'isUnique' => __('Diese E-Mail-Adresse ist bereits vergeben.', true)
	)
));

echo $this->Form->end(__('Benutzerkonto anlegen', true));