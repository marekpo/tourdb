<?php
$this->set('title_for_layout', __('Datenschutzbestimmungen', true));
$this->Html->addCrumb(__('Datenschutzbestimmungen', true));

echo $this->element('data_privacy_statement');