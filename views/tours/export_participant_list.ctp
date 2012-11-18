<?php
$this->set('title_for_layout', __('Teilnehmerliste exportieren', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Teilnehmerliste exportieren', true));

echo $this->Html->para('', sprintf(__('Hier kannst du eine Liste aller bisher angemeldeten TeilnehmerInnen für die Tour "%s" herunterladen.', true), $this->data['Tour']['title']));

echo $this->Form->create();

echo $this->Form->hidden('Tour.id');

echo $this->Form->input('Tour.exportEmergencyContacts', array('type' => 'checkbox', 'label' => __('Notfallkontakte mit exportieren', true)));
echo $this->Form->input('Tour.exportExperienceInformation', array('type' => 'checkbox', 'label' => __('Erfahrung mit exportieren', true)));
echo $this->Form->input('Tour.exportAdditionalInformation', array('type' => 'checkbox', 'label' => __('Zusätzliche Informationen mit exportieren (Notiz und Status)', true)));
echo $this->Form->input('Tour.exportAffirmedParticipantsOnly', array('type' => 'checkbox', 'label' => __('Bestätigte TeilnehmerInnen exportieren', true)));

echo $this->Form->end(__('Teilnehmerliste exportieren', true));