<?php
$this->set('title_for_layout', __('Tour bearbeiten', true));
$this->Html->addCrumb(__('Tour bearbeiten', true));

echo $this->element('../tours/elements/tour_form');