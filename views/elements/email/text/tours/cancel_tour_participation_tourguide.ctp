Hallo <?php echo $this->Display->displayUsersFirstName($tourParticipationInfo['Tour']['TourGuide']['username'], $tourParticipationInfo['Tour']['TourGuide']['Profile']); ?>!

Der Teilnehmer <?php echo $this->Display->displayUsersFullName($tourParticipationInfo['User']['username'], $tourParticipationInfo['User']['Profile']); ?> hat soeben seine Teilnahme an der Tour "<?php echo $tourParticipationInfo['Tour']['title']; ?>" storniert.

Benutze bitte für Rückfragen die E-Mail-Adresse <?php echo $tourParticipationInfo['User']['email']; ?>.

Tourlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tourParticipationInfo['Tour']['id']), true); ?>

<?php if(!empty($message)): ?>

Persönliche Mitteilung des Teilnehmers:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team