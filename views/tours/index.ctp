<?php
$this->set('title_for_layout', __('Alle Touren', true));
$this->Html->addCrumb(__('Alle Touren', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'TourGroup', 'range', 'TourStatus', 'date', 'TourGuide', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
	$tableHeaders = array(
		'',
		$this->Paginator->sort(__('Gruppe', true), 'TourGroup.tourgroupname'),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Datum von', true), 'Tour.startdate'),
		$this->Paginator->sort(__('Datum bis', true), 'Tour.enddate'),
		$this->Paginator->sort(__('TW', true), 'Tour.tourweek', array('title' => __('Tourenwoche', true))),
		$this->Paginator->sort(__('BGF', true), 'Tour.withmountainguide', array('title' => __('mit Bergführer durchgeführte/r Tour/Kurs', true))),
		__('Code', true),
		$this->Paginator->sort(__('TourenleiterIn', true), 'TourGuide.username'),
		''
	);

	$tableCells = array();

	foreach($tours as $tour)
	{
		$deleteLink = $tour['TourStatus']['key'] == TourStatus::NEW_
			? $this->Authorization->link('', array('controller' => 'tours', 'action' => 'delete', $tour['Tour']['id']), array(
					'class' => 'iconaction delete',
					'id' => sprintf('delete-%s', $tour['Tour']['id']),
					'title' => __('Tour löschen', true)
				))
			: '';

		$editLink = $this->Authorization->link($tour['Tour']['title'], array('action' => 'edit', $tour['Tour']['id']));
		$tourTitle = $editLink !== false ? $editLink : $tour['Tour']['title'];

		$tableCells[] = array(
			array(
				$this->TourDisplay->getStatusIcon($tour),
				array('class' => 'status')
			),
			array(
				$tour['TourGroup']['tourgroupname'],
				array('class' => 'tourgroup')
			),
			array(
				$tourTitle,
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
				$this->TourDisplay->getTourGuide($tour),
				array('class' => 'tourguide')
			),
			array(
				$deleteLink,
				array('class' => 'actions')
			)
		);

		$this->Js->buffer(sprintf("$('#%s').click({ id: '%s', title: '%s'}, TourDB.Util.confirmationDialog);", sprintf('delete-%s', $tour['Tour']['id']), sprintf('delete-dialog-%s', $tour['Tour']['id']), __('Tour löschen', true)));
	}

	echo $this->Widget->table($tableHeaders, $tableCells);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Touren gefunden.', true));
}

echo $this->element('paginator');