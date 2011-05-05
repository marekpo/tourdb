<?php

echo $this->Form->create('User', array('action' => 'login'));

echo $this->Form->input('username', array('label' => __('Benutzername', true)));
echo $this->Form->input('password', array('label' => __('Passwort', true), 'type' => 'password'));

echo $this->Form->end(__('Einloggen', true));