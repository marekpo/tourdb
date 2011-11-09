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
		__('Code', true),
		$this->Paginator->sort(__('Tourenleiter', true), 'TourGuide.username')
	);
	
	$tableRows = array();
	
	foreach($tours as $tour)
	{
		$tableRows[] = array(
			$tour['TourStatus']['statusname'],
			$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
				'action' => 'view', $tour['Tour']['id']
			)),
			$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
			$this->Time->format('d.m.Y', $tour['Tour']['enddate']),
			$this->TourDisplay->getClassification($tour),
			$this->TourDisplay->getTourGuide($tour)
		);
	}
	
	echo $this->Widget->table($tableHeaders, $tableRows);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Touren gefunden.', true));
}

echo $this->element('paginator');