<div class="twothirds">
<?php
echo $this->Form->create('Tour');

if(!empty($this->data['Tour']['id']))
{
	echo $this->Form->hidden('id');
}

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
	'label' => __('Anmeldeschluss', true), 'disabled' => !in_array('deadline', $whitelist)
));

echo $this->Form->input('tourweek', array(
	'label' => __('Tourenwoche', true), 'disabled' => !in_array('tourweek', $whitelist)
));
echo $this->Form->input('withmountainguide', array(
	'label' => __('Mit dipl. Bergführer', true), 'disabled' => !in_array('withmountainguide', $whitelist)
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

echo $this->Form->input('Tour.ConditionalRequisite', array(
	'label' => __('Anforderung', true), 'multiple' => 'checkbox',
	'after' => $this->Html->div('', '', array('style' => 'clear: left')),
	'error' => array(
		'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Anforderungen gewählt werden.', true)
	)
));

if(!in_array('ConditionalRequisite', $whitelist))
{
	$this->Js->buffer("$('[id^=TourConditionalRequisite]').attr('disabled', true)");
}


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

$this->Html->script('widgets/adjacenttours', array('inline' => false));
$this->Html->script('widgets/calendar', array('inline' => false));
$this->Js->buffer(sprintf("$('#tourtypes input[type=checkbox]').click(TourDB.Tours.Form.switchDifficulty); TourDB.Tours.Form.switchDifficulty();"));
$this->Js->buffer(sprintf("$('#adjacent-tours').adjacentTours({startDate: $('#TourStartdate'), endDate: $('#TourEnddate'), url: '%s'});", $this->Html->url(array('action' => 'formGetAdjacentTours'), true)));
$this->Js->buffer(sprintf("$('#openTourCalendar').click({ title: '%s' }, TourDB.Tours.Form.openTourCalendar);", __('Tourenkalender', true)
));
