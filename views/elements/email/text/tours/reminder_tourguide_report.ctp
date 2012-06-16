Hallo <?php echo $this->Display->displayUsersFirstName($tour['TourGuide']['username'], $tour['TourGuide']['Profile']); ?>!

Inzwischen ist einige Zeit vergangen seit dem deine Tour "<?php echo $tour['Tour']['title']; ?>" durchgeführt werden sollte.

Uns ist der aktuelle Status leider nicht bekannt, weil wir den Tourenrapport von dir noch nicht erhalten haben.

Bitte erstelle einen Tourenrapport und verschicke ihn an die bekannte E-Mail Adresse in nur 4 Schritten:

1) Klicke einfach auf folgenden Link:
   <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']), true); ?>

   Logge dich ein, falls du noch nicht eingeloggt bist. Die Tourendetailseite erscheint.

2) Per Aktion "Tourenrapport erstellen", kannst du ganz bequem alle Eingaben erfassen.

3) Danach kannst du den Tourenrapport mit der Funktion "Tourenrapport exportieren" als XLS-Datei herunterladen.

4) Mit deinem E-Mail Programm kannst du den Tourenrapport verschicken. Die E-Mail Adresse ist im Tourenrapport angedruckt.


Danke für deine Mithilfe!

Dein Tourenangebot Team