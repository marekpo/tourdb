<?php
require 'config/email.php';

App::import('Core', array('Controller'));
App::import('Component', 'Email');

class EmailTask extends Shell
{
	var $Controller = null;
	var $Email = null;

	function __construct(&$dispatch)
	{
		$this->Controller =& new Controller();
		$this->Email =& new EmailComponent(null);
		$this->Email->initialize($this->Controller);
		parent::__construct($dispatch);
	}

	function execute()
	{
	}

	function sendEmail($to, $subject, $template, $msgData = null, $sendAs = 'text', $cc = null, $bcc = null, $replyTo = null, $return = null, $charset = 'UTF-8')
	{
		$this->Email->reset();

		$this->Email->to = $to;
		$this->Email->subject = $subject;
		$this->Email->template = $template;
		$this->Email->sendAs = $sendAs;

		if(!empty($bcc))
		{
			$this->Email->bcc = (is_array($bcc)) ? $bcc : array($bcc);
		}

		if(!empty($cc))
		{
			$this->Email->cc = (is_array($cc)) ? $cc : array($cc);
		}

		$this->Email->replyTo = (empty($replyTo)) ? Configure::read('Email.from') : $replyTo;
		$this->Email->return = (empty($return)) ? Configure::read('Email.from') : $return;

		$this->Email->charset = $charset;

		$this->Email->from = Configure::read('Email.from');
		$this->Email->delivery = Configure::read('Email.delivery');
		$this->Email->lineLength = 998;

		if(Configure::read('Email.delivery') === 'smtp')
		{
			$smtpOptions = array(
				'host' => Configure::read('Email.Smtp.host'),
				'port' => Configure::read('Email.Smtp.port'),
				'timeout' => Configure::read('Email.Smtp.timeout'),
			);

			if(Configure::read('Email.username') != null && Configure::read('Email.password') != null)
			{
				$smtpOptions['username'] = Configure::read('Email.Smtp.username');
				$smtpOptions['password'] = Configure::read('Email.Smtp.password');
			}

			$this->Email->smtpOptions = $smtpOptions;
		}

		$this->Controller->set(compact('msgData'));
		$this->Email->send();
	}
}