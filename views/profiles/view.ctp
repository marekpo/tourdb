<?php
$title = sprintf(__('Benutzerprofil von %s', true), $this->Display->displayUsersFullName($profile['User']['username'], $profile['Profile']));

$this->set('title_for_layout', $title);
$this->Html->addCrumb($title);

