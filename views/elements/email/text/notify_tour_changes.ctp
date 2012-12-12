Hallo!

Diese Touren wurden zuletzt angepasst. Bitte prüfen und freigeben:

<?php
foreach($msgData as $key => $msgDataEntry)
{
?>
<?php echo $key + 1; ?>. "<?php echo $msgDataEntry['Tour']['title']; ?>" geändert: <?php echo date('d.m.Y H:i', strtotime($msgDataEntry['Tour']['modified'])); ?> Status: <?php $msgDataEntry['TourStatus']['statusname']; ?>

Tourenlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'edit', $msgDataEntry['Tour']['id']), true); ?>
<?php
}
?>


Dein Tourenangebot Team