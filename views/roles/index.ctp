<?php
$this->set('title_for_layout', __('Rollen', true));
$this->Html->addCrumb(__('Rollen', true));

$tableHeaders = array(__('Rolle', true), __('Aktionen', true));

$roleCells = array();
foreach($roles as $role)
{
	$roleCells[] = array(
		$role['Role']['rolename'],
		$this->Html->link(__('Bearbeiten', true), array('action' => 'edit', $role['Role']['id']))
	);
}

echo $this->Widget->table($tableHeaders, $roleCells);