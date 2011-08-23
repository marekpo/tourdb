<div class="twothirds">
<?php
echo $this->Form->create('Tour');

if(!empty($this->data['Tour']['id']))
{
	echo $this->Form->hidden('id');
}

echo $this->Form->input('title', array(
	'label' => __('Tourbezeichnung', true),
	'error' => array(
		'notEmpty' => __('Die Tourbezeichnung darf nicht leer sein.', true)
	)
));

echo $this->Form->input('description', array('label' => __('Beschreibung', true)));
echo $this->Widget->dateTime('startdate', array(
	'label' => __('Startdatum', true),
	'error' => array(
		'notEmpty' => __('Das Startdatum der Tour darf nicht leer sein.', true)
	)
));
echo $this->Widget->dateTime('enddate', array(
	'label' => __('Enddatum', true),
	'error' => array(
		'notEmpty' => __('Das Enddatum der Tour darf nicht leer sein.', true),
		'greaterOrEqualStartDate' => __('Das Enddatum muss größer oder gleich dem Startdatum sein.', true)
	)
));

echo $this->Form->input('tourweek', array('label' => __('Tourenwoche', true)));
echo $this->Form->input('withmountainguide', array('label' => __('Mit dipl. Bergführer', true)));

echo $this->Html->div('', $this->Form->input('Tour.TourType', array(
	'label' => __('Tourentyp', true), 'multiple' => 'checkbox',
	'after' => $this->Html->div('', '', array('style' => 'clear: left')),
	'error' => array(
		'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Tourentypen gewählt werden.', true)
	)
)), array('id' => 'tourtypes'));

echo $this->Form->input('Tour.ConditionalRequisite', array(
	'label' => __('Anforderung', true), 'multiple' => 'checkbox',
	'after' => $this->Html->div('', '', array('style' => 'clear: left')),
	'error' => array(
		'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Anforderungen gewählt werden.', true)
	)
));

$difficultySelect = $this->Html->div('input select',
	$this->Form->label(__('Schwierigkeit', true))
	. $this->Html->div('difficulty-select',
		$this->Html->div('diff-s diff-h', 
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => array(
					'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
				)
			))
		)
		. $this->Html->div('diff-h', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesAlpineTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => array(
					'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
				)
			))
		))
		. $this->Html->div('diff-w', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => array(
					'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
				)
			))
		))
		. $this->Html->div('diff-ss', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => array(
					'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
				)
			))
		))
		. $this->Html->div('diff-ks', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => array(
					'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
				)
			))
		))
		. $this->Html->div('diff-k diff-p', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing,
				'after' => $this->Html->div('', '', array('style' => 'clear: left')),
				'error' => array(
					'atMostTwo' => __('Es dürfen maximal zwei Schwierigkeiten gewählt werden.', true)
				)
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
$this->Html->script('widgets/adjacenttours', array('inline' => false));
$this->Html->script('widgets/calendar', array('inline' => false));
$this->Js->buffer(sprintf("$('#tourtypes input[type=checkbox]').click(TourDB.Tours.Form.switchDifficulty); TourDB.Tours.Form.switchDifficulty();"));
$this->Js->buffer(sprintf("$('#adjacent-tours').adjacentTours({startDate: $('#TourStartdate'), endDate: $('#TourEnddate'), url: '%s'});", $this->Html->url(array('action' => 'formGetAdjacentTours'), true)));
$this->Js->buffer(sprintf("$('#openTourCalendar').click({ title: '%s' }, TourDB.Tours.Form.openTourCalendar);", __('Tourenkalender', true)
));
echo $this->Form->end(__('Speichern', true));