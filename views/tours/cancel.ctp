<?php
$this->set('title_for_layout', __('Tour absagen', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Tour absagen', true));

echo $this->Form->create();

echo $this->Form->hidden('Tour.id');

echo $this->Html->para('', __('Wenn du möchtest, kannst du den angemeldeten Teilnehmern der Tour noch eine persönliche Mitteilung machen. Wenn du das folgende Feld leer lässt, erhalten die angemeldeten Teilnehmer eine Standardmitteilung (E-mail) über die Absage der Tour.', true));

echo $this->Form->input('Tour.message', array('type' => 'textarea', 'label' => __('Nachricht', true)));

echo $this->Form->end(__('Speichern', true));