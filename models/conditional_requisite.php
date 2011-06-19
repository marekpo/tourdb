<?php
class ConditionalRequisite extends AppModel
{
	var $name = 'ConditionalRequisite';

	var $hasAndBelongsToMany = array('Tour');

	function init()
	{
		$conditionalRequisites = array(
			array('acronym' => 'A'),
			array('acronym' => 'B'),
			array('acronym' => 'C')
		);

		$this->deleteAll(array('1' => '1'));

		foreach($conditionalRequisites as $conditionalRequisite)
		{
			$this->create();
			$this->save(array('ConditionalRequisite' => $conditionalRequisite));
		}
	}
}