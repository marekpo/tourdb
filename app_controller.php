<?php
class AppController extends Controller
{
	var $components = array('DebugKit.Toolbar');

	function beforeFilter()
	{
		$this->__setupEmail();
	}

	function __setupEmail()
	{
		if(isset($this->Email))
		{
			$this->Email->from = 'TourDB <tourdb@localhost.ch>';
			$this->Email->sendAs = 'text';
			$this->Email->delivery = 'smtp';
			$this->Email->smtpOptions = array(
				'port' => 25,
				'timeout' => 30,
				'host' => 'localhost',
			);
		}
	}
}