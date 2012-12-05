<?php

App::import('Core', array('Controller', 'Router'));
App::import('Component', 'Email');

class EmailNotifyTask extends Shell {
	
	private $Controller = null;
	private $Email = null;

	public function __construct(&$dispatch) {
		$this->Controller =& new Controller();
		$this->Email =& new EmailComponent(null);
		$this->Email->Controller = $this->Controller;
		parent::__construct($dispatch);
	}

	public function execute() {
	}

	public function sendEmail($to, $subject, $from, $template, $msgData = null, $sendAs = 'text', $cc = null, $bcc = null, $replyTo = null, $return = null, $charset = 'UTF8') {
		
		$this->Email->reset();

		$this->Email->to = $to;
		$this->Email->subject = $subject;
		$this->Email->from = $from;
		$this->Email->template = $template;
		$this->Email->sendAs = $sendAs;
		if(!empty($bcc)) {$this->Email->bcc = (is_array($bcc)) ? $bcc:array($bcc);}
		if(!empty($cc)) {$this->Email->cc = (is_array($cc)) ? $cc:array($cc);}
		$this->Email->replyTo = (empty($replyTo)) ? $from:$replyTo;
		$this->Email->return = (empty($return)) ? $from:$return;
		$this->Email->charset = $charset;
		$this->Email->delivery = 'smtp';
		$this->Email->lineLength = 998;
		$this->Email->smtpOptions = array(
				'port' => 25,
				'timeout' => 30,
				'host' => 'tourdb.ch',
		);
		
		if(isset($msgData) && !empty($msgData)) {
			$this->Controller->set(compact('msgData'));
			$this->Email->send();
		}
	}
}
