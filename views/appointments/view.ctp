<?php
$this->set('title_for_layout', $appointment['Appointment']['title']);
$this->Html->addCrumb($appointment['Appointment']['title']);

$startdate = $this->Time->format('d.m.Y', $appointment['Appointment']['startdate']);
$enddate = $this->Time->format('d.m.Y', $appointment['Appointment']['enddate']);

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Datum', true))
			. $this->Html->div('content',
				($startdate == $enddate
					? $startdate
					: sprintf('%s - %s', $startdate, $enddate))
			)
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Beginn', true))
			. $this->Html->div('content', $this->Time->format('H:i', $appointment['Appointment']['startdate']))
		)
	)
	. $this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Ort', true))
			. $this->Html->div('content', $appointment['Appointment']['location'])
		) 
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Ende', true))
			. $this->Html->div('content', $this->Time->format('H:i', $appointment['Appointment']['enddate']))
		)
	)
);

echo $this->Html->tag('h2', __('Beschreibung', true));

echo $this->Display->formatText($appointment['Appointment']['description']);