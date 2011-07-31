<?php
$this->set('title_for_layout', __('Neue Tour anlegen', true));
$this->Html->addCrumb(__('Neue Tour anlegen', true));

echo $this->element('../tours/elements/tour_form');