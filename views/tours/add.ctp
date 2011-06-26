<?php
$this->set('title_for_layout', __('Neue Tour anlegen', true));
echo $this->Html->tag('h1', __('Neue Tour anlegen', true));

echo $this->Form->create('Tour');

echo $this->Form->input('title', array(
	'label' => __('Tourbezeichnung', true),
	'error' => array(
		'notEmpty' => __('Die Tourbezeichnung darf nicht leer sein.', true)
	)
));

echo $this->Form->input('description', array('label' => __('Beschreibung', true)));
?>
<div class="form">
<?php
echo $this->Form->input('tourweek', array('label' => __('Tourenwoche', true)));
echo $this->Form->input('withmountainguide', array('label' => __('Mit dipl. Bergführer', true)));

echo $this->Form->input('Tour.TourType', array(
	'label' => __('Tourentyp', true), 'multiple' => 'checkbox',
	'after' => $this->Html->div('', '', array('style' => 'clear: left')),
	'error' => array(
		'atLeastOne' => __('Es muss mindestens ein Tourentyp gewählt werden.', true)
	)
));

echo $this->Form->input('Tour.ConditionalRequisite', array(
	'label' => __('Anforderung', true), 'multiple' => 'checkbox',
	'after' => $this->Html->div('', '', array('style' => 'clear: left')),
	'error' => array(
		'atLeastOne' => __('Es muss mindestens eine Anforderung gewählt werden.', true)
	)
));

$difficultySelect = $this->Html->div('input select first-row-select',
	$this->Form->input('Tour.Difficulty', array(
		'label' => __('Schwierigkeit', true), 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
		'div' => false, 'after' => $this->Html->div('', '', array('style' => 'clear: left')),
		'error' => false
	))
);

$difficultySelect .= $this->Html->div('no-label-select',
	$this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => false
	)))
	. $this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => false
	)))
	. $this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => false
	)))
	. $this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing1,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => false
	)))
	. $this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing2,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => false
	)))
	. $this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing3,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => false
	)))
	. $this->Widget->stripHidden($this->Form->input('Tour.Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing4,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')),
		'error' => array(
			'atLeastOne' => __('Es muss mindestens eine Schwierigkeit gewählt werden.', true)
		)
	)))
);

if(isset($this->validationErrors['Tour']['Difficulty']))
{
	$difficultySelect = $this->Html->div('error', $difficultySelect);
}

echo $difficultySelect;

echo $this->Widget->dateTime('startdate', array(
	'label' => __('Startdatum', true),
	'error' => array(
		'notEmpty' => __('Das Startdatum der Tour darf nicht leer sein.', true)
	)
));
echo $this->Widget->dateTime('enddate', array(
	'label' => __('Enddatum', true),
	'error' => array(
		'notEmpty' => __('Das Enddatum der Tour darf nicht leer sein.', true)
	)
));
?>
</div>
<div class="adjacent-tours-container">
  <div>
    <?php __('Angrenzende Touren'); ?>
    <div><?php echo $this->Html->link(__('Tourenkalender', true), array('action' => 'addGetTourCalendar', 2011, 6), array('id' => 'openTourCalendar')); ?></div>
  </div>
  <div id="adjacent-tours" class="adjacent-tours"></div>
</div>
<div style="clear: left"></div>
<?php
$this->Html->script('widgets/adjacenttours', array('inline' => false));
$this->Js->buffer(sprintf("$('#adjacent-tours').adjacentTours({startDate: $('#TourStartdate'), endDate: $('#TourEnddate'), url: '%s'});", $this->Html->url(array('action' => 'addGetAdjacentTours'), true)));
$this->Js->buffer(sprintf("
	$('#openTourCalendar').click(function() {
		var url = this.href;
		var calendar = $('#addTourCalendar');

		if(calendar.length == 0) {
			calendar = $('<div id=\"addTourCalendar\" style=\"display: hidden\" />').appendTo('body');
		}

		calendar.load(url, {}, function(responseText, status, request) {
			calendar.dialog({ width: 'auto', draggable: false, modal: true, resizable: false, title: '%s' });
		});

		return false;
	});
", __('Tourenkalender', true)));
echo $this->Form->end(__('Speichern', true));
?>