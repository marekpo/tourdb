<?php
$this->set('title_for_layout', __('Benutzerkonto bearbeiten', true));
$this->Html->addCrumb(__('Benutzerkonto bearbeiten', true));

echo $this->Form->create('User');

echo $this->Form->input('User.email', array(
	'label' => __('E-Mail-Adresse', true),
	'error' => array(
		'email' => __('Gib bitte eine gültige E-Mail-Adresse ein.', true),
		'isUnique' => __('Diese E-Mail-Adresse ist bereits vergeben.', true)
	)
));

echo $this->Html->para('', __('Wenn du dein Passwort nicht ändern möchtest lass die folgenden Felder einfach leer.', true));

echo $this->Form->input('User.changedPassword', array(
	'type' => 'password',
	'label' => __('Neues Passwort', true)
));
echo $this->Form->input('User.changedPasswordRepeat', array(
	'type' => 'password',
	'label' => __('Neues Passwort (Wiederholung)', true),
	'error' => array(
		'mismatch' => __('Die beiden Passwörter stimmen nicht überein.', true)
)
));

echo $this->Form->end(__('Speichern', true));