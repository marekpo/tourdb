<div class="tourFilter">
<?php
if(!isset($activeFilters))
{
	$activeFilters = array();
}

$this->Paginator->options(array('url' => array('?' => $this->data['Tour'])));

echo $this->Form->create(false, array('type' => 'GET', 'url' => $this->passedArgs));

if(in_array('deadline', $activeFilters))
{
	echo $this->Html->div('input radio',
		$this->Form->label(__('Anmeldeschluss', true))
		. $this->Form->input('Tour.deadline', array(
			'type' => 'radio', 'default' => '', 'legend' => false, 'div' => false, 'hiddenField' => false,
			'options' => array(
				'' => __('Alle', true),
				$this->Time->format('Y-m-d', time()) => __('Nur mit offener Anmeldung', true)
			),
		))
	);
}

if(in_array('title', $activeFilters))
{
	echo $this->Form->input('Tour.title', array('label' => __('Tourbezeichnung', true)));
}

$searchFilters = '';

if(in_array('date', $activeFilters))
{
	$searchFilters = $this->Html->div('daterange',
		$this->Widget->dateTime('Tour.startdate', array('label' => __('Datum von', true)))
		. $this->Widget->dateTime('Tour.enddate', array('label' => __('bis', true)))
	);
}

if(in_array('TourGuide', $activeFilters))
{
	foreach($tourGuides as $tourGuide)
	{
		$tourGuideOptions[$tourGuide['TourGuide']['id']] = $this->TourDisplay->getTourGuide($tourGuide);
	}
	
	$searchFilters .= $this->Form->input('Tour.TourGuide', array(
		'type' => 'select', 'options' => $tourGuideOptions, 'label' => __('Tourenleiter', true),
		'empty' => ''
	));
}

if(in_array('TourType', $activeFilters))
{
	$searchFilters .= $this->Html->div('input select',
		$this->Form->label(__('Tourentypen', true))
		. $this->Form->input('Tour.TourType', array(
			'label' => false, 'div' => false, 'multiple' => 'checkbox',
			'after' => $this->Html->div('', '', array('style' => 'clear: left')),
		)),
		array('id' => 'tourtypes')
	);
}

if(in_array('ConditionalRequisite', $activeFilters))
{
	$searchFilters .= $this->Form->input('Tour.ConditionalRequisite', array(
		'label' => __('Anforderungen', true), 'multiple' => 'checkbox',
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	));
}

if(in_array('Difficulty', $activeFilters))
{
	$searchFilters .= $this->Html->div('input select',
		$this->Form->label(__('Schwierigkeit', true))
		. $this->Html->div('difficulty-select checkbox-container',
			$this->Html->div('diff-s diff-h',
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			)
			. $this->Html->div('diff-h', $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesAlpineTour,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div('diff-w', $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div('diff-ss', $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div('diff-ks', $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div('diff-k diff-p', $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div('diff-e', $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesIceClimbing,
					'after' =>  $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
		)
		. $this->Html->div('', '', array('style' => 'clear: left'))
	);
	$this->Js->buffer(sprintf("$('#tourtypes input[type=checkbox]').click(TourDB.Tours.Form.switchDifficulty); TourDB.Tours.Form.switchDifficulty();"));
}

if($searchFilters)
{
	echo $this->Widget->collapsibleFieldset(__('Suchfilter', true), $searchFilters, $filtersCollapsed);
}

echo $this->Html->div('submit',
	$this->Form->submit(__('Suchen', true), array('div' => false, 'class' => 'action'))
	. $this->Html->div('',
		$this->Html->link(__('Suchfilter zurücksetzen', true), array('controller' => $this->params['controller'], 'action' => $this->params['action']))
	)
);

echo $this->Form->end();
?>
</div>