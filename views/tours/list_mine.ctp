<?php
$this->set('title_for_layout', __('Meine Touren', true));
$this->Html->addCrumb(__('Meine Touren', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'TourGroup', 'date', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
	$tableHeaders = array(
		$this->Paginator->sort(__('Gruppe', true), 'TourGroup.tourgroupname'),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Status', true), 'TourStatus.rank'),
		$this->Paginator->sort(__('Datum von', true), 'Tour.startdate'),
		$this->Paginator->sort(__('Datum bis', true), 'Tour.enddate'),
		$this->Paginator->sort(__('TW', true), 'Tour.tourweek', array('title' => __('Tourenwoche', true))),
		$this->Paginator->sort(__('BGF', true), 'Tour.withmountainguide', array('title' => __('mit Bergführer durchgeführte/r Tour/Kurs', true))),
		__('Code', true),
		''
	);
	
	$tableCells = array();

	foreach($tours as $tour)
	{
		$linkAction = $tour['Tour']['editablebytourguide'] ? 'edit' : 'view';

		$deleteLink = $tour['TourStatus']['key'] == TourStatus::NEW_
			? $this->Authorization->link('', array('controller' => 'tours', 'action' => 'delete', $tour['Tour']['id']), array(
					'class' => 'iconaction delete',
					'id' => sprintf('delete-%s', $tour['Tour']['id']),
					'title' => __('Tour löschen', true)
				))
			: '';

		$tableCells[] = array(
			array(
				$tour['TourGroup']['tourgroupname'],
				array('class' => 'tourgroup')
			),
			array(
				$this->Html->link($tour['Tour']['title'], array('action' => $linkAction, $tour['Tour']['id'])),
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
				$deleteLink,
				array('class' => 'actions')
			)
		);

		$this->Js->buffer(sprintf("$('#%1\$s').click({ id: '%1\$s', title: '%2\$s'}, TourDB.Util.confirmationDialog);", sprintf('delete-%s', $tour['Tour']['id']), __('Tour löschen', true)));
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