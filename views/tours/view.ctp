<?php
$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

echo $this->element('../tours/elements/tour_edit_bar', array('tour' => $tour));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Tourenleiter', true))
			. $this->Html->div('content', $this->TourDisplay->getTourGuide($tour))
		).
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Datum', true))
			. $this->Html->div('content', 
				($tour['Tour']['startdate'] == $tour['Tour']['enddate']
					? $this->Time->format('d.m.Y', $tour['Tour']['startdate'])
					: sprintf('%s - %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']), $this->Time->format('d.m.Y', $tour['Tour']['enddate'])))
			)
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Anmeldeschluss', true))
			. $this->Html->div('content', $this->Time->format('d.m.Y', $tour['Tour']['deadline_calculated']))
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Tourencode', true))
			. $this->Html->div('content', $this->TourDisplay->getClassification($tour))
		)
	)
	. $this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Tourengruppe', true))
			. $this->Html->div('content', $tour['TourGroup']['tourgroupname'])
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Tourenstatus', true))
			. $this->Html->div('content', $tour['TourStatus']['statusname'])
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Tourenwoche', true))
			. $this->Html->div('content', $this->Display->displayFlag($tour['Tour']['tourweek']))
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Bergführer', true))
			. $this->Html->div('content', $this->Display->displayFlag($tour['Tour']['withmountainguide']))
		)
	)
);

echo $this->Html->tag('h2', __('Tourendetails', true));

echo $this->Display->formatText($tour['Tour']['description']);

echo $this->element('../tours/elements/tour_edit_bar', array('tour' => $tour));

if($tour['Tour']['tour_guide_id'] != $this->Session->read('Auth.User.id'))
{
	if($registrationOpen || $currentUserAlreadySignedUp || !$tour['Tour']['signuprequired'])
	{
		echo $this->Html->tag('h2', __('Anmeldung', true));
	}

	if(!$tour['Tour']['signuprequired'])
	{
		echo $this->Html->para('', __('Für diese Tour ist keine Anmeldung erforderlich!', true));
	}

	if($registrationOpen && !$currentUserAlreadySignedUp)
	{
		echo $this->Html->div('columncontainer',
			$this->Html->div('third', 
				$this->Form->create(false, array('type' => 'GET', 'url' => array('action' => 'signUp', $tour['Tour']['id'])))
				. $this->Form->submit(__('Zur Tour anmelden', true), array('div' => array('class' => 'submit obtrusive'), 'disabled' => !$this->Session->check('Auth.User')))
				. $this->Form->end()
			)
			. (!$this->Session->check('Auth.User') ? $this->Html->div('twothirds obtrusive text',
				sprintf(__('Um dich zu dieser Tour anmelden zu können, musst du dich %s. Wenn du noch kein Benutzerkonto hast, musst du dir zuerst ein %s.', true),
					$this->Html->link(__('einloggen', true), array('controller' => 'users', 'action' => 'login')),
					$this->Html->link(__('Benutzerkonto anlegen', true), array('controller' => 'users', 'action' => 'createAccount'))
				)
			) : '')
		);
	}

	if($currentUserAlreadySignedUp)
	{
		$tourParticipationStatusSentence = '';
		switch($currentUsersTourParticipation['TourParticipationStatus']['key'])
		{
			case TourParticipationStatus::REGISTERED:
				$tourParticipationStatusSentence = __('Du bist provisorisch zu dieser Tour angemeldet. Der Tourenleiter muss deine Anmeldung noch bearbeiten.', true);
				break;
			case TourParticipationStatus::WAITINGLIST:
				$tourParticipationStatusSentence = __('Du bist bereits für diese Tour angemeldet. Der Tourenleiter hat dich auf die Warteliste gesetzt.', true);
				break;
			case TourParticipationStatus::AFFIRMED:
				$tourParticipationStatusSentence = __('Du bist bereits für diese Tour angemeldet und der Tourleiter hat deine Teilnahme bestätigt.', true);
				break;
			case TourParticipationStatus::REJECTED:
				$tourParticipationStatusSentence = __('Du hattest dich für diese Tour angemeldet, aber der Tourleiter hat deine Teilnahme abgelehnt.', true);
				break;
			case TourParticipationStatus::CANCELED:
				$tourParticipationStatusSentence = __('Du hattest dich für diese Tour angemeldet aber deine Anmeldung wieder storniert.', true);
				break;
		}
	
		echo $this->Html->para('', $tourParticipationStatusSentence);
	
		if(in_array($currentUsersTourParticipation['TourParticipationStatus']['key'], array(TourParticipationStatus::REGISTERED, TourParticipationStatus::WAITINGLIST, TourParticipationStatus::AFFIRMED))
			&& !in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED, TourStatus::CARRIED_OUT)))
		{
			if($mayBeCanceledByUser)
			{
				echo $this->Html->para('', sprintf(__('Falls du doch nicht an der Tour teilnehmen kannst, kannst du deine Anmeldung hier %s.', true), $this->Html->link(__('stornieren', true), array(
					'controller' => 'tour_participations', 'action' => 'cancelTourParticipation', $currentUsersTourParticipation['TourParticipation']['id']
				), array('class' => 'cancelTourParticipation'))));
				$this->Js->buffer(sprintf("$('.cancelTourParticipation').click({ id: 'cancelTourParticipationConfirmationDialog', title: '%s'}, TourDB.Util.confirmationDialog);", __('Touranmeldung stornieren', true)));
			}
			else
			{
				echo $this->Html->para('', __('Falls du doch nicht an der Tour teilnehmen kannst, wende dich bitte direkt an den Tourenleiter. Seine Kontaktdaten findest du in der E-Mail, die dir bei der Anmeldung zugegangen ist.', true));
			}
		}
	}
}

if($tourParticipations)
{
	echo $this->Html->tag('h2', __('Anmeldungen', true));

	$tableHeaders = array(
		__('Benutzer', true),
		$this->Paginator->sort(__('Anmeldedatum', true), 'TourParticipation.created'),
		$this->Paginator->sort(__('Anmeldestatus', true), 'TourParticipationStatus.rank'),
	);

	if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED, TourStatus::CARRIED_OUT)))
	{
		$tableHeaders[] = __('Aktionen', true); 
	}

	$tableCells = array();

	foreach($tourParticipations as $tourParticipation)
	{
		$row = array(
			$this->Html->link(
				$this->Display->displayUsersFullName($tourParticipation['User']['username'], $tourParticipation['User']['Profile']),
				array('controller' => 'profiles', 'action' => 'view', $tourParticipation['User']['id'])
			),
			$this->Time->format('d.m.Y', $tourParticipation['TourParticipation']['created']),
			$tourParticipation['TourParticipationStatus']['statusname']
		);

		if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED, TourStatus::CARRIED_OUT))
				&& $tour['Tour']['tour_guide_id'] == $this->Session->read('Auth.User.id'))
		{
			$row[] = $this->Html->link(__('Status ändern', true), array(
				'controller' => 'tour_participations', 'action' => 'changeStatus', $tourParticipation['TourParticipation']['id']
			), array(
				'class' => 'changeStatus'
			));
		}

		$tableCells[] = $row;
	}

	echo $this->Widget->table($tableHeaders, $tableCells);
	$this->Js->buffer(sprintf("$('.changeStatus').click({ id: 'changeTourparticipationStatusDialog', title: '%s' }, TourDB.Util.confirmationDialog);", __('Anmeldestatus ändern', true)));
}

echo $this->Js->buffer(sprintf("$('.tours .action.closeregistration').click({ id: 'closeRegistrationConfirmationDialog', title: '%s'}, TourDB.Util.confirmationDialog);", __('Anmeldung schliessen', true)));
echo $this->Js->buffer(sprintf("$('.tours .action.cancel').click({ id: 'cancelConfirmationDialog', title: '%s'}, TourDB.Util.confirmationDialog);", __('Tour absagen', true)));