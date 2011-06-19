<?php
class ConditionalRequisitesController extends AppController
{
	var $name = 'ConditionalRequisites';

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('init');
	}

	function init()
	{
		$this->ConditionalRequisite->init();
	}
}