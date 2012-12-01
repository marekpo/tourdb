<?php
$this->set('title_for_layout', __('Meine Touren', true));
$this->Html->addCrumb(__('Meine Touren', true));

echo $this->element('../tours/elements/tour_filters', array('activeFilters' => array(
	'title', 'TourGroup', 'range', 'date', 'TourType', 'ConditionalRequisite', 'Difficulty'
)));

if(count($tours))
{
	$tableHeaders = array(
		'',
		$this->Paginator->sort(__('Datum', true), 'Tour.startdate'),
		__('Tag', true),
		$this->Paginator->sort(__('Tourbezeichnung', true), 'Tour.title'),
		$this->Paginator->sort(__('Gruppe', true), 'TourGroup.tourgroupname'),
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
					$this->TourDisplay->getStatusIcon($tour),
					array('class' => 'status')
			),
			array(
					$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
					array('class' => 'startdate')
			),
			array(
					$this->TourDisplay->getDayOfWeekText($tour),
					array('class' => 'dayofweek')
			),			
			array(
				$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
					'action' => $linkAction, $tour['Tour']['id']
				))
				. ($tour['Tour']['tourweek'] == 1 ? sprintf(' %s', __('TW',true)) : '')
				. ($tour['Tour']['withmountainguide'] == 1 ? sprintf(' %s', __('BGF',true)) : '')
				 ,
				array('class' => 'title')
			),
			array(
				$tour['TourGroup']['tourgroupname'],
				array('class' => 'tourgroup')
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

		$this->Js->buffer(sprintf("$('#%s').click({ id: '%s', title: '%s'}, TourDB.Util.confirmationDialog);", sprintf('delete-%s', $tour['Tour']['id']), sprintf('delete-dialog-%s', $tour['Tour']['id']), __('Tour löschen', true)));
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