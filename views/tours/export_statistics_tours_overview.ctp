<?php
$this->set('title_for_layout', __('Statistik Tourenübersicht exportieren', true));
$this->Html->addCrumb(__('Statistik Tourenübersicht exportieren', true));

echo $this->element('../tours/elements/tour_export_filters');
