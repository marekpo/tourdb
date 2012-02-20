<?php
$this->set('title_for_layout', __('Alle Touren', true));
$this->Html->addCrumb(__('Alle Touren', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'deadline', 'TourStatus', 'date', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
$tableHeaders = array(
    $this->Paginator->sort(__('Status', true), 'TourStatus.rank'),
	$this->Paginator->sort(__('Tourbezeichnung', true), 'title'),
	$this->Paginator->sort(__('Datum von', true), 'startdate'),
	$this->Paginator->sort(__('Datum bis', true), 'enddate'),
	$this->Paginator->sort(__('TW', true), 'tourweek', array('title' => __('Tourenwoche', true))),
	$this->Paginator->sort(__('BGF', true), 'withmountainguide', array('title' => __('mit Bergführer durchgeführte/r Tour/Kurs', true))),
	__('Code', true),
	$this->Paginator->sort(__('Tourenleiter', true), 'TourGuide.username'),
);

$tableCells = array();

foreach($tours as $tour)
{
	$tableCells[] = array(
		array(
			$tour['TourStatus']['statusname'],
			array('class' => 'status')
		),		
		array(
			$this->Html->link($tour['Tour']['title'], array('action' => 'edit', $tour['Tour']['id'])),
			array('class' => 'title')
		),

		array(
			$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
			array('class' => 'startdate')
		),
		array(
			$this->Time->format('d.m.Y', $tour['Tour']['enddate']),
			array('class' => 'enddate')
		),
		array(
			$this->Display->displayFlag($tour['Tour']['tourweek']),
			array('class' => 'tourweek')
		),
		array(
			$this->Display->displayFlag($tour['Tour']['withmountainguide']),
			array('class' => 'withmountainguide')
		),
		array(
			$this->TourDisplay->getClassification($tour),
			array('class' => 'classification')
		),
		array(
			$this->TourDisplay->getTourGuide($tour),
			array('class' => 'tourguide')
		)
	);
}
echo $this->Widget->table($tableHeaders, $tableCells);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Touren gefunden.', true));
}


echo $this->element('paginator');