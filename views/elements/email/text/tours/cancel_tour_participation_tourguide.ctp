Hallo <?php echo $tourParticipationInfo['Tour']['TourGuide']['username']; ?>!

Der Teilnehmer <?php echo $this->Display->displayUsersName($tourParticipationInfo['User']['username'], $tourParticipationInfo['User']['Profile']); ?> 
hat soeben seine Teilnahme an der Tour "<?php echo $tourParticipationInfo['Tour']['title']; ?>" storniert.

Tourlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tourParticipationInfo['Tour']['id']), true); ?>

<?php if(!empty($message)): ?>

Persönliche Meitteilung des Teilnehmers:
<?php echo $message; ?>

<?php endif; ?>

Dein Tourenangebot Team