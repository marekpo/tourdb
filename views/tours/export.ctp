<?php
$this->set('title_for_layout', __('Touren exportieren', true));
$this->Html->addCrumb(__('Touren exportieren', true));

echo $this->Form->create();
echo $this->element('../tours/elements/tour_export_filters');
echo $this->Form->end(__('Touren exportieren', true));
$this->Js->buffer("$('#TourStartdate').datepicker('option', 'onSelect', function(dateText, datepicker) { $('#TourEnddate').datepicker('option', 'minDate', dateText); });");
