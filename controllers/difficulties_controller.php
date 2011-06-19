<?php
class DifficultiesController extends AppController
{
	var $name = 'Difficulties';

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('init');
	}

	function init()
	{
		$this->Difficulty->init();
	}
}