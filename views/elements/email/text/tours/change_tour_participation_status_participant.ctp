Hallo <?php echo $user['User']['username']; ?>!

<?php
	$changeStatusSentence = '';

	switch($tourParticipationStatus['TourParticipationStatus']['key'])
	{
		case TourParticipationStatus::WAITINGLIST:
			$changeStatusSentence = __('%s hat dich auf die Warteliste für die Tour "%s" gesetzt.', true);
			break;
		case TourParticipationStatus::AFFIRMED:
			$changeStatusSentence = __('%s hat deine Teilnahme an der Tour "%s" bestätigt.', true);
			break;
		case TourParticipationStatus::REJECTED:
			$changeStatusSentence = __('%s hat deine Teilnahme an der Tour "%s" abgelehnt.', true);
			break;
		case TourParticipationStatus::CANCELED:
			$changeStatusSentence = __('%s hat deine Anmeldung für die Tour "%s" storniert.', true);
			break;
	}

	$tourGuideName = $this->Display->displayUsersName($tourGuide['TourGuide']['username'], $tourGuide['TourGuide']['Profile']);

	echo sprintf($changeStatusSentence, $tourGuideName, $tour['Tour']['title']);
?>


Tourlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']), true); ?>

<?php if(!empty($message)): ?>

Persönliche Mitteilung vom Tourenleiter:
<?php echo $message; ?>

<?php endif; ?>

Dein Tourenangebot Team