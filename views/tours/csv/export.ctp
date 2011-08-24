<?php

$this->Csv->addRow(array(
	__('Datum', true), __('Tag', true), __('Beschreibung', true),
	__('Detailbeschreibung', true), __('TW', true), __('Mit Bergführer', true),
	__('Tourencode', true), __('Tourenleiter(-in)', true)
));

$previousMonth = null;
$previousYear = null;

foreach($tours as $tour)
{
	$startTime = strtotime($tour['Tour']['startdate']);
	$endTime = strtotime($tour['Tour']['enddate']);

	$currentMonth = $this->Time->format($startTime, '%B');
	$currentYear = $this->Time->format($startTime, '%Y');

	if($previousMonth != $currentMonth)
	{
		$sectionHeader = $currentMonth;

		if($currentYear != $previousYear)
		{
			$sectionHeader = sprintf('%s %s', $sectionHeader, $currentYear);
		}

		$this->Csv->addRow(array());
		$this->Csv->addRow(array($sectionHeader));

		$previousMonth = $currentMonth;
		$previousYear = $currentYear;
	}

	$dateColumn = $this->Time->format($startTime, '%#d.');
	$dayColumn = $this->Time->format($startTime, '%a');
	$duration = $endTime - $startTime;

	if($duration > 0 && $duration <= 86400) // duration one day
	{
		$dateColumn = sprintf('%s/%s', $dateColumn, $this->Time->format($endTime, '%#d.'));
		$dayColumn = sprintf('%s/%s', $dayColumn, $this->Time->format($endTime, '%a'));
	}
	elseif($duration > 86400)
	{
		$dateColumn = sprintf('%s-%s', $dateColumn, $this->Time->format($endTime, '%#d.'));
		$dayColumn = sprintf('%s-%s', $dayColumn, $this->Time->format($endTime, '%a'));
	}

	$this->Csv->addRow(array(
		$dateColumn, $dayColumn, $tour['Tour']['title'], $tour['Tour']['description'],
		($tour['Tour']['tourweek'] == true ? 'TW' : ''),
		($tour['Tour']['withmountainguide'] == true ? 'Ja' : ''),
		$this->TourDisplay->getClassification($tour), $tour['TourGuide']['username']
	));
}

echo $this->Csv->render('touren', 'ISO-8859-15');