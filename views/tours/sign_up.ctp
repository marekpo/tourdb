<?php
$this->set('title_for_layout', $tour['Tour']['title']);
$this->Html->addCrumb($tour['Tour']['title'], array('action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Anmelden', true));

echo $this->Html->para('', __('Um dich zu dieser Tour anmelden zu können musst du zunächst deine Kontaktdaten überprüfen und ggf. ergänzen. Die mit einem Stern markierten Felder sind Pflichtfelder und müssen vor der Anmeldung ausgefüllt werden.', true));

echo $this->Form->create(false, array('url' => array($tour['Tour']['id'])));

echo $this->element('../profiles/elements/contact_data');

echo $this->element('../profiles/elements/experience_data');

echo $this->element('../profiles/elements/sac_membership_data');
?>
<fieldset class="experience">
  <legend><?php __('Mitteilung an den Tourenleiter/die Tourenleiterin'); ?></legend>
<?php
echo $this->Html->para('', __('In dem folgenden Textfeld kannst du dem Tourenleiter noch beliebige Informationen, z.B. fehlende Ausrüstung oder etwas Organisatorisches, zukommen lassen.', true));

echo $this->Form->input('TourParticipation.note_participant', array('label' => __('Mitteilung an Tourenleiter/in', true)));
?>
</fieldset>
<?php
echo $this->Form->end(__('Anmelden', true));