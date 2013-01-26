<?php
$this->set('title_for_layout', __('Teilnehmer hinzufügen', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Teilnehmer hinzufügen', true));

echo $this->Form->create(false, array('url' => array($tour['Tour']['id'])));

echo $this->element('../tour_participations/elements/tour_participation_form', array('showEmail' => true));
?>
<fieldset class="note">
  <legend><?php __('Mitteilung des Teilnehmers/der Teilnehmerin'); ?></legend>
<?php
echo $this->Html->para('', __('In das folgende Textfeld kannst du beliebige zusätzliche Informationen des Teilnehmers/der Teilnehmerin, z.B. fehlende Ausrüstung oder etwas Organisatorisches (eigener PW, anz. freie Plätze), eintragen.', true));

echo $this->Form->input('TourParticipation.note_participant', array('label' => __('Mitteilung TeilnehmerIn', true), 'tabindex' => 41));
?>
</fieldset>
<?php
echo $this->Form->end(array('label' => __('Speichern', true), 'tabindex' => 42));