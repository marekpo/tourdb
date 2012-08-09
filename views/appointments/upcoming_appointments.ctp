<?php
$this->set('title_for_layout', __('Aktuelle Anlässe', true));
$this->Html->addCrumb(__('Aktuelle Anlässe', true));

for($i = 0; $i < count($appointments); $i++)
{
	$appointment = $appointments[$i];

	$startdate = $this->Time->format('d.m.Y', $appointment['Appointment']['startdate']);
	$enddate = $this->Time->format('d.m.Y', $appointment['Appointment']['enddate']);

	echo $this->Html->div('appointment ' . ($i % 2 == 0 ? '': 'even'),
		$this->Html->div('title', $this->Html->link($appointment['Appointment']['title'], array('controller' => 'appointments', 'action' => 'view', $appointment['Appointment']['id'])))
		. $this->Html->div('columncontainer',
			$this->Html->div('half', $this->Html->div('infoitem',
				$this->Html->div('label', __('Datum', true))
				. $this->Html->div('content', ($startdate == $enddate ? $startdate : sprintf('%s %s', $startdate, $enddate)))))
			. $this->Html->div('half', $this->Html->div('infoitem',
				$this->Html->div('label', __('Ort', true))
				. $this->Html->div('content', $appointment['Appointment']['location'])
			))
		)
	);
}