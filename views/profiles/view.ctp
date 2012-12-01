<?php
$title = sprintf(__('Benutzerprofil von %s', true), $this->Display->displayUsersFullName($profile['User']['username'], $profile['Profile']));

$this->set('title_for_layout', $title);
$this->Html->addCrumb($title);

echo $this->Html->tag('h2', __('Kontaktdaten', true));

$addressRows = array();

$addressRows[] = array(__('Name:', true), sprintf('%s %s', $profile['Profile']['firstname'], $profile['Profile']['lastname']));
$addressRows[] = array(array(__('Adresse:', true), array('rowspan' => 4)), sprintf('%s %s', $profile['Profile']['street'], $profile['Profile']['housenumber']));
$addressRows[] = array($profile['Profile']['extraaddressline']);
$addressRows[] = array(sprintf('%s %s', $profile['Profile']['zip'], $profile['Profile']['city']));
$addressRows[] = array($profile['Country']['name']);
$addressRows[] = array(__('E-Mail:', true), $this->Html->link($profile['User']['email'], sprintf('mailto:%s', $profile['User']['email'])));
$addressRows[] = array(__('Telefon privat:', true), $profile['Profile']['phoneprivate']);
$addressRows[] = array(__('Telefon gesch.:', true), $profile['Profile']['phonebusiness']);
$addressRows[] = array(__('Mobil Nr.:', true), $profile['Profile']['cellphone']);

echo $this->Html->tag('table', $this->Html->tableCells($addressRows));

if(!empty($profile['Profile']['emergencycontact1_address']) || ! empty($profile['Profile']['emergencycontact1_address']))
{
	echo $this->Html->tag('h2', __('Notfallkontaktdaten', true));
	if(!empty($profile['Profile']['emergencycontact1_address']))
	{
		$emergencyContact1Rows = array();

		$emergencyContact1Rows[] = array(__('Adresse:', true), $profile['Profile']['emergencycontact1_address']);
		$emergencyContact1Rows[] = array(__('Telefon:', true), $profile['Profile']['emergencycontact1_phone']);
		$emergencyContact1Rows[] = array(__('E-Mail:', true), $this->Html->link($profile['Profile']['emergencycontact1_email'], sprintf('mailto:%s', $profile['Profile']['emergencycontact1_email'])));

		echo $this->Html->tag('table', $this->Html->tableCells($emergencyContact1Rows));
	}

	if(!empty($profile['Profile']['emergencycontact2_address']))
	{
		$emergencyContact2Rows = array();

		$emergencyContact2Rows[] = array(__('Adresse:', true), $profile['Profile']['emergencycontact2_address']);
		$emergencyContact2Rows[] = array(__('Telefon:', true), $profile['Profile']['emergencycontact2_phone']);
		$emergencyContact2Rows[] = array(__('E-Mail:', true), $this->Html->link($profile['Profile']['emergencycontact2_email'], sprintf('mailto:%s', $profile['Profile']['emergencycontact2_email'])));

		echo $this->Html->tag('table', $this->Html->tableCells($emergencyContact2Rows));
	}
}

echo $this->Html->tag('h2', __('SAC Mitgliedschaft', true));
$sacMembershipRows = array();
if($profile['Profile']['sac_member'] <= 1) {
	$sacMembershipRows[] = array(__('SAC Mitglied:', true), $this->Display->displaySacMember($profile['Profile']['sac_member']));
}
else {
	$sacMembershipRows[] = array(__('SAC Mitglied:', true), __('Keine Angaben', true));
}

if($profile['Profile']['sac_member'] == 1)
{
	if(!empty($profile['Profile']['sac_membership_number']))
	{
		$sacMembershipRows[] = array(__('Mitgliedernummer:', true), $profile['Profile']['sac_membership_number']);
	}

	$sections = array();

	if(!empty($profile['SacMainSection']['id']))
	{
		$sections[] = sprintf(__('%s (Hauptsektion)', true), $profile['SacMainSection']['title']);
	}

	if(!empty($profile['SacAdditionalSection1']['id']))
	{
		$sections[] = sprintf(__('%s (Zweitsektion)', true), $profile['SacAdditionalSection1']['title']);
	}

	if(!empty($profile['SacAdditionalSection2']['id']))
	{
		$sections[] = sprintf(__('%s (Drittsektion)', true), $profile['SacAdditionalSection2']['title']);
	}

	if(!empty($profile['SacAdditionalSection3']['id']))
	{
		$sections[] = sprintf(__('%s (Viertsektion)', true), $profile['SacAdditionalSection3']['title']);
	}

	if(!empty($sections))
	{
		$sacMembershipRows[] = array(
			__n('Sektion:', 'Sektionen:', count($sections), true), implode(', ', $sections)
		);
	}
}
echo $this->Html->tag('table', $this->Html->tableCells($sacMembershipRows));


echo $this->Html->tag('h2', __('Erfahrungen', true));

$experienceRows = array();
$experienceRows[] = array(__('Einsetzbar als Seilschaftsführer:', true), $this->Display->displayYesNoDontKnow($profile['Profile']['experience_rope_guide']));
$experienceRows[] = array(__('Kenntnisse in Knotentechnik:', true), $this->Display->displayExperience($profile['Profile']['experience_knot_technique']));
$experienceRows[] = array(__('Kenntnisse in Seilhandhabung:', true), $this->Display->displayExperience($profile['Profile']['experience_rope_handling']));
$experienceRows[] = array(__('Lawinenausbildung:', true), $this->Display->displayExperience($profile['Profile']['experience_avalanche_training']));
$experienceTable = $this->Html->tag('table', $this->Html->tableCells($experienceRows));

$niveauRows = array();
$niveauRows[] = array(__('Kletterniveau im Vorstieg:', true), $profile['LeadClimbNiveau']['name']);
$niveauRows[] = array(__('Kletterniveau im Nachstieg:', true), $profile['SecondClimbNiveau']['name']);
$niveauRows[] = array(__('Alpin-/Hochtourenniveau:', true), $profile['AlpineTourNiveau']['name']);
$niveauRows[] = array(__('Skitourenniveau:', true), $profile['SkiTourNiveau']['name']);
$niveauTable = $this->Html->tag('table', $this->Html->tableCells($niveauRows));

echo $this->Html->div('columncontainer',
	$this->Html->div('half', $experienceTable)
	. $this->Html->div('half', $niveauTable)
);

$mobilityRows = array();
if($profile['Profile']['publictransportsubscription'])
{
	$mobilityRows[] = array(__('ÖV-Abo:', true), $this->Display->displayPublicTransportSubscription($profile['Profile']['publictransportsubscription']));
}
if($profile['Profile']['ownpassengercar'])
{
	$mobilityRows[] = array(__('Eigener PKW:', true), sprintf('Ja, %s', ($profile['Profile']['freeseatsinpassengercar'] ? sprintf(__n('%d Sitzplatz vorhanden', '%d Sitzplätze vorhanden', $profile['Profile']['freeseatsinpassengercar'], true), $profile['Profile']['freeseatsinpassengercar']): __('Kein Sitzplatz vorhanden', true))));
}

if(count($mobilityRows))
{
	echo $this->Html->tag('h2', __('Mobilität', true));
	echo $this->Html->tag('table', $this->Html->tableCells($mobilityRows));
}

$equipmentRows = array();
if($profile['Profile']['ownsinglerope'])
{
	$equipmentRows[] = array(__('Eigenes Einfachseil:', true), sprintf(__('%d Meter', true), $profile['Profile']['lengthsinglerope']));
}
if($profile['Profile']['ownhalfrope'])
{
	$equipmentRows[] = array(__('Eigenes Halbseilpaar:', true), sprintf(__('%d Meter', true), $profile['Profile']['lengthhalfrope']));
}
if($profile['Profile']['owntent'])
{
	$equipmentRows[] = array(__('Eigenes Zelt:', true), __('Ja', true));
}
if($profile['Profile']['additionalequipment'])
{
	$equipmentRows[] = array(__('Zus. Ausrüstung:', true), $this->Display->formatText($profile['Profile']['additionalequipment']));
}

if(count($equipmentRows))
{
	echo $this->Html->tag('h2', __('Ausrüstung', true));
	echo $this->Html->tag('table', $this->Html->tableCells($equipmentRows));
}

$additionalInformationRows = array();
if(!empty($profile['Profile']['birthdate']))
{
	$additionalInformationRows[] = array(__('Geburtsdatum:', true), sprintf('%s (%s Jahre)', $this->Time->format('d.m.Y', $profile['Profile']['birthdate']), $profile['Profile']['age']));
}
if($profile['Profile']['sex'] !== null)
{
	$additionalInformationRows[] = array(__('Geschlecht:', true), $this->Display->displaySex($profile['Profile']['sex']));
}

if(count($additionalInformationRows))
{
	echo $this->Html->tag('h2', __('Weitere Angaben', true));
	echo $this->Html->tag('table', $this->Html->tableCells($additionalInformationRows));
}

if(!empty($profile['Profile']['healthinformation']))
{
	echo $this->Html->tag('h2', __('Gesundheitliche Hinweise', true));
	echo $this->Html->para('', $this->Display->formatText($profile['Profile']['healthinformation']));
}

if(count($ownTours))
{
	echo $this->Html->tag('h2', __('Ausgeschriebene Touren', true));

	$ownTourHeaders = array(
		'', __('Datum', true), __('Tag', true), __('Tourbezeichnung', true), __('Code', true)
	);

	$ownTourRows = array();

	foreach($ownTours as $ownTour)
	{
		$ownTourRows[] = array(
			$this->TourDisplay->getStatusLink($ownTour, 'view'),
			$this->Time->format('d.m.Y', $ownTour['Tour']['startdate']),
			$this->TourDisplay->getDayOfWeekText($ownTour),
			$this->Html->link($ownTour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $ownTour['Tour']['id'])),
			$this->TourDisplay->getClassification($ownTour)
		);
	}

	echo $this->Widget->table($ownTourHeaders, $ownTourRows);
}

if(count($tourParticipations))
{
	echo $this->Html->tag('h2', __('Bestätigte Tourenanmeldungen', true));

	$tourParticipationHeaders = array(
		'', __('Datum', true), __('Tag', true), __('Tourbezeichnung', true), __('Code', true)
	);

	$tourParticipationRows = array();

	foreach($tourParticipations as $tourParticipation)
	{
		$tourParticipationRows[] = array(
			$this->TourDisplay->getStatusLink($tourParticipation['Tour'], 'view'),
			$this->Time->format('d.m.Y', $tourParticipation['Tour']['startdate']),
			$this->TourDisplay->getDayOfWeekText($tourParticipation),
			$this->Html->link($tourParticipation['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tourParticipation['Tour']['id'])),
			$this->TourDisplay->getClassification($tourParticipation)
		);
	}

	echo $this->Widget->table($tourParticipationHeaders, $tourParticipationRows);
}