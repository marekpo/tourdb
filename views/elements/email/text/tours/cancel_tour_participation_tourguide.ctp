Hallo <?php echo $this->Display->displayUsersFirstName($tourParticipation['Tour']['TourGuide']['username'], $tourParticipation['Tour']['TourGuide']['Profile']); ?>!

Der/die TeilnehmerIn <?php printf('%s %s', $tourParticipation['TourParticipation']['firstname'], $tourParticipation['TourParticipation']['lastname']); ?> hat soeben seine Teilnahme an der Tour "<?php echo $tourParticipation['Tour']['title']; ?>" (<?php echo $tourParticipation['Tour']['TourGroup']['tourgroupname']; ?>) storniert.

<?php if(!empty($tourParticipation['TourParticipation']['email'])): ?>
Benutze bitte für Rückfragen die E-Mail-Adresse <?php echo $tourParticipation['TourParticipation']['email']; ?>.
<?php endif; ?>

Tourlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id']), true); ?>

<?php if(!empty($message)): ?>

Persönliche Mitteilung:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team