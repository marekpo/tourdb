<?php
$this->set('title_for_layout', __('Touren ohne Tourenrapport', true));
$this->Html->addCrumb(__('Touren ohne Tourenrapport', true));

if(count($tours))
{
	$tableHeaders = array(
		$this->Paginator->sort(__('Status', true), 'TourStatus.rank'),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Datum von', true), 'Tour.startdate'),
		$this->Paginator->sort(__('Datum bis', true), 'Tour.enddate'),
		$this->Paginator->sort(__('TW', true), 'Tour.tourweek', array('title' => __('Tourenwoche', true))),
		$this->Paginator->sort(__('BGF', true), 'Tour.withmountainguide', array('title' => __('mit Bergführer durchgeführte/r Tour/Kurs', true))),
		__('Code', true),
		$this->Paginator->sort(__('Tourenleiter', true), 'TourGuide.username'),
		''
	);

	$tableCells = array();

	foreach($tours as $tour)
	{
		$emailLink = $this->Authorization->link('', array('controller' => 'tours', 'action' => 'reminderTourguideReport', $tour['Tour']['id']), array(
			'class' => 'iconaction email',
			'id' => sprintf('email-%s', $tour['Tour']['id']),
			'title' => __('E-Mail verschicken', true)
		));

		$tableCells[] = array(
			array(
				$tour['TourStatus']['statusname'],
				array('class' => 'status')
			),
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
				$emailLink,
				array('class' => 'actions')
			)
		);

		$this->Js->buffer(sprintf("$('#%s').click({ id: '%s', title: '%s'}, TourDB.Util.confirmationDialog);", sprintf('email-%s', $tour['Tour']['id']), sprintf('email-dialog-%s', $tour['Tour']['id']), __('E-Mail verschicken', true)));
	}

	echo $this->Widget->table($tableHeaders, $tableCells);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Touren gefunden.', true));
}

echo $this->element('paginator');