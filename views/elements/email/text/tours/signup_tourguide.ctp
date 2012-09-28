Hallo <?php echo $this->Display->displayUsersFirstName($tour['TourGuide']['username'], $tour['TourGuide']['Profile']); ?>!

Ein(e) Teilnehmer(in) hat sich für die Tour "<?php echo $tour['Tour']['title']; ?>" (<?php echo $tour['TourGroup']['tourgroupname']; ?>)
<?php
	echo ($tour['Tour']['startdate'] == $tour['Tour']['enddate']
		? sprintf('am %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']))
		: sprintf('vom %s - %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']), $this->Time->format('d.m.Y', $tour['Tour']['enddate'])));
?> provisorisch angemeldet:

Kontakt
-------
Name: <?php printf('%s %s', $user['Profile']['firstname'], $user['Profile']['lastname']); ?>

Adresse: <?php printf('%s %s', $user['Profile']['street'], $user['Profile']['housenumber']); ?>

PLZ/Ort: <?php printf('%s %s', $user['Profile']['zip'], $user['Profile']['city']); ?>

Land: <?php echo $user['Profile']['Country']['name']; ?>

Telefon: <?php echo $user['Profile']['phoneprivate']; ?>
<?php if(!empty($user['Profile']['cellphone'])): ?>

Mobil: <?php echo $user['Profile']['cellphone']; ?>
<?php endif;?>
<?php if(!empty($user['Profile']['phonebusiness'])): ?>

Telefon (G): <?php echo $user['Profile']['phonebusiness']; ?>
<?php endif;?>

E-Mail: <?php echo $user['User']['email']; ?>


SAC Mitglied: <?php echo $this->Display->displaySacMember($user['Profile']['sac_member']); ?>

Hauptsektion: <?php echo (empty($user['Profile']['sac_main_section_id']) ? __('Keine', true) : $user['Profile']['SacMainSection']['title']); ?>

<?php if(!empty($user['Profile']['sac_additional_section1_id'])): ?>
Zweitsektion: <?php echo $user['Profile']['SacAdditionalSection1']['title'] ?>
<?php endif; ?>

Notfallkontakt
-------------
Adresse: <?php echo $user['Profile']['emergencycontact1_address']; ?>

Telefon: <?php echo $user['Profile']['emergencycontact1_phone']; ?>

E-Mail: <?php echo $user['Profile']['emergencycontact1_email']; ?>


Erfahrung
---------
Einsetzbar als Seilschaftsführer: <?php echo $this->Display->displayYesNoDontKnow($user['Profile']['experience_rope_guide']); ?>

Kenntnisse in Knotentechnik: <?php echo $this->Display->displayExperience($user['Profile']['experience_knot_technique']); ?>

Kenntnisse in Seilhandhabung: <?php echo $this->Display->displayExperience($user['Profile']['experience_rope_handling']); ?>

Lawinenausbildung: <?php echo $this->Display->displayExperience($user['Profile']['experience_avalanche_training']); ?>

Kletterniveau im Vorstieg: <?php echo (empty($user['Profile']['lead_climb_niveau_id']) ? __('Keine Erfahrung', true) : $user['Profile']['LeadClimbNiveau']['name']); ?>

Kletterniveau im Nachstieg: <?php echo (empty($user['Profile']['second_climb_niveau_id']) ? __('Keine Erfahrung', true) : $user['Profile']['SecondClimbNiveau']['name']); ?>

Alpin-Hochtourenniveau: <?php echo (empty($user['Profile']['alpine_tour_niveau_id']) ? __('Keine Erfahrung', true) : $user['Profile']['AlpineTourNiveau']['name']); ?>

Skitourenniveau: <?php echo (empty($user['Profile']['ski_tour_niveau_id']) ? __('Keine Erfahrung', true) : $user['Profile']['SkiTourNiveau']['name']); ?>

<?php if(!empty($tourParticipation['TourParticipation']['note_participant'])): ?>

Anmeldenotiz vom Teilnehmer:
--------------------------------------------------------------------------------
<?php echo $tourParticipation['TourParticipation']['note_participant']; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Der/die Teilnehmer(in) hat eine E-Mail mit der Bestätigung seiner/ihrer provisorischen Anmeldung erhalten. Bitte bearbeite die Anmeldung um den/die Teilnehmer(in) entsprechend über seine/ihre Teilnahme zu informieren.

Tourenlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']), true); ?>


Dein Tourenangebot Team