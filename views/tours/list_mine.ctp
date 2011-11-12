<?php
$this->set('title_for_layout', __('Meine Touren', true));
$this->Html->addCrumb(__('Meine Touren', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'date', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
	$tableHeaders =array(
		$this->Paginator->sort(__('Tourbezeichnung', true), 'title'),
		$this->Paginator->sort(__('Status', true), 'TourStatus.rank'),
		$this->Paginator->sort(__('Datum von', true), 'startdate'),
		$this->Paginator->sort(__('Datum bis', true), 'enddate'),
		__('Code', true)
	);
	
	$tableCells = array();

	foreach($tours as $tour)
	{
		$tableCells[] = array(
			array(
				$this->Html->link($tour['Tour']['title'], array('action' => 'edit', $tour['Tour']['id'])),
				array('class' => 'title')
			),
			array(
				$tour['TourStatus']['statusname'],
				array('class' => 'status')
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
				$this->TourDisplay->getClassification($tour),
				array('class' => 'classification')
			)
		);
	}

	echo $this->Widget->table($tableHeaders, $tableCells);
}
else
{
	if($unfilteredTourCount)
	{
		echo $this->Html->para('', __('Du hast bisher noch keine Touren erfasst, die den Filterkriterien entsprechen. Bitte setze den Suchfilter zurück.', true));
	}
	else
	{
		echo $this->Html->para('', __('Du hast bisher noch keine Touren erfasst.', true));
	}
}

echo $this->element('paginator');