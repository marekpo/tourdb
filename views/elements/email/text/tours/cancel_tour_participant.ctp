Hallo <?php echo $this->Display->displayUsersFirstName($tourParticipation['User']['username'], $tourParticipation['User']['Profile']); ?>!

Der Tourenleiter hat die Tour "<?php echo $tour['Tour']['title']?>" abgesagt.
<?php if(!empty($message)): ?>

Mitteilung des Tourenleiters:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team