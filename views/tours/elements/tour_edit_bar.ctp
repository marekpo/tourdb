<?php
$actions = array();

if($tour['Tour']['tour_guide_id'] == $this->Session->read('Auth.User.id'))
{
	if(!in_array($tour['TourStatus']['key'], array(TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED, TourStatus::CARRIED_OUT))
		&& time() < strtotime($tour['Tour']['startdate']))
	{
		$actions[] = $this->Html->link(__('Anmeldung schliessen', true), array('action' => 'closeRegistration', $tour['Tour']['id']), array('class' => 'closeregistration'));
	}

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED))
		&& time() < strtotime($tour['Tour']['startdate']))
	{
		$actions[] = $this->Html->link(__('Tour absagen', true), array('action' => 'cancel', $tour['Tour']['id']), array('class' => 'cancel'));
	}

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED, TourStatus::CARRIED_OUT))
		&& time() > strtotime($tour['Tour']['enddate']))
	{
		$actions[] = $this->Html->link(__('Tour wurde durchgeführt', true), array('action' => 'carriedOut', $tour['Tour']['id']), array('class' => 'carriedout'));
	}
}

if(!empty($actions))
{
	echo $this->Html->div('toureditbar', implode("\n", $actions));
}