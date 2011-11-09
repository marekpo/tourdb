<?php
$this->set('title_for_layout', __('Tourensuche', true));
$this->Html->addCrumb(__('Tourensuche', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'deadline', 'date', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty'
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
		$this->Paginator->sort(__('Tourenleiter', true), 'TourGuide.username')
	);
	
	$tableRows = array();
	
	foreach($tours as $tour)
	{
		$tableRows[] = array(
			array(
				$tour['TourStatus']['statusname'],
				array('class' => 'tourstatus')
			),
			array(
				$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
					'action' => 'view', $tour['Tour']['id']
				)),
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
	
	echo $this->Widget->table($tableHeaders, $tableRows);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Touren gefunden.', true));
}

echo $this->element('paginator');