Hallo <?php echo $tourParticipation['User']['username']; ?>!

Der Tourenleiter hat die Tour "<?php echo $tour['Tour']['title']?>" abgesagt.
<?php if(!empty($message)): ?>

Mitteilung des Tourenleiters:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team