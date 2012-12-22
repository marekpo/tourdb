<?php
$viewTitle = sprintf(__('Tourenanmeldung von %s %s', true), $tourParticipation['TourParticipation']['firstname'], $tourParticipation['TourParticipation']['lastname']);
$this->set('title_for_layout', $viewTitle);
$this->Html->addCrumb($tourParticipation['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id']));
$this->Html->addCrumb($viewTitle);

echo $this->Html->tag('h2', __('Kontaktdaten', true));
?>
<div class="columncontainer">
  <div class="half"><?php
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Name:', true))
	. $this->Html->div('content', sprintf('%s %s', $tourParticipation['TourParticipation']['firstname'], $tourParticipation['TourParticipation']['lastname']))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Adresse:', true))
	. $this->Html->div('content',
		$this->Html->div('', sprintf('%s %s', $tourParticipation['TourParticipation']['street'], $tourParticipation['TourParticipation']['housenumber']))
		. $this->Html->div('', $tourParticipation['TourParticipation']['extraaddressline'])
		. $this->Html->div('', sprintf('%s %s', $tourParticipation['TourParticipation']['zip'], $tourParticipation['TourParticipation']['city']))
		. $this->Html->div('', $tourParticipation['Country']['name'])
	)
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('E-Mail:', true))
	. $this->Html->div('content', $this->Html->link($tourParticipation['TourParticipation']['email'], sprintf('mailto:%s', $tourParticipation['TourParticipation']['email'])))
);
?></div>
  <div class="half"><?php
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Telefon privat:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['phoneprivate'])
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Telefon gesch.:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['phonebusiness'])
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Mobil Nr.:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['cellphone'])
);
?></div>
</div>

<?php if(!empty($tourParticipation['TourParticipation']['emergencycontact2_address'])): ?>
<div class="columncontainer">
  <div class="half">
<?php
endif;

echo $this->Html->tag('h2', __('Notfallkontakt', true));

echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Adresse:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['emergencycontact1_address'])
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Telefon:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['emergencycontact1_phone'])
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('E-Mail:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['emergencycontact1_email'])
);

if(!empty($tourParticipation['TourParticipation']['emergencycontact2_address'])) :?>
  </div>
  <div class="half"><?php
echo $this->Html->tag('h2', __('Notfallkontakt 2', true));

echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Adresse:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['emergencycontact2_address'])
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Telefon:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['emergencycontact2_phone'])
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('E-Mail:', true))
	. $this->Html->div('content', $tourParticipation['TourParticipation']['emergencycontact2_email'])
);
?></div>
</div>
<?php
endif;

echo $this->Html->tag('h2', __('SAC Mitgliedschaft', true));

echo $this->Html->div('infoitem',
	$this->Html->div('label', __('SAC Mitglied:', true))
	. $this->Html->div('content', $this->Display->displaySacMember($tourParticipation['TourParticipation']['sac_member']))
);

if($tourParticipation['TourParticipation']['sac_member'])
{
	echo $this->Html->div('infoitem',
		$this->Html->div('label', __('Mitgliedernummer:', true))
		. $this->Html->div('content', $tourParticipation['TourParticipation']['sac_membership_number'])
	);

	$sections = array();

	if(!empty($tourParticipation['SacMainSection']['id']))
	{
		$sections[] = sprintf(__('%s (Hauptsektion)', true), $tourParticipation['SacMainSection']['title']);
	}

	if(!empty($tourParticipation['SacAdditionalSection1']['id']))
	{
		$sections[] = sprintf(__('%s (Zweitsektion)', true), $tourParticipation['SacAdditionalSection1']['title']);
	}

	if(!empty($tourParticipation['SacAdditionalSection2']['id']))
	{
		$sections[] = sprintf(__('%s (Drittsektion)', true), $tourParticipation['SacAdditionalSection2']['title']);
	}

	if(!empty($tourParticipation['SacAdditionalSection3']['id']))
	{
		$sections[] = sprintf(__('%s (Viertsektion)', true), $tourParticipation['SacAdditionalSection3']['title']);
	}

	if(!empty($sections))
	{
		echo $this->Html->div('infoitem',
			$this->Html->div('label', __n('Sektion:', 'Sektionen:', count($sections), true))
			. $this->Html->div('content', implode(', ', $sections))
		);
	}
}

echo $this->Html->tag('h2', __('Erfahrungen', true));

?>
<div class="columncontainer">
  <div class="half"><?php
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Einsetzbar als Seilschaftsführer:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $this->Display->displayYesNoDontKnow($tourParticipation['TourParticipation']['experience_rope_guide']), array('style' => 'width: 160px'))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Kenntnisse in Knotentechnik:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_knot_technique']), array('style' => 'width: 160px'))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Kenntnisse in Seilhandhabung:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_rope_handling']), array('style' => 'width: 160px'))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Lawinenausbildung:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_avalanche_training']), array('style' => 'width: 160px'))
);
?></div>
  <div class="half"><?php
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Kletterniveau im Vorstieg:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $tourParticipation['LeadClimbNiveau']['name'], array('style' => 'width: 160px'))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Kletterniveau im Nachstieg:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $tourParticipation['SecondClimbNiveau']['name'], array('style' => 'width: 160px'))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Alpin-/Hochtourenniveau:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $tourParticipation['AlpineTourNiveau']['name'], array('style' => 'width: 160px'))
);
echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Skitourenniveau:', true), array('style' => 'width: 230px'))
	. $this->Html->div('content', $tourParticipation['SkiTourNiveau']['name'], array('style' => 'width: 160px'))
);
?></div>
</div>
<?php
if(!empty($tourParticipation['TourParticipation']['publictransportsubscription']) || !empty($tourParticipation['TourParticipation']['ownpassengercar']))
{
	echo $this->Html->tag('h2', __('Mobilität', true));
}

if(!empty($tourParticipation['TourParticipation']['publictransportsubscription']))
{
	echo $this->Html->div('infoitem',
		$this->Html->div('label', __('ÖV-Abo:', true))
		. $this->Html->div('content', $this->Display->displayPublicTransportSubscription($tourParticipation['TourParticipation']['publictransportsubscription']))
	);
}

if(!empty($tourParticipation['TourParticipation']['ownpassengercar']))
{
	echo $this->Html->div('infoitem',
		$this->Html->div('label', __('Eigener PKW:', true), array('style' => 'width: 230px'))
		. $this->Html->div('content', sprintf('Ja, %s', ($tourParticipation['TourParticipation']['freeseatsinpassengercar']
			? sprintf(__n('%d Sitzplatz vorhanden', '%d Sitzplätze vorhanden', $tourParticipation['TourParticipation']['freeseatsinpassengercar'], true), $tourParticipation['TourParticipation']['freeseatsinpassengercar'])
			: __('Kein Sitzplatz vorhanden', true))))
	);
}

if(!empty($tourParticipation['TourParticipation']['note_participant']))
{
	echo $this->Html->tag('h2', __('Mitteilung des Teilnehmers', true));

	echo $this->Html->para('', $tourParticipation['TourParticipation']['note_participant']);
}