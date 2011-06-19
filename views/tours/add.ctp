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
<div>
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
	$this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
		'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'hidden' => false
	))
	. $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	))
	. $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	))
	. $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing1,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	))
	. $this->Form->input('Difficulty', array(
		'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing2,
		'after' => $this->Html->div('', '', array('style' => 'clear: left'))
	))
);

echo $this->Form->input('startdate', array('label' => __('Startdatum', true), 'type' => 'text', 'class' => 'date'));
echo $this->Form->input('enddate', array('label' => __('Enddatum', true), 'type' => 'text', 'class' => 'date'));
?>
</div>
<?php
echo $this->Form->end(__('Speichern', true));
?>