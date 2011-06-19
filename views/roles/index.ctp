<?php

$tableHeaders = $this->Html->tableHeaders(array(__('Rolle', true)));

$roleCells = array();
foreach($roles as $role)
{
	$roleCells[] = array(
		$role['Role']['rolename'],
		$this->Html->link(__('Bearbeiten', true), array('action' => 'edit', $role['Role']['id']))
	);
}

echo $this->Html->tag('table', $tableHeaders . $this->Html->tableCells($roleCells));

echo $this->Html->div('', '', array('id' => 'edit_role'));