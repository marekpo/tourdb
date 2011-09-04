<?php
$this->set('title_for_layout', __('Alle Touren', true));
$this->Html->addCrumb(__('Alle Touren', true));

$tableHeaders = $this->Html->tableHeaders(array(
	$this->Paginator->sort(__('Tourbezeichnung', true), 'title'),
	$this->Paginator->sort(__('Datum von', true), 'startdate'),
	$this->Paginator->sort(__('Datum bis', true), 'enddate'),
	__('Code', true),
	$this->Paginator->sort(__('Tourenleiter', true), 'TourGuide.username'),
));

$tableCells = array();

foreach($tours as $tour)
{
	$tableCells[] = array(
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
			$this->TourDisplay->getClassification($tour),
			array('class' => 'classification')
		),
		array(
			$this->TourDisplay->getTourGuide($tour),
			array('class' => 'tourguide')
		)
	);
}

echo $this->Html->tag('table',
	$tableHeaders . $this->Html->tableCells($tableCells, array(), array('class' => 'even'), false, false),
	array('class' => 'tours list')
);

echo $this->element('paginator');