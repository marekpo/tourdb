<?php
$this->set('title_for_layout', __('Neuen Anlass hinzufügen', true));
$this->Html->addCrumb(__('Neuen Anlass hinzufügen', true));

echo $this->element('../appointments/elements/appointment_form');