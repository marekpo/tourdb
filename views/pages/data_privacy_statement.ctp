<?php
$this->set('title_for_layout', __('Datenschutzerklärung', true));
$this->Html->addCrumb(__('Datenschutzerklärung', true));

echo $this->element('data_privacy_statement');