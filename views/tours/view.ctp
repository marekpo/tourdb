<?php

$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

$detailRows = array(
	array(
		array(
			__('Tourenleiter', true),
			array('class' => 'label')
		),
		$this->TourDisplay->getTourGuide($tour)
	),
	array(
		array(
			__('Beschreibung', true),
			array('class' => 'label')
		),
		$this->Display->formatText($tour['Tour']['description'])
	)
);

echo $this->Html->tag('table', $this->Html->tableCells($detailRows));

$detailRows = array(
	array(
		array(
			__('Startdatum', true),
			array('class' => 'label')
		),
		$this->Time->format('d.m.Y', $tour['Tour']['startdate'])
	),
	array(
		array(
			__('Enddatum', true),
			array('class' => 'label')
		),
		$this->Time->format('d.m.Y', $tour['Tour']['enddate'])
	),
	array(
		array(
			__('Anmeldeschluss', true),
			array('class' => 'label')
		),
		$this->Time->format('d.m.Y', 0)//$tour['Tour']['closingdate'])
	),
	array(
		array(
			__('Tourencode', true),
			array('class' => 'label')
		),
		$this->TourDisplay->getClassification($tour)
	)
);

echo $this->Html->div('half', $this->Html->tag('table', $this->Html->tableCells($detailRows)));

$detailRows = array(
	array(
		array(
			__('Tourenwoche', true),
			array('class' => 'label')
		),
		$this->Display->displayFlag($tour['Tour']['tourweek'])
	),
	array(
		array(
			__('Mit dipl. Bergführer', true),
			array('class' => 'label')
		),
		$this->Display->displayFlag($tour['Tour']['withmountainguide'])
	)
);

echo $this->Html->div('half', $this->Html->tag('table', $this->Html->tableCells($detailRows)));