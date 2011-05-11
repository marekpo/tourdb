<?php
echo $this->Session->flash('auth');

echo $this->Form->create('User', array('action' => 'login'));

echo $this->Form->input('username', array('label' => __('Benutzername', true)));
echo $this->Form->input('password', array('label' => __('Passwort', true), 'type' => 'password'));
echo $this->Form->input('cookie', array('label' => __('Login speichern', true), 'type' => 'checkbox'));

echo $this->Form->end(__('Einloggen', true));

echo $this->Html->link(__('Benutzerkonto eröffnen', true), array('action' => 'createAccount'));