Hallo <?php echo $tourParticipation['User']['username']; ?>!

Der Tourenleiter hat die Tour "<?php echo $tour['Tour']['title']?>" abgesagt.
<?php if(!empty($message)): ?>

Meitteilung des Tourenleiters:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team