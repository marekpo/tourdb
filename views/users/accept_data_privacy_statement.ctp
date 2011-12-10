<?php
$this->set('title_for_layout', __('Datenschutzbestimmungen akzeptieren', true));
$this->Html->addCrumb(__('Datenschutzbestimmungen akzeptieren', true));

echo $this->Html->para('', __('Seit deinem letzten Besuch haben sich unsere Datenschutzbestimmungen geändert. Um unsere Dienste weiter in Anspruch nehmen zu können, musst du erst unsere neue Datenschutzbestimmungen akzeptieren.'));

echo $this->Html->div('dataPrivacyStatement', $this->element('data_privacy_statement'));

echo $this->Form->create();

echo $this->Form->input('User.dataprivacystatementaccepted', array(
	'label' => __('Datenschutzbestimmungen akzeptieren', true),
	'error' => array(
		'notAccepted' => __('Du musst die Datenschutzbestimmungen akzeptieren.', true)
	)
));

echo $this->Form->end(__('Akzeptieren', true));