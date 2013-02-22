Hallo <?php echo $tourParticipation['TourParticipation']['firstname']; ?>!

<?php
	$changeStatusSentence = '';

	switch($tourParticipation['TourParticipationStatus']['key'])
	{
		case TourParticipationStatus::WAITINGLIST:
			$changeStatusSentence = __('%s hat dich auf die Warteliste für die Tour "%s" (%s) gesetzt.', true);
			break;
		case TourParticipationStatus::AFFIRMED:
			$changeStatusSentence = __('%s hat deine Teilnahme an der Tour "%s" (%s) bestätigt.', true);
			break;
		case TourParticipationStatus::REJECTED:
			$changeStatusSentence = __('%s hat deine Teilnahme an der Tour "%s" (%s) abgelehnt.', true);
			break;
		case TourParticipationStatus::CANCELED:
			$changeStatusSentence = __('%s hat deine Anmeldung für die Tour "%s" (%s) storniert.', true);
			break;
	}

	$tourGuideName = $this->Display->displayUsersFullName($tourParticipation['Tour']['TourGuide']['username'], $tourParticipation['Tour']['TourGuide']['Profile']);

	echo sprintf($changeStatusSentence, $tourGuideName, $tourParticipation['Tour']['title'], $tourParticipation['Tour']['TourGroup']['tourgroupname']);
?>


Benutze bitte für Rückfragen die E-Mail-Adresse <?php echo $tourParticipation['Tour']['TourGuide']['email']; ?>.

Tourlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id']), true); ?>

<?php if(!empty($message)): ?>

Persönliche Mitteilung vom Tourenleiter:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team