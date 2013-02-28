<?php
$this->set('channel', array(
	'title' => __('Aktuelle Anlässe', true),
	'link' => $this->Html->url(array('controller' => 'appointments', 'action' => 'upcomingAppointments', 'ext' => 'rss'), true),
	'description' => __('Alle aktuellen Anlässe des SAC Am Albis', true)
));

foreach($appointments as $appointment)
{
	echo $this->Rss->item(array(), array(
		'title' => sprintf('%s, %s, %s - %s',
			$appointment['Appointment']['title'], $appointment['Appointment']['location'],
			$this->Time->format('d.m.Y H:i', $appointment['Appointment']['startdate']),
			$this->Time->format('d.m.Y H:i', $appointment['Appointment']['enddate'])
		),
		'link' => $this->Html->url(array('controller' => 'appointments', 'action' => 'view', $appointment['Appointment']['id']), true),
		'guid' => $appointment['Appointment']['id'],
		'description' => $appointment['Appointment']['description'],
		'pubDate' => $this->Time->format('d.m.Y H:i:s', $appointment['Appointment']['startdate']),
	));
}
