<?php
$this->set('title_for_layout', __('Neuen Termin hinzufügen', true));
$this->Html->addCrumb(__('Neuen Termin hinzufügen', true));

echo $this->element('../appointments/elements/appointment_form');