<?php
$this->set('title_for_layout', __('Anmeldung stornieren', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Anmeldung stornieren', true));

echo $this->Form->create();

echo $this->Form->hidden('TourParticipation.id');

echo $this->Html->para('', __('Wenn du möchtest, kannst du dem/der TourenleiterIn noch eine persönliche Mitteilung machen. Wenn du das folgende Feld leer lässt, erhält der/die TourenleiterIn eine Standardmitteilung (E-Mail) über deine Absage.', true));

echo $this->Form->input('TourParticipation.message', array('type' => 'textarea', 'label' => __('Nachricht', true)));

echo $this->Html->div('submit',
	$this->Form->submit(__('Abbrechen', true), array('name' => 'data[Tour][cancel]', 'div' => false, 'class' => 'cancel'))
	. $this->Form->submit(__('Speichern', true), array('div' => false))
);