<?php
foreach($adjacentTours as $adjacentTour)
{
	echo $this->Html->div('adjacent-tour',
		$this->Html->div('title', $adjacentTour['Tour']['title'], array('title' => $adjacentTour['Tour']['title']))
		. $this->Html->div('date', sprintf('%s - %s',
			$this->Time->format('d.m.Y', $adjacentTour['Tour']['startdate']),
			$this->Time->format('d.m.Y', $adjacentTour['Tour']['enddate'])
		))
		. $this->Html->div('tourguide', sprintf(__('Geführt von %s', true), $this->Html->link(
			$adjacentTour['TourGuide']['username'],
			array('controller' => 'users', 'action' => 'showProfile', $adjacentTour['TourGuide']['id'])
		)))
	);
}