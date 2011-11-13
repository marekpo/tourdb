<?php
$this->set('title_for_layout', __('Anmeldung stornieren', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Anmeldung stornieren', true));

echo $this->Form->create();

echo $this->Form->hidden('TourParticipation.id');

echo $this->Html->para('', __('Wenn du möchtest, kannst du dem Tourenleiter noch eine persönliche Mitteilung machen. Wenn du das folgende Feld leer lässt, erhält der Tourenleiter eine Standardmitteilung über deine Absage.', true));

echo $this->Form->input('TourParticipation.message', array('type' => 'textarea', 'label' => __('Nachricht', true)));

echo $this->Form->end(__('Speichern', true));