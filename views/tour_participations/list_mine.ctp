<?php
$this->set('title_for_layout', __('Meine Tourenanmeldungen', true));
$this->Html->addCrumb(__('Meine Tourenanmeldungen', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'date', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

$tableHeaders = array(
	$this->Paginator->sort(__('Anmeldestatus', true), 'TourParticipationStatus.statusname'),
	$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
	$this->Paginator->sort(__('Datum von', true), 'Tour.startdate'),
	$this->Paginator->sort(__('Datum bis', true), 'Tour.enddate'),
	__('Code', true),
	__('Tourenleiter', true)
);

if(count($tours))
{
	$tableCells = array();

	foreach($tours as $tour)
	{
		$tableCells[] = array(
			$tour['TourParticipationStatus']['statusname'],
			$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
				'controller' => 'tours', 'action' => 'view', $tour['Tour']['id']
			)),
			$this->Time->format('d.m.Y', strtotime($tour['Tour']['startdate'])),
			$this->Time->format('d.m.Y', strtotime($tour['Tour']['enddate'])),
			$this->TourDisplay->getClassification($tour),
			$this->TourDisplay->getTourGuide($tour)
		);
	}	

	echo $this->Widget->table($tableHeaders, $tableCells);
}
else
{
	echo $this->Html->para('', __('Für dich sind noch keine Tourenanmeldungen gespeichert.', true));
}

echo $this->element('paginator');