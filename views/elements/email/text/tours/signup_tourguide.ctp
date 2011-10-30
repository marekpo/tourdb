Hallo <?php echo $tour['TourGuide']['username']; ?>!

Ein(e) Teilnehmer(in) hat sich für die Tour "<?php echo $tour['Tour']['title']; ?>"
<?php
	echo ($tour['Tour']['startdate'] == $tour['Tour']['enddate']
		? sprintf('am %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']))
		: sprintf('vom %s - %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']), $this->Time->format('d.m.Y', $tour['Tour']['enddate'])));
?> provisorisch angemeldet:

Name: <?php printf('%s %s', $user['Profile']['firstname'], $user['Profile']['lastname']); ?>

Adresse: <?php printf('%s %s', $user['Profile']['street'], $user['Profile']['housenumber']); ?>

PLZ/Ort: <?php printf('%s %s', $user['Profile']['zip'], $user['Profile']['city']); ?>

Land: <?php echo $user['Profile']['Country']['name']; ?>

Telefon: <?php echo $user['Profile']['phoneprivate']; ?>

E-Mail: <?php echo $user['User']['email']; ?>


Notallkontakt
-------------
Adresse: <?php echo $user['Profile']['emergencycontact1_address']; ?>

Telefon: <?php echo $user['Profile']['emergencycontact1_phone']; ?>

E-Mail: <?php echo $user['Profile']['emergencycontact1_email']; ?>


Der/die Teilnehmer(in) hat eine E-Mail mit der Bestätigung seiner/ihrer provisorischen
Anmeldung erhalten. Bitte bearbeite die Anmeldung um den/die Teilnehmer(in) entsprechend
über seine/ihre Teilnahme zu informieren.

Dein Tourenangebot Team