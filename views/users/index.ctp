<?php
$this->set('title_for_layout', __('Benutzer', true));
$this->Html->addCrumb(__('Benutzer', true));

$tableHeaders = $this->Html->tableHeaders(array(
	$this->Paginator->sort(__('Aktiv', true), 'active'),
	$this->Paginator->sort(__('Benutzername', true), 'username'),
	$this->Paginator->sort(__('E-Mail-Adresse', true), 'email'),
	$this->Paginator->sort(__('Letzter Login', true), 'last_login'),
	__('Aktionen', true)
));

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

echo $this->Html->tag('table', $tableHeaders . $this->Html->tableCells($userCells), array('class' => 'users list'));

echo $this->element('paginator');