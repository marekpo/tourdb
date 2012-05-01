<?php
$actions = array();

if($tour['Tour']['tour_guide_id'] == $this->Session->read('Auth.User.id'))
{
	$actions[] = $this->Html->link(__('Teilnehmerliste exportieren', true), array('action' => 'exportParticipantList', $tour['Tour']['id']), array('class' => 'action exportparticipantlist'));

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED, TourStatus::CARRIED_OUT, TourStatus::NOT_CARRIED_OUT))
		&& time() < strtotime($tour['Tour']['startdate']))
	{
		$actions[] = $this->Html->link(__('Anmeldung schliessen', true), array('action' => 'closeRegistration', $tour['Tour']['id']), array('class' => 'action closeregistration'));
	}

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED))
		&& time() < strtotime($tour['Tour']['startdate']))
	{
		$actions[] = $this->Html->link(__('Tour absagen', true), array('action' => 'cancel', $tour['Tour']['id']), array('class' => 'action cancel'));
	}

	if( time() > strtotime($tour['Tour']['enddate']))
	{
		$actions[] = $this->Html->link(__('Tourenrapport', true), array('action' => 'tourGuideReport', $tour['Tour']['id']), array('class' => 'action tourguidereport'));
	}
	
	
}

if(!empty($actions))
{
	echo $this->Html->div('toureditbar', implode("\n", $actions));
}