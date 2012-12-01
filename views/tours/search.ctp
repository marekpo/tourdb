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
		$this->Paginator->sort(__('Datum', true), 'Tour.startdate'),
		__('Tag', true),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Gruppe', true), 'TourGroup.tourgroupname'),
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
					$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
					array('class' => 'startdate')
			),
			array(
					$this->TourDisplay->getDayOfWeekText($tour),
					array('class' => 'dayofweek')
			),
			array(
				$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
					'action' => 'view', $tour['Tour']['id']
				))
				. ($tour['Tour']['tourweek'] == 1 ? sprintf(' %s', __('TW',true)) : '')
				. ($tour['Tour']['withmountainguide'] == 1 ? sprintf(' %s', __('BGF',true)) : '')
				 ,
				array('class' => 'title')
			),
			array(
					$tour['TourGroup']['tourgroupname'],
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

	echo $this->Widget->table($tableHeaders, $tableRows);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Touren gefunden.', true));
}

echo $this->element('paginator');