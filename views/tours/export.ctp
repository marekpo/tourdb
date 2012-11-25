<?php
$this->set('title_for_layout', __('Touren exportieren', true));
$this->Html->addCrumb(__('Touren exportieren', true));

echo $this->element('../tours/elements/tour_export_filters');
