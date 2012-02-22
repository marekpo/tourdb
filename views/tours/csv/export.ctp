<?php

$this->Csv->addRow(array(
	__('Datum', true), __('Tag', true), __('Beschreibung', true),
	__('Detailbeschreibung', true), __('TW', true), __('Mit Bergführer', true),
	__('Tourencode', true), __('Tourenleiter(-in)', true),
	__('Anmeldeschluss', true), __('Telefonnummer', true)
));

$previousMonth = null;

foreach($tours as $tour)
{
	$startTime = strtotime($tour['Tour']['startdate']);
	$endTime = strtotime($tour['Tour']['enddate']);

	$dateColumn = $this->Time->format($startTime, '%#d.') . $this->Time->format($startTime, '%#m.');

	$dayColumn = $this->Time->format($startTime, '%a');
	$duration = $endTime - $startTime;

	if($duration > 0)
	{
		$dateColumn = sprintf('%s-%s', $dateColumn, $this->Time->format($endTime, '%#d.') . $this->Time->format($endTime, '%#m.'));
		$dayColumn = sprintf('%s-%s', $dayColumn, $this->Time->format($endTime, '%a'));
	}

	$row = array(
		$dateColumn, $dayColumn, $tour['Tour']['title'], $tour['Tour']['description'],
		($tour['Tour']['tourweek'] == true ? 'TW' : ''),
		($tour['Tour']['withmountainguide'] == true ? 'Ja' : ''),
		$this->TourDisplay->getClassification($tour, array('span' => false))
	);

	$row[] = $this->TourDisplay->getTourGuide($tour);
	$row[] = $this->Time->format($format = 'd.m.Y', $tour['Tour']['deadline'] );
	$row[] = $this->Display->displayUsersPhoneContact($tour['TourGuide']['Profile']);

	$this->Csv->addRow($row);
}

echo $this->Csv->render('touren', 'ISO-8859-15');