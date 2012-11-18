<?php
$this->set('title_for_layout', __('Tourensuche', true));
$this->Html->addCrumb(__('Tourensuche', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'TourGroup', 'range', 'TourStatus', 'date', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
	$tableHeaders = array(
		'',
		$this->Paginator->sort(__('Gruppe', true), 'TourGroup.tourgroupname'),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Datum von', true), 'Tour.startdate'),
		$this->Paginator->sort(__('Datum bis', true), 'Tour.enddate'),
		$this->Paginator->sort(__('TW', true), 'Tour.tourweek', array('title' => __('Tourenwoche', true))),
		$this->Paginator->sort(__('BGF', true), 'Tour.withmountainguide', array('title' => __('mit Bergführer durchgeführte/r Tour/Kurs', true))),
		__('Code', true),
		$this->Paginator->sort(__('TourenleiterIn', true), 'TourGuide.username')
	);

	$tableRows = array();

	foreach($tours as $tour)
	{
		$tableRows[] = array(
			array(
				$this->TourDisplay->getStatusLink($tour,'view'),
				array('class' => 'iconstatus')
			),
			array(
				$tour['TourGroup']['tourgroupname'],
				array('class' => 'tourgroup')
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