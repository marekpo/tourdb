Hallo <?php echo $this->Display->displayUsersFirstName($tour['TourGuide']['username'], $tour['TourGuide']['Profile']); ?>!

In zwischen ist einige Zeit vergangen seit dem deine Tour "<?php echo $tour['Tour']['title']; ?>" durchgeführt werden sollte.

Uns ist der aktuelle Status leider nicht bekannt, weil wir den Tourenrapport von dir noch nicht erhalten haben.

Bitte erstelle ein Tourenrapport und verschicke es an die bekannte E-Mail Adresse in nur 3 Schritten:

1) Klicke einfach auf folgedes Link:
<?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']), true); ?>

Logge dich ein, falls du dich vorher nicht eingeloggt hast. Die Tourendetailseite erscheint.

2) Per Aktion "Tourenrapport erstellen", kannst du ganz bequem alle Eingaben erfassen.

3) Und danach per Aktion "Tourenrapport exportieren" kannst du Rapport als XLS Datei bei dir ablegen (herunterladen)

4) Mit deinem E-Mail Programm kannst du den Tourenrapport verschicken. E-Mail Adresse ist in Tourenrapport angedruckt.


Danke für deine Mithilfe!

Dein Tourenangebot Team
