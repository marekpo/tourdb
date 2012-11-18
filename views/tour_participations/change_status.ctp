<?php
echo $this->Form->create();

if(!empty($this->data['TourParticipation']['id']))
{
	echo $this->Form->hidden('TourParticipation.id');
}

echo $this->Form->input('TourParticipation.tour_participation_status_id', array('label' => __('Neuer Status', true)));

echo $this->Html->para('', __('Wenn du möchtest, kannst du dem/der TeilnehmerIn mit der Statusänderung noch eine persönliche Mitteilung machen. Wenn du das folgende Feld leer lässt, erhält der/die TeilnehmerIn eine Standardmitteilung (E-Mail) über die Statusänderung seiner Anmeldung.', true));

echo $this->Form->input('TourParticipation.message', array('type' => 'textarea', 'label' => __('Nachricht', true)));

echo $this->Html->div('submit',
	$this->Form->submit(__('Abbrechen', true), array('name' => 'data[Tour][cancel]', 'div' => false, 'class' => 'cancel'))
	. $this->Form->submit(__('Speichern', true), array('div' => false))
);