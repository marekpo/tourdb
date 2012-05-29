<?php
$this->set('title_for_layout', __('Termin bearbeiten', true));
$this->Html->addCrumb(__('Termin bearbeiten', true));

echo $this->element('../appointments/elements/appointment_form');