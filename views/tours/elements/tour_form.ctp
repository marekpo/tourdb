<div class="twothirds">
<?php
echo $this->Form->create('Tour');

if(!empty($this->data['Tour']['id']))
{
	echo $this->Form->hidden('id');
}

echo $this->Form->input('tour_group_id', array(
	'label' => __('Gruppe', true), 'disabled' => !in_array('tour_group_id', $whitelist)
));
echo $this->Form->input('title', array(
	'label' => __('Tourbezeichnung', true), 'disabled' => !in_array('title', $whitelist),
	'error' => array(
		'notEmpty' => __('Die Tourbezeichnung darf nicht leer sein.', true)
	)
));
echo $this->Form->input('description', array(
	'label' => __('Beschreibung', true), 'disabled' => !in_array('description', $whitelist)
));

echo $this->Widget->dateTime('startdate', array(
	'label' => __('Startdatum', true), 'disabled' => !in_array('startdate', $whitelist),
	'error' => array(
		'notEmpty' => __('Das Startdatum der Tour darf nicht leer sein.', true)
	)
));
echo $this->Widget->dateTime('enddate', array(
	'label' => __('Enddatum', true), 'disabled' => !in_array('enddate', $whitelist),
	'error' => array(
		'notEmpty' => __('Das Enddatum der Tour darf nicht leer sein.', true),
		'greaterOrEqualStartDate' => __('Das Enddatum muss größer oder gleich dem Startdatum sein.', true)
	)
));

echo $this->Widget->dateTime('deadline', array(
	'label' => __('Anmeldeschluss', true), 'disabled' => !in_array('deadline', $whitelist),
	'error' => array(
		'lessThanStartDate' => __('Der Anmeldeschluss muss vor dem Startdatum liegen.', true)
	)
));

echo $this->Form->input('tourweek', array(
	'label' => __('Tourenwoche', true), 'disabled' => !in_array('tourweek', $whitelist)
));
echo $this->Form->input('withmountainguide', array(
	'label' => __('Mit dipl. Bergführer', true), 'disabled' => !in_array('withmountainguide', $whitelist)
));
echo $this->Form->input('signuprequired', array(
	'label' => __('Anmeldung erforderlich', true), 'disabled' => !in_array('signuprequired', $whitelist)
));

$tourTypeSelect = $this->Html->div('input select' . (isset($this->validationErrors['Tour']['TourType']) ? ' error' : ''),
	$this->Form->label(__('Tourentyp', true))
	. $this->Html->div('checkbox-container',
		$this->Form->input('Tour.TourType', array(
			'label' => false, 'multiple' => 'checkbox',
			'after' => $this->Html->div('', '', array('style' => 'clear: left')),
			'error' => array(
				'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Tourentypen gewählt werden.', true)
			)
		)),
		array('id' => 'tourtypes')
	)
	. $this->Html->div('', '', array('style' => 'clear: left'))
);

echo $tourTypeSelect;

if(!in_array('TourType', $whitelist))
{
	$this->Js->buffer("$('[id^=TourTourType]').attr('disabled', true)");
}

echo $this->element('../tours/elements/tour_form_conditional_requisite');

$difficultyErrorMessages =  array(
	'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
);

$difficultySelect = $this->Html->div('input select',
	$this->Form->label(__('Schwierigkeit', true))
	. $this->Html->div('difficulty-select checkbox-container',
		$this->Html->div('diff-s diff-h', 
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		)
		. $this->Html->div('diff-h', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesAlpineTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		))
		. $this->Html->div('diff-w', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		))
		. $this->Html->div('diff-ss', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		))
		. $this->Html->div('diff-ks', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		))
		. $this->Html->div('diff-k diff-p', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		))
		. $this->Html->div('diff-e', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesIceClimbing,
				'after' =>  $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => $difficultyErrorMessages
			))
		))
	)
	. $this->Html->div('', '', array('style' => 'clear: left'))
);

if(isset($this->validationErrors['Tour']['Difficulty']))
{
	$difficultySelect = $this->Html->div('error', $difficultySelect);
}

echo $difficultySelect;

if(!in_array('Difficulty', $whitelist))
{
	$this->Js->buffer("$('[id^=TourDifficulty]').attr('disabled', true)");
}

echo $this->Form->input('Tour.meetingplace', array(
	'label' => __('Treffpunkt', true), 'disabled' => !in_array('meetingplace', $whitelist)
));

echo $this->Form->input('Tour.meetingtime', array(
	'label' => __('Zeitpunkt', true), 'timeFormat' => 24,
	'disabled' => !in_array('meetingtime', $whitelist), 'default' => 0
));

echo $this->Form->input('Tour.transport', array(
	'label' => __('Verkehrsmittel', true), 'type' => 'select',
	'options' => $this->Display->getTransportOptions(), 'empty' => '',
	'disabled' => !in_array('transport', $whitelist)
));

echo $this->Form->input('Tour.travelcosts', array(
	'label' => __('Reisekosten (CHF)', true), 'disabled' => !in_array('travelcosts', $whitelist),
	'error' => array(
		'decnum' => __('Die Reisekosten müssen als Dezimalzahl eingegeben werden (z.B. 30.0).', true)
	)
));

echo $this->Form->input('Tour.planneddeparture', array(
	'label' => __('Rückreise (geplant)', true), 'disabled' => !in_array('planneddeparture', $whitelist)
));

echo $this->Form->input('Tour.equipment', array(
	'label' => __('Ausrüstung', true), 'disabled' => !in_array('equipment', $whitelist)
));

echo $this->Form->input('Tour.maps', array(
	'label' => __('Karten', true), 'disabled' => !in_array('maps', $whitelist)
));

echo $this->Form->input('Tour.auxiliarymaterial', array(
	'label' => __('Hilfsmittel', true), 'disabled' => !in_array('auxiliarymaterial', $whitelist)
));

echo $this->Form->input('Tour.timeframe', array(
	'label' => __('Zeitrahmen', true), 'disabled' => !in_array('timeframe', $whitelist)
));

echo $this->Form->input('Tour.altitudedifference', array(
	'label' => __('Höhendifferenz (m)', true), 'disabled' => !in_array('altitudedifference', $whitelist),
	'error' => array(
		'integer' => __('Die Höhendifferenz muss als ganze Zahl angegeben werden (z.B. 1000).', true)
	)
));

echo $this->Form->input('Tour.food', array(
	'label' => __('Verpflegung', true), 'disabled' => !in_array('food', $whitelist)
));

echo $this->Form->input('Tour.accomodation', array(
	'label' => __('Unterkunft', true), 'disabled' => !in_array('accomodation', $whitelist)
));

echo $this->Form->input('Tour.accomodationcosts', array(
	'label' => __('Unterk.Kosten (CHF)', true), 'disabled' => !in_array('accomodationcosts', $whitelist),
	'error' => array(
		'decnum' => __('Die Unterkunftskosten müssen als Dezimalzahl eingegeben werden (z.B. 30.0).', true)
	)
));

if(!empty($this->data['Tour']['id']) && in_array('tour_status_id', $whitelist) && !empty($newStatusOptions))
{
	echo $this->Form->input('change_status', array(
		'label' => __('Tourstatus ändern', true), 'options' => array_merge(
			array('' => __('nicht ändern', true)), $newStatusOptions
		)
	));
}
?>
</div>
<div class="third">
  <div class="adjacent-tours-container">
    <div class="open-calendar"><?php echo $this->Html->link(__('Kalender', true), array('action' => 'formGetTourCalendar', date('Y'), date('m')), array('id' => 'openTourCalendar')); ?></div>
    <?php __('Angrenzende Touren'); ?>
    <div id="adjacent-tours" class="adjacent-tours"></div>
  </div>
</div>
<div style="clear: left"></div>
<?php
$saveButtonText = empty($whitelist) ? __('Zurück', true) : __('Speichern', true);
echo $this->Form->end($saveButtonText);

$this->Widget->includeCalendarScripts();
$this->Js->buffer(sprintf("$('#tourtypes input[type=checkbox]').click(TourDB.Tours.Form.switchDifficulty); TourDB.Tours.Form.switchDifficulty();"));
$this->Js->buffer(sprintf("$('#adjacent-tours').adjacentTours({startDate: $('#TourStartdate'), endDate: $('#TourEnddate'), url: '%s'});", $this->Html->url(array('action' => 'formGetAdjacentTours'), true)));
$this->Js->buffer(sprintf("$('#openTourCalendar').click({ title: '%s' }, TourDB.Tours.Form.openTourCalendar);", __('Tourenkalender', true)));
$this->Js->buffer("$('#TourStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#TourEnddate').datepicker('option', 'minDate', dateText); });");