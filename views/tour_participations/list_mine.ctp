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
		$this->Paginator->sort(__('Datum', true), 'Tour.startdate'),
		__('Tag', true),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Gruppe', true), 'TourGroup.tourgroupname'),
		__('Code', true),
				$this->Paginator->sort(__('TourenleiterIn', true), 'TourGuide.username')
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
					$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
					array('class' => 'startdate')
			),
			array(
					$this->TourDisplay->getDayOfWeekText($tour),
					array('class' => 'dayofweek')
			),
			array(
					$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
							'controller' => 'tours', 'action' => 'view', $tour['Tour']['id']
					))
					. ($tour['Tour']['tourweek'] == 1 ? sprintf(' %s', __('TW',true)) : '')
					. ($tour['Tour']['withmountainguide'] == 1 ? sprintf(' %s', __('BGF',true)) : '')
					,
					array('class' => 'title')
			),
			array(
				$tour['Tour']['TourGroup']['tourgroupname'],
				array('class' => 'tourgroup')
			),
			array(
					$this->TourDisplay->getClassification($tour),
					array('class' => 'classification')
			),
			array(
					$this->TourDisplay->getTourGuide($tour),
					array('class' => 'tourguide')
			),
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