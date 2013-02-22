<?php
$this->set('title_for_layout', __('E-Mail an TourenleiterIn verschicken', true));
$this->Html->addCrumb($this->data['Tour']['title']);
$this->Html->addCrumb(__('E-Mail schicken', true));

echo $this->Html->para('', sprintf(
	__('Hiermit wird eine Erinnerungsemail an %s verschickt.', true), 	$this->TourDisplay->getTourGuide($this->data)
));

echo $this->Html->para('', __('Möchtest du fortfahren?', true));

echo $this->Form->create();
echo $this->Form->input('Tour.confirm', array('type' => 'hidden', 'value' => 1));
echo $this->Html->div('submit',
	$this->Form->submit(__('Abbrechen', true), array('name' => 'data[Tour][cancel]', 'div' => false, 'class' => 'cancel'))
	. $this->Form->submit(__('E-Mail verschicken', true), array('div' => false))
);