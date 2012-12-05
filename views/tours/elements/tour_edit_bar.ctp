<?php
$actions = array();

if($tour['Tour']['signuprequired'])
{
	$actions[] = $this->Authorization->link(__('Teilnehmerliste exportieren', true), array('action' => 'exportParticipantList', $tour['Tour']['id']), array('class' => 'action exportparticipantlist'));
}

if($tour['Tour']['tour_guide_id'] == $this->Session->read('Auth.User.id'))
{
	$actions[] = $this->Html->link(__('E-Mail an Alle', true), array('action' => 'sendEmailAllSelected', $tour['Tour']['id']), array('class' => 'action sendEmailAllSelected'));

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED, TourStatus::CARRIED_OUT, TourStatus::NOT_CARRIED_OUT))
		&& time() < strtotime($tour['Tour']['startdate'])
		&& $tour['Tour']['signuprequired'])
	{
		$actions[] = $this->Html->link(__('Anmeldung schliessen', true), array('action' => 'closeRegistration', $tour['Tour']['id']), array('class' => 'action closeregistration'));
	}

	if(in_array($tour['TourStatus']['key'], array(TourStatus::REGISTRATION_CLOSED))
			&& time() < strtotime($tour['Tour']['startdate'])
			&& $tour['Tour']['signuprequired'])
	{
		$actions[] = $this->Html->link(__('Anmeldung wiedereröffnen', true), array('action' => 'reopenRegistration', $tour['Tour']['id']), array('class' => 'action reopenregistration'));
	}

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED))
		&& time() < strtotime($tour['Tour']['startdate']))
	{
		$actions[] = $this->Html->link(__('Tour absagen', true), array('action' => 'cancel', $tour['Tour']['id']), array('class' => 'action cancel'));
	}

	if(time() > strtotime($tour['Tour']['enddate']))
	{
		if(!empty($tour['TourGuideReport']['id']))
		{
			$actions[] = $this->Html->link(__('Tourenrapport anpassen', true), array('controller' => 'tour_guide_reports', 'action' => 'edit', $tour['Tour']['id']), array('class' => 'action edit'));
			$actions[] = $this->Html->link(__('Tourenrapport exportieren', true), array('controller' => 'tour_guide_reports', 'action' => 'exportTourguideReport', $tour['Tour']['id']), array('class' => 'action exportTourguideReport'));
		}
		else
		{
			$actions[] = $this->Html->link(__('Tourenrapport erstellen', true), array('controller' => 'tour_guide_reports', 'action' => 'edit', $tour['Tour']['id']), array('class' => 'action edit'));
		}
	}
}

if(!empty($actions))
{
	echo $this->Html->div('toureditbar', implode("\n", $actions));
}