<?php

$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Tourenleiter', true))
	. $this->Html->div('content', $this->TourDisplay->getTourGuide($tour))
);

echo $this->Html->div('half',
	$this->Html->div('infoitem',
		$this->Html->div('label', __('Datum', true))
		. $this->Html->div('content', 
			($tour['Tour']['startdate'] == $tour['Tour']['enddate']
				? $this->Time->format('d.m.Y', $tour['Tour']['startdate'])
				: sprintf('%s - %s', $this->Time->format('d.m.Y', $tour['Tour']['startdate']), $this->Time->format('d.m.Y', $tour['Tour']['enddate'])))
		)
	)
	. $this->Html->div('infoitem',
		$this->Html->div('label', __('Anmeldeschluss', true))
		. $this->Html->div('content', $this->Time->format('d.m.Y', 0)/*$tour['Tour']['closingdate'])*/)
	)
	. $this->Html->div('infoitem',
		$this->Html->div('label', __('Tourencode', true))
		. $this->Html->div('content', $this->TourDisplay->getClassification($tour))
	)
);

echo $this->Html->div('half',
	$this->Html->div('infoitem',
		$this->Html->div('label', __('Tourenwoche', true))
		. $this->Html->div('content', $this->Display->displayFlag($tour['Tour']['tourweek']))
	)
	. $this->Html->div('infoitem',
		$this->Html->div('label', __('Bergführer', true))
		. $this->Html->div('content', $this->Display->displayFlag($tour['Tour']['withmountainguide']))
	)
);

echo $this->Html->div('infoitem', $this->Display->formatText($tour['Tour']['description']));