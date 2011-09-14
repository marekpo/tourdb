<?php
$this->set('title_for_layout', __('Tourensuche', true));
$this->Html->addCrumb(__('Tourensuche', true));

echo $this->Form->create(null, array('type' => 'GET'));

echo $this->Form->hidden('asdf', array('value' => 'test'));

echo $this->Form->end(__('Suchen', true));

$tableHeaders = array(
	$this->Paginator->sort(__('Status', true), 'TourStatus.statusname'),
	$this->Paginator->sort(__('Tourbezeichnung', true), 'title'),
	$this->Paginator->sort(__('Datum von', true), 'startdate'),
	$this->Paginator->sort(__('Datum bis', true), 'enddate'),
	$this->Paginator->sort(__('Code', true), 'TourType.acronym'),
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

echo $this->Html->tag('table', $this->Html->tableHeaders($tableHeaders) . $this->Html->tableCells($tableRows), array('class' => 'list'));