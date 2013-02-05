Hallo <?php echo $tourParticipation['TourParticipation']['firstname']; ?>!

<?php echo $this->TourDisplay->getTourGuide($tourParticipation); ?> hat deine Anmeldung zur Tour "<?php echo $tourParticipation['Tour']['title']; ?>" (<?php echo $tourParticipation['Tour']['TourGroup']['tourgroupname']; ?>) gespeichert.

Hier noch einmal zusammenfassend die wichtigsten Daten über die Tour:

Titel: <?php echo $tourParticipation['Tour']['title']; ?>

Datum: <?php
	echo ($tourParticipation['Tour']['startdate'] == $tourParticipation['Tour']['enddate']
		? $this->Time->format('d.m.Y', $tourParticipation['Tour']['startdate'])
		: sprintf('%s - %s', $this->Time->format('d.m.Y', $tourParticipation['Tour']['startdate']), $this->Time->format('d.m.Y', $tourParticipation['Tour']['enddate']))); ?>

Typ der Tour: <?php
	$tourTypes = array();

	foreach($tourParticipation['Tour']['TourType'] as $tourType)
	{
		$tourTypes[] = $tourType['title'];
	}

	echo implode(', ', $tourTypes); ?>

Tourenlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id']), true); ?>


Deine Anmeldung gilt bis zur endgültigen Bestätigung durch den/die TourenleiterIn nur als vorläufig. Solltest du in den nächsten Tagen keine Nachricht vom/von der TourenleiterIn erhalten, nimm bitte direkt mit ihm/ihr Kontakt auf:

Name: <?php echo $this->TourDisplay->getTourGuide($tourParticipation); ?>

Telefon: <?php echo $tourParticipation['Tour']['TourGuide']['Profile']['phoneprivate']; ?>

E-Mail: <?php echo $tourParticipation['Tour']['TourGuide']['email']; ?>


Hinweis: Die Ausrüstungslisten für Wanderungen, Sommer- und Wintertouren findest du im Internet www.sac-albis.ch/service/dokumente/checklisten/

Dein Tourenangebot Team