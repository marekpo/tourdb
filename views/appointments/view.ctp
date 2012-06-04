<?php
$this->set('title_for_layout', $appointment['Appointment']['title']);
$this->Html->addCrumb($appointment['Appointment']['title']);

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Datum', true))
			. $this->Html->div('content',
				($appointment['Appointment']['startdate'] == $appointment['Appointment']['enddate']
					? $this->Time->format('d.m.Y', $appointment['Appointment']['startdate'])
					: sprintf('%s - %s', $this->Time->format('d.m.Y', $appointment['Appointment']['startdate']), $this->Time->format('d.m.Y', $appointment['Appointment']['enddate'])))
			)
		)
	)
	. $this->Html->div('half', '')
);

echo $this->Html->tag('h2', __('Beschreibung', true));

echo $this->Display->formatText($appointment['Appointment']['description']);