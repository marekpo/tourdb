<div class="tourFilter">
<?php
if(!isset($activeFilters))
{
	$activeFilters = array();
}

$this->Paginator->options(array('url' => array('?' => $this->data['Tour'])));

echo $this->Form->create(false, array('type' => 'GET', 'url' => $this->passedArgs));

if(in_array('title', $activeFilters))
{
	echo $this->Form->input('Tour.title', array('label' => __('Tourbezeichnung', true)));
}

$searchFilters = '';

if(in_array('range', $activeFilters))
{
	$searchFilters .= $this->Form->input('Tour.range', array(
		'type' => 'radio', 'default' => Tour::FILTER_RANGE_CURRENT, 'legend' => false, 'hiddenField' => false,
		'options' => array(
			Tour::FILTER_RANGE_ALL => __('Alle', true),
			Tour::FILTER_RANGE_CURRENT => __('Aktuell', true)
		),
	));
}

if(in_array('TourGroup', $activeFilters))
{
	$searchFilters .= $this->Form->input('Tour.TourGroup', array(
		'type' => 'select', 'label' => __('Tourengruppe', true),
		'empty' => ''
	));
}

if(in_array('TourStatus', $activeFilters))
{
	$searchFilters .= $this->Form->input('Tour.TourStatus', array(
		'label' => __('Tourenstatus', true), 'multiple' => 'checkbox',
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	));
}

if(in_array('date', $activeFilters))
{
	$searchFilters .= $this->Html->div('daterange',
		$this->Widget->dateTime('Tour.startdate', array('label' => __('Datum von', true)))
		. $this->Widget->dateTime('Tour.enddate', array('label' => __('bis', true)))
	);
	$this->Js->buffer("$('#TourStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#TourEnddate').datepicker('option', 'minDate', dateText); });");
}

if(in_array('TourGuide', $activeFilters))
{
	$tourGuideOptions = array();

	foreach($tourGuides as $tourGuide)
	{
		$tourGuideOptions[$tourGuide['TourGuide']['id']] = $this->TourDisplay->getTourGuide($tourGuide, true);
	}

	$searchFilters .= $this->Form->input('Tour.TourGuide', array(
		'type' => 'select', 'options' => $tourGuideOptions, 'label' => __('TourenleiterIn', true),
		'empty' => ''
	));
}

if(in_array('TourType', $activeFilters))
{
	$searchFilters .= $this->Widget->tourTypes(array(
		'get' => true,
		'error' => array(
			'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Anforderungen gewählt werden.', true)
		)
	));
}

if(in_array('ConditionalRequisite', $activeFilters))
{
	$searchFilters .= $this->Widget->conditionalRequisites(array(
		'get' => true,
		'error' => array(
			'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Anforderungen gewählt werden.', true)
		)
	));
}

if(in_array('Difficulty', $activeFilters))
{
	$searchFilters .= $this->Html->div('input select',
		$this->Form->label(__('Schwierigkeit', true))
		. $this->Html->div('difficulty-select checkbox-container',
			$this->Html->div(sprintf('diff-%s diff-%s', TourType::SKI_TOUR, TourType::ALPINE_TOUR),
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			)
			. $this->Html->div(sprintf('diff-%s', TourType::ALPINE_TOUR), $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesAlpineTour,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div(sprintf('diff-%s', TourType::HIKE), $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div(sprintf('diff-%s', TourType::SNOWSHOE_TOUR), $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div(sprintf('diff-%s', TourType::VIA_FERRATA), $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div(sprintf('diff-%s diff-%s', TourType::ROCK_CLIMBING, TourType::PLAISIR_CLIMBING), $this->Widget->stripHidden(
				$this->Form->input('Tour.Difficulty', array(
					'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing,
					'after' => $this->Html->div('', '', array('style' => 'clear: left'))
				))
			))
			. $this->Html->div(sprintf('diff-%s', TourType::ICE_CLIMBING), $this->Widget->stripHidden(
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

echo $this->Html->para('', sprintf(__('Hier findest du die Erklärungen zu den verwendeten %s', true), $this->Html->link(__('Tourencodes', true), 'http://sac-baldern.ch/joomlaLive/index.php/touren-und-anlaesse/tourencodes', array('target' => '_blank'))));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->submit(__('Suchen', true), array('div' => array('class' => 'submit obtrusive')))
	)
	. $this->Html->div('half obtrusive links',
		$this->Html->link(__('Suchfilter zurücksetzen', true), array('controller' => $this->params['controller'], 'action' => $this->params['action']))
	)
);

echo $this->Form->end();
?>
</div>