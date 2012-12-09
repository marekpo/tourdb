<?php
$this->set('title_for_layout', __('Statistik Tourenübersicht exportieren', true));
$this->Html->addCrumb(__('Statistik Tourenübersicht exportieren', true));

echo $this->Form->create();
echo $this->element('../tours/elements/tour_export_filters');
echo $this->Form->input('Tour.exportExpenses', array('type' => 'checkbox', 'label' => __('Spesen mit exportieren', true)));
echo $this->Form->end(__('Statistik exportieren', true));

$this->Js->buffer("$('#TourStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#TourEnddate').datepicker('option', 'minDate', dateText); });");
