Hallo!

Diese Touren wurden zuletzt angepasst. Bitte prüfen und freigeben:

<?php foreach($msgData as $key => $msgDataEntry) {
 	echo sprintf('%d. "%s" geändert: %s Status: %s' , $key + 1, $msgDataEntry['Tour']['title'],  date('d.m.Y H:i', strtotime($msgDataEntry['Tour']['modified'])), $msgDataEntry['TourStatus']['statusname'] ) . chr(10);
 	echo 'Tourenlink: ' . Router::url(array('controller' => 'tours', 'action' => 'edit', $msgDataEntry['Tour']['id']), true) . chr(10); 
 	echo chr(10);
 }?>

Dein Tourenangebot Team