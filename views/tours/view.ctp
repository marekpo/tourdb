<?php
$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

echo $this->element('../tours/elements/tour_edit_bar', array('tour' => $tour));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('TourenleiterIn', true))
			. $this->Html->div('content', $this->TourDisplay->getTourGuide($tour))
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Datum', true))
			. $this->Html->div('content',sprintf('%s [%s]', $this->Display->getDateRangeText($tour['Tour']['startdate'], $tour['Tour']['enddate'], true), $this->Display->getDayOfWeekText($tour['Tour']['startdate'], $tour['Tour']['enddate'])))
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Anmeldeschluss', true))
			. $this->Html->div('content', $this->TourDisplay->getDeadlineText($tour))
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

$detailedInformation = array();

if(!empty($tour['Tour']['meetingplace']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Treffpunkt', true))
		. $this->Html->div('content', $tour['Tour']['meetingplace'])
	);
}

if(!empty($tour['Tour']['meetingtime']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Zeit', true))
		. $this->Html->div('content', sprintf(__('%s Uhr', true), $this->Time->format('H:i', $tour['Tour']['meetingtime'])))
	);
}

if(!empty($tour['Tour']['transport']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Transportmittel', true))
		. $this->Html->div('content', $this->Display->displayTransport($tour['Tour']['transport']))
	);
}

if(!empty($tour['Tour']['travelcosts']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Reisekosten', true))
		. $this->Html->div('content', sprintf(__('%.2f CHF', true), $tour['Tour']['travelcosts']))
	);
}

if(!empty($tour['Tour']['planneddeparture']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Rückreise (geplant)', true))
		. $this->Html->div('content', $tour['Tour']['planneddeparture'])
	);
}

if(!empty($tour['Tour']['equipment']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Ausrüstung', true))
		. $this->Html->div('content', $this->Display->formatText($tour['Tour']['equipment']))
	);
}

if(!empty($tour['Tour']['maps']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Karten', true))
		. $this->Html->div('content', $tour['Tour']['maps'])
	);
}

if(!empty($tour['Tour']['auxiliarymaterial']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Hilfsmittel', true))
		. $this->Html->div('content', $tour['Tour']['auxiliarymaterial'])
	);
}

if(!empty($tour['Tour']['timeframe']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Zeitrahmen', true))
		. $this->Html->div('content', $tour['Tour']['timeframe'])
	);
}

if(!empty($tour['Tour']['altitudedifference']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Höhendifferenz', true))
		. $this->Html->div('content', $tour['Tour']['altitudedifference'])
	);
}

if(!empty($tour['Tour']['food']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Verpflegung', true))
		. $this->Html->div('content', $tour['Tour']['food'])
	);
}

if(!empty($tour['Tour']['accomodation']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Unterkunft', true))
		. $this->Html->div('content', $tour['Tour']['accomodation'])
	);
}

if(!empty($tour['Tour']['accomodationcosts']))
{
	$detailedInformation[] = $this->Html->div('infoitem',
		$this->Html->div('label', __('Unterkunftskosten', true))
		. $this->Html->div('content', sprintf(__('%.2f CHF', true), $tour['Tour']['accomodationcosts']))
	);
}

if(!empty($tour['Tour']['description']) || !empty($detailedInformation))
{
	echo $this->Html->tag('h2', __('Tourendetails', true));

	echo $this->Display->formatText($tour['Tour']['description']);

	$firstColumn = implode('', array_slice($detailedInformation, 0, ceil(count($detailedInformation) / 2)));
	$secondColumn = implode('', array_slice($detailedInformation, ceil(count($detailedInformation) / 2), floor(count($detailedInformation) / 2)));

	echo $this->Html->div('columncontainer',
		$this->Html->div('half', $firstColumn)
		. $this->Html->div('half', $secondColumn)
	);
}

echo $this->element('../tours/elements/tour_edit_bar', array('tour' => $tour));

if($tour['Tour']['tour_guide_id'] != $this->Session->read('Auth.User.id'))
{
	if($registrationOpen || $currentUserAlreadySignedUp)
	{
		echo $this->Html->tag('h2', __('Anmeldung', true));
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
				$tourParticipationStatusSentence = __('Du bist provisorisch zu dieser Tour angemeldet. Der/die TourenleiterIn muss deine Anmeldung noch bearbeiten.', true);
				break;
			case TourParticipationStatus::WAITINGLIST:
				$tourParticipationStatusSentence = __('Du bist bereits für diese Tour angemeldet. Der/die TourenleiterIn hat dich auf die Warteliste gesetzt.', true);
				break;
			case TourParticipationStatus::AFFIRMED:
				$tourParticipationStatusSentence = __('Du bist bereits für diese Tour angemeldet und der/die TourleiterIn hat deine Teilnahme bestätigt.', true);
				break;
			case TourParticipationStatus::REJECTED:
				$tourParticipationStatusSentence = __('Du hattest dich für diese Tour angemeldet, aber der/die TourleiterIn hat deine Teilnahme abgelehnt.', true);
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
				echo $this->Html->para('', __('Falls du doch nicht an der Tour teilnehmen kannst, wende dich bitte direkt an den/die TourenleiterIn. Seine Kontaktdaten findest du in der E-Mail, die dir bei der Anmeldung zugegangen ist.', true));
			}
		}
	}
}

if($tourParticipations)
{
	echo $this->Html->tag('h2', __('Anmeldungen', true));

	$tableHeaders = array(
		$this->Paginator->sort(__('TeilnehmerIn', true), 'TourParticipation.firstname'),
		__('Erfasser', true),
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
		$signupUser = '';
		if($tourParticipation['TourParticipation']['signup_user_id'] == $this->Session->read('Auth.User.id'))
		{
			$signupUser = __('Ich', true);
		}
		elseif($tourParticipation['TourParticipation']['signup_user_id'] != $tourParticipation['TourParticipation']['user_id'])
		{
			$signupUser = $this->Display->displayUsersFullName($tourParticipation['SignupUser']['username'], $tourParticipation['SignupUser']['Profile']);
		}

		$row = array(
			$this->Html->link(
				sprintf('%s %s', $tourParticipation['TourParticipation']['firstname'], $tourParticipation['TourParticipation']['lastname']),
				array('controller' => 'tour_participations', 'action' => 'view', $tourParticipation['TourParticipation']['id'])
			),
			$signupUser,
			$this->Time->format('d.m.Y', $tourParticipation['TourParticipation']['created']),
			$tourParticipation['TourParticipationStatus']['statusname']
		);

		if(!in_array($tour['TourStatus']['key'], array(TourStatus::CANCELED, TourStatus::CARRIED_OUT, TourStatus::NOT_CARRIED_OUT)))
		{
			$actionLinks = array();

			$actionLinks[] = $this->Authorization->link('', array('controller' => 'tour_participations', 'action' => 'changeStatus', $tourParticipation['TourParticipation']['id']), array('class' => 'iconaction changestatus', 'title' => __('Status ändern', true)));
			$actionLinks[] = $this->Authorization->link('', array('controller' => 'tour_participations', 'action' => 'edit', $tourParticipation['TourParticipation']['id']), array('class' => 'iconaction edit', 'title' => __('Anmeldung bearbeiten', true)));

			$row[] = implode(' ', $actionLinks);
		}

		$tableCells[] = $row;
	}

	echo $this->Widget->table($tableHeaders, $tableCells);
	$this->Js->buffer(sprintf("$('.changestatus').click({ id: 'changeTourparticipationStatusDialog', title: '%s' }, TourDB.Util.confirmationDialog);", __('Anmeldestatus ändern', true)));
}

$this->Js->buffer(sprintf("$('.tours .action.closeregistration').click({ id: 'closeRegistrationConfirmationDialog', title: '%s'}, TourDB.Util.confirmationDialog);", __('Anmeldung schliessen', true)));
$this->Js->buffer(sprintf("$('.tours .action.reopenregistration').click({ id: 'reopenRegistrationConfirmationDialog', title: '%s'}, TourDB.Util.confirmationDialog);", __('Anmeldung wiedereröffnen', true)));
$this->Js->buffer(sprintf("$('.tours .action.cancel').click({ id: 'cancelConfirmationDialog', title: '%s'}, TourDB.Util.confirmationDialog);", __('Tour absagen', true)));