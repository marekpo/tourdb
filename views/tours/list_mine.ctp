<?php
$this->set('title_for_layout', __('Meine Touren', true));
echo $this->Html->tag('h1', __('Meine Touren', true));

$tableHeaders = $this->Html->tableHeaders(array(
	__('Titel', true), __('Klassifikation', true), __('Tourenwoche', true), __('Bergführer', true), __('Beginn', true), __('Ende', true)
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
			$this->TourDisplay->getClassification($tour),
			array('class' => 'classification')
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
			$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
			array('class' => 'startdate')
		),
		array(
			$this->Time->format('d.m.Y', $tour['Tour']['enddate']),
			array('class' => 'enddate')
		)
	);
}

echo $this->Html->tag('table', $tableHeaders . $this->Html->tableCells($tableCells, array(), array('class' => 'even'), false, false), array('class' => 'tours'));