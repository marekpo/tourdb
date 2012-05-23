<?php
$this->set('title_for_layout', __('Tourenkalender', true));
$this->Html->addCrumb(__('Tourenkalender', true));

$this->Widget->includeCalendarScripts();
echo $this->Widget->calendar($tours, array('year' => $year, 'month' => $month, 'ajax' => false, 'viewlinks' => true));