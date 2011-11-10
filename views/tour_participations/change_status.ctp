<?php
echo $this->Html->para('', __('', true));

echo $this->Form->create();

if(!empty($this->data['TourParticipation']['id']))
{
	echo $this->Form->hidden('TourParticipation.id');
}

echo $this->Form->input('TourParticipation.TourParticipationStatus', array('label' => __('Neuer Status', true)));

echo $this->Html->para('', __('Wenn du möchtest, kannst du dem Teilnehmer mit der Statusänderung noch eine persönliche Mitteilung machen. Wenn du das folgende Feld leer lässt, erhält der Teilnehmer eine Standardmitteilung über die Statusänderung seiner Anmeldung.', true));

echo $this->Form->input('TourParticipation.message', array('type' => 'textarea', 'label' => __('Nachricht', true)));

echo $this->Form->end(__('Speichern', true));