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

echo $this->Form->input('TourType', array('label' => __('Tourentyp', true), 'multiple' => 'checkbox', 'after' => $this->Html->div('', '', array('style' => 'clear: left'))));

echo $this->Form->input('ConditionalRequisite', array('label' => __('Anforderung', true), 'multiple' => 'checkbox', 'after' => $this->Html->div('', '', array('style' => 'clear: left'))));

echo $this->Html->div('input select first-row-select',
	$this->Form->input('Difficulty', array(
		'label' => __('Schwierigkeit', true), 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
		'div' => false, 'after' => $this->Html->div('', '', array('style' => 'clear: left'))))
);

echo $this->Html->div('no-label-select',
	preg_replace('/<input.*?type="hidden".*?>/', '', $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	)))
	. preg_replace('/<input.*?type="hidden".*?>/', '', $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	)))
	. preg_replace('/<input.*?type="hidden".*?>/', '', $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	)))
	. preg_replace('/<input.*?type="hidden".*?>/', '', $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing1,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	)))
	. preg_replace('/<input.*?type="hidden".*?>/', '', $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing2,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	)))
);

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
<div>
  <div><?php __('Angrenzende Touren'); ?></div>
  <div id="adjacent-tours" class="adjacent-tours"></div>
</div>
<div style="clear: left"></div>
<?php
$this->Html->script('widgets/adjacenttours', array('inline' => false));
$this->Js->buffer(sprintf("$('#adjacent-tours').adjacentTours({startDate: $('#TourStartdate'), endDate: $('#TourEnddate'), url: '%s'});", $this->Html->url(array('action' => 'getAdjacentTours'), true)));

echo $this->Form->end(__('Speichern', true));
?>