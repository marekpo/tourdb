<?php
$this->set('title_for_layout', __('Alle Anlässe', true));
$this->Html->addCrumb(__('Alle Anlässe', true));

if(count($appointments))
{
	$headers = array(
		$this->Paginator->sort(__('Titel', true), 'Appointment.title'),
		$this->Paginator->sort(__('Ort', true), 'Appointment.location'),
		$this->Paginator->sort(__('Beginn', true), 'Appointment.startdate'),
		$this->Paginator->sort(__('Ende', true), 'Appointment.enddate'),
		''
	);

	$rows = array();

	foreach($appointments as $appointment)
	{
		$rows[] = array(
			array(
				$this->Html->link($appointment['Appointment']['title'], array('action' => 'edit', $appointment['Appointment']['id'])),
				array('class' => 'title')
			),
			array(
				$appointment['Appointment']['location'],
				array('class' => 'location')
			),
			array(
				$this->Time->format('d.m.Y H:i', $appointment['Appointment']['startdate']),
				array('class' => 'startdate')
			),
			array(
				$this->Time->format('d.m.Y H:i', $appointment['Appointment']['enddate']),
				array('class' => 'enddate')
			),
			array(
				$this->Authorization->link('', array('controller' => 'appointments', 'action' => 'delete', $appointment['Appointment']['id']), array(
					'class' => 'iconaction delete',
					'id' => sprintf('delete-%s', $appointment['Appointment']['id']),
					'title' => __('Anlass löschen', true)
				)),
				array('class' => 'delete')
			)
		);

		$this->Js->buffer(sprintf("$('#%1\$s').click({ id: '%1\$s', title: '%2\$s'}, TourDB.Util.confirmationDialog);", sprintf('delete-%s', $appointment['Appointment']['id']), __('Anlass löschen', true)));
	}

	echo $this->Widget->table($headers, $rows);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Anlässe gefunden.', true));
}

echo $this->element('paginator');