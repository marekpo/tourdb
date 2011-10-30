<?php
$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title']);

echo $this->element('../tours/elements/tour_edit_bar', array('tour' => $tour));

echo $this->Html->div('infoitem',
	$this->Html->div('label', __('Tourenleiter', true))
	. $this->Html->div('content', $this->TourDisplay->getTourGuide($tour))
);

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
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
			. $this->Html->div('content', $this->Time->format('d.m.Y', $tour['Tour']['deadline_calculated']))
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Tourencode', true))
			. $this->Html->div('content', $this->TourDisplay->getClassification($tour))
		)
	)
	. $this->Html->div('half',
		$this->Html->div('infoitem',
			$this->Html->div('label', __('Tourenwoche', true))
			. $this->Html->div('content', $this->Display->displayFlag($tour['Tour']['tourweek']))
		)
		. $this->Html->div('infoitem',
			$this->Html->div('label', __('Bergführer', true))
			. $this->Html->div('content', $this->Display->displayFlag($tour['Tour']['withmountainguide']))
		)
	)
);

echo $this->Html->tag('h2', __('Tourendetails', true));

echo $this->Display->formatText($tour['Tour']['description']);

echo $this->Html->tag('h2', __('Anmeldung', true));

if($registrationOpen && !$currentUserAlreadySignedUp)
{
	echo $this->Html->div('columncontainer',
		$this->Html->div('third', 
			$this->Form->create(false, array('type' => 'GET', 'url' => array('action' => 'signUp', $tour['Tour']['id'])))
			. $this->Html->div('submit', $this->Form->submit(__('Zur Tour anmelden', true), array('div' => false, 'class' => 'action', 'disabled' => !$this->Session->check('Auth.User'))))
			. $this->Form->end()
		)
		. (!$this->Session->check('Auth.User') ? $this->Html->div('twothirds',
			sprintf(__('Um dich zur dieser Tour anmelden zu können, musst du dich %s. Wenn du noch kein Benutzerkonto hast, musst du dich zuerst %s.', true),
				$this->Html->link(__('einloggen', true), array('controller' => 'users', 'action' => 'login')),
				$this->Html->link(__('registrieren', true), array('controller' => 'users', 'action' => 'createAccount'))
			)
		) : '')
	);
}

if($currentUserAlreadySignedUp)
{
	echo $this->Html->para('', __('Du bist bereits zu dieser Tour angemeldet.', true));
}

echo $this->element('../tours/elements/tour_edit_bar', array('tour' => $tour));