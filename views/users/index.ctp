<?php
$this->set('title_for_layout', __('Benutzer', true));
$this->Html->addCrumb(__('Benutzer', true));

$tableHeaders = array(
	$this->Paginator->sort(__('Aktiv', true), 'User.active'),
	$this->Paginator->sort(__('Benutzername', true), 'User.username'),
	$this->Paginator->sort(__('E-Mail-Adresse', true), 'User.email'),
	$this->Paginator->sort(__('Letzter Login', true), 'User.last_login'),
	__('Aktionen', true)
);

$userCells = array();
foreach($users as $user)
{
	$userCells[] = array(
		$this->Display->displayFlag($user['User']['active']),
		$user['User']['username'],
		$user['User']['email'],
		$user['User']['last_login'],
		$this->Html->link(__('Bearbeiten', true), array('action' => 'edit', $user['User']['id']))
	);
}

echo $this->Widget->table($tableHeaders, $userCells);

echo $this->element('paginator');