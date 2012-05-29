<?php
$this->set('title_for_layout', __('Alle Termine', true));
$this->Html->addCrumb(__('Alle Termine', true));

if(count($appointments))
{
	$headers = array(
		$this->Paginator->sort(__('Titel', true), 'Appointment.title'),
		$this->Paginator->sort(__('Startdatum', true), 'Appointment.startdate'),
		$this->Paginator->sort(__('Enddatum', true), 'Appointment.enddate'),
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
				$this->Time->format('d.m.Y', $appointment['Appointment']['startdate']),
				array('class' => 'startdate')
			),
			array(
				$this->Time->format('d.m.Y', $appointment['Appointment']['enddate']),
				array('class' => 'enddate')
			),
			array(
				$this->Authorization->link('', array('controller' => 'appointments', 'action' => 'delete', $appointment['Appointment']['id']), array(
					'class' => 'iconaction delete',
					'id' => sprintf('delete-%s', $appointment['Appointment']['id']),
					'title' => __('Termin löschen', true)
				)),
				array('class' => 'delete')
			)
		);

		$this->Js->buffer(sprintf("$('#%1\$s').click({ id: '%1\$s', title: '%2\$s'}, TourDB.Util.confirmationDialog);", sprintf('delete-%s', $appointment['Appointment']['id']), __('Termin löschen', true)));
	}

	echo $this->Widget->table($headers, $rows);
}
else
{
	echo $this->Html->para('', __('Zu den gewählten Suchkriterien wurden keine Termine gefunden.', true));
}

echo $this->element('paginator');