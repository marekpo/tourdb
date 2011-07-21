<?php
$this->set('title_for_layout', __('Benutzerkonto aktivieren', true));
echo $this->Html->tag('h1', __('Benutzerkonto aktivieren', true));

echo $this->Html->para(null, __('Zur Aktivierung deines Benutzerkontos hast du eine E-Mail von uns bekommen.', true));
echo $this->Html->para(null, __('Gib bitte in das untenstehende Feld das in der E-Mail stehende, temporäre Passwort ein.', true));
echo $this->Html->para(null, __('Ausserdem musst du dir ein neues persönliches Passwort ausdenken welches du in die darunterliegenden Felder eingegeben musst.', true));

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