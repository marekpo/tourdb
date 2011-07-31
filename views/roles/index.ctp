<?php
$this->set('title_for_layout', __('Rollen', true));
$this->Html->addCrumb(__('Rollen', true));

$tableHeaders = $this->Html->tableHeaders(array(
	__('Rolle', true), __('Aktionen', true)
));

$roleCells = array();
foreach($roles as $role)
{
	$roleCells[] = array(
		$role['Role']['rolename'],
		$this->Html->link(__('Bearbeiten', true), array('action' => 'edit', $role['Role']['id']))
	);
}

echo $this->Html->tag('table', $tableHeaders . $this->Html->tableCells($roleCells), array('class' => 'roles list'));