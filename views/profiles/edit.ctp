<?php
$this->set('title_for_layout', __('Profil bearbeiten', true));
$this->Html->addCrumb(__('Profil bearbeiten', true));

echo $this->Form->create();
?>
<fieldset>
  <legend><?php __('Kontaktdaten'); ?></legend>
<?php
echo $this->Html->div('half', $this->Form->input('firstname', array(
	'label' => __('Vorname', true), 'div' => 'input text firstname'
)));
echo $this->Html->div('half', $this->Form->input('lastname', array(
	'label' => __('Nachname', true), 'div' => 'input text lastname'
)));

echo $this->Html->div('', '', array('style' => 'clear: left'));
?>
</fieldset>
<?php
echo $this->Form->end(__('Speichern', true));