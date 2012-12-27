Hallo <?php echo $tourParticipation['TourParticipation']['firstname']; ?>!

Der/die TourenleiterIn hat die Tour "<?php echo $tour['Tour']['title']?>" (<?php echo $tour['TourGroup']['tourgroupname']; ?>) abgesagt.
<?php if(!empty($message)): ?>

Persönliche Mitteilung:
--------------------------------------------------------------------------------
<?php echo $message; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Dein Tourenangebot Team