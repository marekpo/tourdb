<?php
$this->set('title_for_layout', __('Meine Tourenanmeldungen', true));
$this->Html->addCrumb(__('Meine Tourenanmeldungen', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'TourGroup', 'range', 'date', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
	$tableHeaders = array(
		$this->Paginator->sort(__('Anm.Status', true), 'TourParticipationStatus.statusname'),
		__('Gruppe', true),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Datum von', true), 'Tour.startdate'),
		$this->Paginator->sort(__('Datum bis', true), 'Tour.enddate'),
		$this->Paginator->sort(__('TW', true), 'Tour.tourweek', array('title' => __('Tourenwoche', true))),
		$this->Paginator->sort(__('BGF', true), 'Tour.withmountainguide', array('title' => __('mit Bergführer durchgeführte/r Tour/Kurs', true))),
		__('Code', true),
		__('TourenleiterIn', true)
	);

	$tableCells = array();

	foreach($tours as $tour)
	{
		$tableCells[] = array(
			array(
				$tour['TourParticipationStatus']['statusname'],
				array('class' => 'tourparticipationstatus')
			),
			array(
				$tour['Tour']['TourGroup']['tourgroupname'],
				array('class' => 'tourgroup')
			),
			array(
				$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
					'controller' => 'tours', 'action' => 'view', $tour['Tour']['id']
				)),
				array('class' => 'title')
			),
			array(
				$this->Time->format('d.m.Y', strtotime($tour['Tour']['startdate'])),
				array('class' => 'startdate')
			),
			array(
				$this->Time->format('d.m.Y', strtotime($tour['Tour']['enddate'])),
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
	if($tourParticipationCount)
	{
		echo $this->Html->para('', __('Es gibt für dich keine Tourenanmeldungen, die den Suchkriterien entsprechen. Bitte setze den Suchfilter zurück.', true));
	}
	else
	{
		echo $this->Html->para('', __('Für dich sind noch keine Tourenanmeldungen gespeichert.', true));
	}
}

echo $this->element('paginator');