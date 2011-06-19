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

echo $this->Form->input('TourType', array('label' => __('Tourentyp', true), 'multiple' => 'checkbox'));

echo $this->Form->input('ConditionalRequisite', array('label' => __('Anforderungen', true), 'multiple' => 'checkbox'));

echo $this->Form->input('startdate', array('label' => __('Startdatum', true)));
echo $this->Form->input('enddate', array('label' => __('Enddatum', true)));
?>
</div>
<?php
echo $this->Form->end(__('Speichern', true));
?>