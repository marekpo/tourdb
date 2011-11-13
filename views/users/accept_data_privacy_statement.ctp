<?php
$this->set('title_for_layout', __('Datenschutzerklärung akzeptieren', true));
$this->Html->addCrumb(__('Datenschutzerklärung akzeptieren', true));

echo $this->Html->para('', __('Seit deinem letzten Besuch hat sich unsere Datenschutzerklärung geändert. Um unsere Dienste weiter in Anspruch nehmen zu können, musst du erst unsere neue Datenschutzerklärung akzeptieren.'));

echo $this->Html->div('dataPrivacyStatement', $this->element('data_privacy_statement') . '<br /> öasodifh asoöfhi aösodfih asöodfhi asöodfiha södofihas döofi hasdoöfih asödofihasödofiashdöfiohasdöfoihas döfoihasd öfoiashdföoiashföoisdhf öoasihf öasodifh asöodifh aösoifh <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />');

echo $this->Form->create();

echo $this->Form->input('User.dataprivacystatementaccpted', array(
	'label' => __('Datenschutzerklärung akzeptieren', true),
	'error' => array(
		'notAccepted' => __('Du musst die Datenschutzerklärung akzeptieren.', true)
	)
));

echo $this->Form->end(__('Akzeptieren', true));