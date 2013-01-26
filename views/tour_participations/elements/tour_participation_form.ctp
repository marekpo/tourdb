<?php
if(!empty($this->data['TourParticipation']['id']))
{
	echo $this->Form->hidden('TourParticipation.id');
}
?>
<div class="tourparticipations">
  <fieldset>
    <legend><?php __('Kontaktdaten'); ?></legend>
<?php
echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('TourParticipation.firstname', array(
			'label' => __('Vorname', true), 'tabindex' => 1, 'error' => array(
				'notEmpty' => __('Trag bitte deinen Vornamen ein.', true),
				'correctFormat' => __('Der Vorname darf nur Buchstaben, Punkte, Bindestriche und Leerzeichen enthalten.', true)
			)
		))
		. $this->Form->input('TourParticipation.street', array(
			'label' => __('Strasse', true), 'tabindex' => 3, 'error' => array(
				'notEmpty' => __('Trag bitte die Strasse ein.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('TourParticipation.lastname', array(
			'label' => __('Nachname', true), 'tabindex' => 2, 'error' => array(
				'notEmpty' => __('Trag bitte deinen Nachnamen ein.', true),
				'correctFormat' => __('Der Nachname darf nur Buchstaben, Bindestriche und Leerzeichen enthalten.', true)
			)
		))
		. $this->Form->input('TourParticipation.housenumber', array(
			'label' => __('Hausnummer', true), 'tabindex' => 4
		))
	)
);

echo $this->Form->input('TourParticipation.extraaddressline', array(
	'label' => __('Adresszusatz', true), 'tabindex' => 5
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('TourParticipation.zip', array(
			'label' => __('Postleitzahl', true), 'tabindex' => 6, 'error' => array(
				'notEmpty' => __('Trag bitte deine Postleitzahl ein.', true),
				'validRange' => __('Die Postleitzahl ist nicht korrekt.', true)
			)
		))
		. $this->Form->input('TourParticipation.country_id', array(
			'label' => __('Land', true), 'empty' => true, 'tabindex' => 8, 'error' => array(
				'notEmpty' => __('Bitte wähle dein Land aus.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('TourParticipation.city', array(
			'label' => __('Stadt', true), 'tabindex' => 7, 'error' => array(
				'notEmpty' => __('Trag bitte deine Stadt ein.', true)
			)
		))
	)
);

echo $this->Html->tag('hr', '');

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('TourParticipation.phoneprivate', array(
			'label' => __('Telefon privat', true), 'tabindex' => 9, 'error' => array(
				'notEmpty' => __('Trag bitte deine Telefonnummer ein.', true),
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
		. $this->Form->input('TourParticipation.cellphone', array(
			'label' => __('Mobil Nr.', true), 'tabindex' => 11, 'error' => array(
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('TourParticipation.phonebusiness', array(
			'label' => __('Telefon gesch.', true), 'tabindex' => 10, 'error' => array(
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
		. $this->Form->input('TourParticipation.email', array(
			'label' => __('E-Mail', true), 'tabindex' => 12, 'error' => array(
				'validEmail' => __('Gib bitte eine gültige E-Mail-Adresse ein oder lass das Feld leer.', true)
			)
		))
	)
);
?>
  </fieldset>

  <fieldset>
    <legend><?php __('Notfallkontaktdaten'); ?></legend>
<?php
echo $this->Form->input('TourParticipation.emergencycontact1_address', array(
	'label' => 'Kontakt Person 1', 'tabindex' => 13, 'error' => array(
		'notEmpty' => __('Trag bitte den Namen und die Adresse deiner Notfallkontaktperson ein.', true)
	)
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('TourParticipation.emergencycontact1_phone', array(
			'label' => __('Telefon', true), 'tabindex' => 14, 'error' => array(
				'notEmpty' => __('Trag bitte die Telefon-/Mobilnummer deiner Notfallkontaktperson ein.', true),
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('TourParticipation.emergencycontact1_email', array(
			'label' => __('E-Mail', true), 'tabindex' => 15, 'error' => array(
				'correctFormat' => __('Dies ist keine gültige E-Mail-Adresse.', true)
			)
		))
	)
);

echo $this->Html->tag('hr', '');

echo $this->Form->input('TourParticipation.emergencycontact2_address', array(
	'label' => __('Kontakt Person 2', true), 'tabindex' => 16
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('TourParticipation.emergencycontact2_phone', array(
			'label' => __('Telefon', true), 'tabindex' => 17, 'error' => array(
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('TourParticipation.emergencycontact2_email', array(
			'label' => __('E-Mail', true), 'tabindex' => 18, 'error' => array(
				'correctFormat' => __('Dies ist keine gültige E-Mail-Adresse.', true)
			)
		))
	)
);
?>
  </fieldset>

  <fieldset class="sacmembership">
    <legend><?php __('SAC Mitgliedschaft'); ?></legend>
<?php
echo $this->Form->input('TourParticipation.sac_member', array(
	'label' => __('SAC Mitglied', true), 'options' => $this->Display->getSacMemberOptions(),
	'empty' => __('Bitte wählen', true), 'error' => array(
		'notEmpty' => __('Bitte wähle eine Möglichkeit aus.', true)
	), 'tabindex' => 19
));


echo $this->Html->div('',
	$this->Form->input('TourParticipation.sac_membership_number', array('label' => __('Mitgliedernummer', true)))
	. $this->Form->input('TourParticipation.sac_main_section_id', array('label' => __('Hauptsektion', true), 'options' => $sacSections, 'empty' => '', 'tabindex' => 20))
	. $this->Form->input('TourParticipation.sac_additional_section1_id', array('label' => __('Zweitsektion', true), 'options' => $sacSections, 'empty' => '', 'tabindex' => 21))
	. $this->Form->input('TourParticipation.sac_additional_section2_id', array('label' => __('Drittsektion', true), 'options' => $sacSections, 'empty' => '', 'tabindex' => 22))
	. $this->Form->input('TourParticipation.sac_additional_section3_id', array('label' => __('Viertsektion', true), 'options' => $sacSections, 'empty' => '', 'tabindex' => 23)),
	array('id' => 'sacmembershipfields')
);

$this->Js->buffer("$('#TourParticipationSacMember').change(function(event) { if($(event.target).val() == 1) { $('#sacmembershipfields').show(); } else { $('#sacmembershipfields').hide(); } });");
$this->Js->buffer("if($('#TourParticipationSacMember').val() == 1) { $('#sacmembershipfields').show(); } else { $('#sacmembershipfields').hide(); }");
?>
  </fieldset>

  <fieldset class="experience">
    <legend><?php __('Erfahrung'); ?></legend>
<?php
	echo $this->Html->div('input radio',
		$this->Form->label('TourParticipation.experience_rope_guide', __('Einsetzbar als Seilschaftsführer', true))
		. $this->Form->input('TourParticipation.experience_rope_guide', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => $this->Display->getYesNoDontKnowOptions(),
			'default' => 0, 'tabindex' => 24
		))
	);
	echo $this->Html->div('input radio',
		$this->Form->label('TourParticipation.experience_knot_technique', __('Kenntnisse in Knotentechnik', true))
		. $this->Form->input('TourParticipation.experience_knot_technique', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => $this->Display->getExperienceOptions(),
			'default' => 0, 'tabindex' => 25
		))
	);
	echo $this->Html->div('input radio',
		$this->Form->label('TourParticipation.experience_rope_handling', __('Kenntnisse in Seilhandhabung', true))
		. $this->Form->input('TourParticipation.experience_rope_handling', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => $this->Display->getExperienceOptions(),
			'default' => 0, 'tabindex' => 26
		))
	);
	echo $this->Html->div('input radio',
		$this->Form->label('TourParticipation.experience_avalanche_training', __('Lawinenausbildung', true))
		. $this->Form->input('TourParticipation.experience_avalanche_training', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => $this->Display->getExperienceOptions(),
			'default' => 0, 'tabindex' => 27
		))
	);
	echo $this->Form->input('TourParticipation.lead_climb_niveau_id', array(
		'label' => __('Kletterniveau im Vorstieg', true), 'options' => $climbingDifficulties, 'empty' => __('Keine Erfahrung', true), 'tabindex' => 28
	));
	echo $this->Form->input('TourParticipation.second_climb_niveau_id', array(
		'label' => __('Kletterniveau im Nachstieg', true), 'options' => $climbingDifficulties, 'empty' => __('Keine Erfahrung', true), 'tabindex' => 29
	));
	echo $this->Form->input('TourParticipation.alpine_tour_niveau_id', array(
		'label' => __('Alpin-/Hochtourenniveau', true), 'options' => $skiAndAlpineTourDifficulties, 'empty' => __('Keine Erfahrung', true), 'tabindex' => 30
	));
	echo $this->Form->input('TourParticipation.ski_tour_niveau_id', array(
		'label' => __('Skitourenniveau', true), 'options' => $skiAndAlpineTourDifficulties, 'empty' => __('Keine Erfahrung', true), 'tabindex' => 31
	));
?>
  </fieldset>

  <fieldset class="mobility">
    <legend><?php __('Mobilität'); ?></legend>
<?php
echo $this->Form->input('TourParticipation.publictransportsubscription', array(
	'label' => __('ÖV-Abo', true), 'empty' => __('Keins', true),
	'options' => $this->Display->getPublictransportSubscriptionOptions(), 'tabindex' => 32
));
echo $this->Form->input('TourParticipation.ownpassengercar', array(
	'label' => __('Eigener PKW', true), 'tabindex' => 33,
	'after' => $this->Form->input('TourParticipation.freeseatsinpassengercar', array(
		'tabindex' => 34, 'label' => __('Freie Plätze im eigenen PKW', true), 'error' => array(
			'correctFormat' => __('Bitte gib hier eine ganze Zahl ein.', true)
		)
	))
));
$this->Js->buffer("$('#TourParticipationOwnpassengercar').click(function(event) { $(event.target).siblings('.input').css('visibility', (event.target.checked ? 'visible' : 'hidden')); });");
$this->Js->buffer("$('#TourParticipationFreeseatsinpassengercar').parent().css('visibility', ($('#TourParticipationOwnpassengercar').prop('checked') ? 'visible' : 'hidden'));");
?>
  </fieldset>

  <fieldset class="equipment">
    <legend><?php __('Ausrüstung'); ?></legend>
<?php
echo $this->Form->input('TourParticipation.ownsinglerope', array(
	'label' => __('Eigenes Einfachseil vorhanden', true), 'tabindex' => 35,
	'after' => $this->Form->input('TourParticipation.lengthsinglerope', array(
		'tabindex' => 36, 'label' => __('Länge in Meter', true), 'error' => array(
			'correctFormat' => __('Bitte gib hier die Länge in Meter ein. Beispiel: 40', true)
		)
	))
));
$this->Js->buffer("$('#TourParticipationOwnsinglerope').click(function(event) { $(event.target).siblings('.input').css('visibility', (event.target.checked ? 'visible' : 'hidden')); });");
$this->Js->buffer("$('#TourParticipationLengthsinglerope').parent().css('visibility', ($('#TourParticipationOwnsinglerope').prop('checked') ? 'visible' : 'hidden'));");
echo $this->Form->input('TourParticipation.ownhalfrope', array(
	'label' => __('Eigenes Halbseilpaar vorhanden', true), 'tabindex' => 37,
	'after' => $this->Form->input('TourParticipation.lengthhalfrope', array(
		'tabindex' => 38,'label' => __('Länge in Meter', true), 'error' => array(
			'correctFormat' => __('Bitte gib hier die Länge in Meter ein. Beispiel: 60', true)
		)
	))
));
$this->Js->buffer("$('#TourParticipationOwnhalfrope').click(function(event) { $(event.target).siblings('.input').css('visibility', (event.target.checked ? 'visible' : 'hidden')); });");
$this->Js->buffer("$('#TourParticipationLengthhalfrope').parent().css('visibility', ($('#TourParticipationOwnhalfrope').prop('checked') ? 'visible' : 'hidden'));");
echo $this->Form->input('TourParticipation.owntent', array('label' => __('Eigenes Zelt vorhanden', true), 'tabindex' => 39));
echo $this->Html->para('', __('Im folgenden Feld kann weitere Ausrüstung angeben werde, die für die Tour zur Verfügung gestellt werden kann (z.B. Expressen, etc.).', true));
echo $this->Form->input('TourParticipation.additionalequipment', array('label' => __('Zus. Ausrüstung', true), 'tabindex' => 40));

?>
  </fieldset>
</div>