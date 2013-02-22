<?php
$this->set('title_for_layout', __('E-Mail an Alle', true));
$this->Html->addCrumb(__('E-Mail an Alle', true));

echo $this->Html->para('', sprintf(__('Du kannst an alle TeilnehmerInnen der Tour "%s", die dem unten ausgewählten Status entsprechen, eine E-Mail schicken.', true), $this->data['Tour']['title']));
echo $this->Html->para('', __('Diese Aktion öffnet lediglich dein Standard-E-Mail-Programm und wählt entsprechende E-Mail Adressen aus.', true));
echo $this->Form->create();
echo $this->Form->hidden('Tour.id');
echo $this->Form->input('participationStatuses', array(
	'label' => __('Anmeldestatus', true),
	'multiple' => 'checkbox',
	'default' => $participationStatusDefault,
	'after' => $this->Html->div('', '', array('style' => 'clear: left')), 'error' => array(
		'notEmpty' => __('Es muss mindestens ein Anmeldestatus ausgewählt sein.', true)
	)
));

echo $this->Form->end(__('E-Mail bearbeiten', true));
