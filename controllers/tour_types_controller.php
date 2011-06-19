<?php
class TourTypesController extends AppController
{
	var $name = 'TourTypes';

	function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('init');
	}

	function init()
	{
		$this->TourType->init();
		die;
	}
}