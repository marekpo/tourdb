Hallo <?php echo $this->Display->displayUsersFirstName($tourParticipation['Tour']['TourGuide']['username'], $tourParticipation['Tour']['TourGuide']['Profile']); ?>!

Ein(e) Teilnehmer(in) hat sich für die Tour "<?php echo $tourParticipation['Tour']['title']; ?>" (<?php echo $tourParticipation['Tour']['TourGroup']['tourgroupname']; ?>)
<?php
	echo ($tourParticipation['Tour']['startdate'] == $tourParticipation['Tour']['enddate']
		? sprintf('am %s', $this->Time->format('d.m.Y', $tourParticipation['Tour']['startdate']))
		: sprintf('vom %s - %s', $this->Time->format('d.m.Y', $tourParticipation['Tour']['startdate']), $this->Time->format('d.m.Y', $tourParticipation['Tour']['enddate'])));
?> provisorisch angemeldet:

Kontakt
-------
Name: <?php printf('%s %s', $tourParticipation['TourParticipation']['firstname'], $tourParticipation['TourParticipation']['lastname']); ?>

Adresse: <?php printf('%s %s', $tourParticipation['TourParticipation']['street'], $tourParticipation['TourParticipation']['housenumber']); ?>

PLZ/Ort: <?php printf('%s %s', $tourParticipation['TourParticipation']['zip'], $tourParticipation['TourParticipation']['city']); ?>

Land: <?php echo $tourParticipation['Country']['name']; ?>

Telefon: <?php echo $tourParticipation['TourParticipation']['phoneprivate']; ?>
<?php if(!empty($tourParticipation['TourParticipation']['cellphone'])): ?>

Mobil: <?php echo $tourParticipation['TourParticipation']['cellphone']; ?>
<?php endif;?>
<?php if(!empty($tourParticipation['TourParticipation']['phonebusiness'])): ?>

Telefon (G): <?php echo $tourParticipation['TourParticipation']['phonebusiness']; ?>
<?php endif;?>

E-Mail: <?php echo $tourParticipation['TourParticipation']['email']; ?>


SAC Mitglied: <?php echo $this->Display->displaySacMember($tourParticipation['TourParticipation']['sac_member']); ?>

Hauptsektion: <?php echo (empty($tourParticipation['TourParticipation']['sac_main_section_id']) ? __('Keine', true) : $tourParticipation['SacMainSection']['title']); ?>

<?php if(!empty($tourParticipation['TourParticipation']['sac_additional_section1_id'])): ?>
Zweitsektion: <?php echo $tourParticipation['SacAdditionalSection1']['title'] ?>
<?php endif; ?>

Notfallkontakt
-------------
Adresse: <?php echo $tourParticipation['TourParticipation']['emergencycontact1_address']; ?>

Telefon: <?php echo $tourParticipation['TourParticipation']['emergencycontact1_phone']; ?>

E-Mail: <?php echo $tourParticipation['TourParticipation']['emergencycontact1_email']; ?>


Erfahrung
---------
Einsetzbar als Seilschaftsführer: <?php echo $this->Display->displayYesNoDontKnow($tourParticipation['TourParticipation']['experience_rope_guide']); ?>

Kenntnisse in Knotentechnik: <?php echo $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_knot_technique']); ?>

Kenntnisse in Seilhandhabung: <?php echo $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_rope_handling']); ?>

Lawinenausbildung: <?php echo $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_avalanche_training']); ?>

Kletterniveau im Vorstieg: <?php echo (empty($tourParticipation['TourParticipation']['lead_climb_niveau_id']) ? __('Keine Erfahrung', true) : $tourParticipation['LeadClimbNiveau']['name']); ?>

Kletterniveau im Nachstieg: <?php echo (empty($tourParticipation['TourParticipation']['second_climb_niveau_id']) ? __('Keine Erfahrung', true) : $tourParticipation['SecondClimbNiveau']['name']); ?>

Alpin-Hochtourenniveau: <?php echo (empty($tourParticipation['TourParticipation']['alpine_tour_niveau_id']) ? __('Keine Erfahrung', true) : $tourParticipation['AlpineTourNiveau']['name']); ?>

Skitourenniveau: <?php echo (empty($tourParticipation['TourParticipation']['ski_tour_niveau_id']) ? __('Keine Erfahrung', true) : $tourParticipation['SkiTourNiveau']['name']); ?>

<?php if(!empty($tourParticipation['TourParticipation']['note_participant'])): ?>

Anmeldenotiz:
--------------------------------------------------------------------------------
<?php echo $tourParticipation['TourParticipation']['note_participant']; ?>

--------------------------------------------------------------------------------
<?php endif; ?>

Der/die TeilnehmerIn hat eine E-Mail mit der Bestätigung seiner/ihrer provisorischen Anmeldung erhalten. Bitte bearbeite die Anmeldung um den/die TeilnehmerIn entsprechend über seine/ihre Teilnahme zu informieren.

Tourenlink: <?php echo $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id']), true); ?>


Dein Tourenangebot Team