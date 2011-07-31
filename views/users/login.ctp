<?php
$this->set('title_for_layout', __('Anmelden', true));
$this->Html->addCrumb(__('Anmelden', true));
?>
<div class="half"><div class="inner">
<?php
echo $this->Html->para(null, __('Hier kannst du dich mit deinem Benutzernamen und deinem Passwort einloggen.', true));

echo $this->Session->flash('auth');

echo $this->Form->create('User', array('action' => 'login'));

echo $this->Form->input('username', array('label' => __('Benutzername', true)));
echo $this->Form->input('password', array('label' => __('Passwort', true), 'type' => 'password'));
echo $this->Form->input('cookie', array('label' => __('Login speichern', true), 'type' => 'checkbox'));

echo $this->Html->link(__('Passwort vergessen', true), array('action' => 'requestNewPassword'), array('class' => 'requestNewPassword'));

echo $this->Form->end(__('Einloggen', true));

?>
</div></div>
<div class="half"><div class="inner">
<?php
	echo $this->Html->para(null, __('Falls du noch nicht über ein persönliches Benutzerkonto verfügst, kann du dir hier eines anlegen.', true));
	echo $this->Html->link(__('Benutzerkonto eröffnen', true), array('action' => 'createAccount'));
?>
</div></div>