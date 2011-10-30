Hallo <?php echo $user['User']['username']; ?>!

Deine Anmeldung zur Tour "<?php echo $tour['Tour']['title']; ?>" wurde gespeichert.

Hier noch einmal zusammenfassend die wichtigsten Daten über die Tour:

Titel: <?php echo $tour['Tour']['title']; ?>

Datum: <?php
	echo ($tour['Tour']['startdate'] == $tour['Tour']['enddate']
		? $this->Time->format('d.m.Y', $tour['Tour']['startdate'])
		: sprintf('%s - %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']), $this->Time->format('d.m.Y', $tour['Tour']['enddate']))); ?>

Typ der Tour: <?php
	$tourTypes = array();

	foreach($tour['TourType'] as $tourType)
	{
		$tourTypes[] = $tourType['title'];
	}

	echo implode(', ', $tourTypes); ?>

Tourenlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']), true); ?>


Deine Anmeldung gilt bis zur endgültigen Bestätigung durch den Tourenleiter nur
als vorläufig. Solltest du in den nächsten Tagen keine Nachricht vom Tourenleiter
erhalten, nimm bitte direkt mit ihm/ihr Kontakt auf:

Name: <?php echo $this->TourDisplay->getTourGuide($tour); ?>

Telefon: <?php echo $tour['TourGuide']['Profile']['phoneprivate']; ?>

E-Mail: <?php echo $tour['TourGuide']['email']; ?>


Dein Tourenangebot Team