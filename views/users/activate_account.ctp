<?php

printf(__('Hallo %s! Hier kannst du dein Benutzerkonto aktivieren.', true), $username);

echo $this->Form->create('User', array('url' => array($username)));

echo $this->Form->input('User.tempPassword', array(
	'type' => 'password',
	'label' => __('Temporäres Passwort:', true),
	'error' => array(
		'empty' => __('Bitte gebe hier dein temporäres Passwort ein.', true),
		'wrong' => __('Das temporäre Passwort ist falsch', true)
	)
));
echo $this->Form->input('User.newPassword', array(
	'type' => 'password',
	'label' => __('Neues Passwort:', true),
	'error' => array(
		'empty' => __('Bitte gebe hier ein neues Passwort ein.', true)
	)
));
echo $this->Form->input('User.newPasswordRepeat', array(
	'type' => 'password',
	'label' => __('Neues Passwort (Wiederholung):', true),
	'error' => array(
		'mismatch' => __('Die beiden Passwörter stimmen nicht überein.', true)
	)
));


echo $this->Form->end(__('Benutzerkonto aktivieren', true));