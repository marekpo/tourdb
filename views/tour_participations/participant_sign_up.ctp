<?php
$this->set('title_for_layout', __('Anmelden', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Anmelden', true));

echo $this->Html->para('', __('Um dich zu dieser Tour anmelden zu können musst du zunächst deine Kontaktdaten überprüfen und ggf. ergänzen. Die mit einem Stern markierten Felder sind Pflichtfelder und müssen vor der Anmeldung ausgefüllt werden.', true));

echo $this->Form->create(false, array('url' => array($tour['Tour']['id'])));

echo $this->element('../tour_participations/elements/tour_participation_form');
?>
<fieldset class="note">
  <legend><?php __('Mitteilung an den Tourenleiter/die Tourenleiterin'); ?></legend>
<?php
echo $this->Html->para('', __('In dem folgenden Textfeld kannst du dem/der TourenleiterIn noch beliebige Informationen, z.B. fehlende Ausrüstung oder etwas Organisatorisches (eigener PW, anz. freie Plätze), zukommen lassen.', true));

echo $this->Form->input('TourParticipation.note_participant', array('label' => __('Mitteilung an TourenleiterIn', true), 'tabindex' => 41));

echo $this->Html->para('', __('Wenn du dem/der TourenleiterIn noch nicht bekannt bist, gib bitte 3 Referenzen mit dem Namen des/der Tourenleiters/in von vergleichbaren Touren der letzten zwei Jahre an.', true));
?>
</fieldset>
<?php
echo $this->Form->end(array('label' => __('Speichern', true), 'tabindex' => 42));