<?php
echo $this->Html->nestedList(array(
	'privilege1', 'privilege2', 'privilege3', 'privilege4', 'privilege5'
), array('id' => 'available-privileges'), array('class' => 'privilege'));

echo $this->Html->nestedList(array(
	'privilege6', 'privilege7', 'privilege8', 'privilege9', 'privilege0'
), array('id' => 'associated-privileges'), array('class' => 'privilege'));

$this->Js->get('#available-privileges');
$this->Js->drop(array('accept' => '#associated-privileges > li', 'drop' => 'removePrivilege(ui.draggable);'));
$this->Js->sortable();

$this->Js->get('#associated-privileges');
$this->Js->drop(array('accept' => '#available-privileges > li', 'drop' => 'addPrivilege(ui.draggable);'));
$this->Js->sortable();

$this->Js->get('.privilege');
$this->Js->drag(array('revert' => 'invalid', 'helper' => 'clone'));

$this->Js->buffer("
	function addPrivilege(item)
	{
		item.detach().appendTo($('#associated-privileges'));
	}

	function removePrivilege(item)
	{
		item.detach().appendTo($('#available-privileges'));
	}
");