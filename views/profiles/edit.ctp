<?php
$this->set('title_for_layout', __('Profil bearbeiten', true));
$this->Html->addCrumb(__('Profil bearbeiten', true));

echo $this->Form->create();

echo $this->element('../profiles/elements/contact_data');

echo $this->element('../profiles/elements/experience_data');

echo $this->element('../profiles/elements/sac_membership_data');
?>
<div class="profiles">
  <fieldset class="mobility">
    <legend><?php __('Mobilität'); ?></legend>
<?php
echo $this->Form->input('Profile.publictransportsubscription', array(
	'label' => __('ÖV-Abo', true), 'empty' => __('Keins', true),
	'options' => $this->Display->getPublictransportSubscriptionOptions()
));
echo $this->Form->input('Profile.ownpassengercar', array(
	'label' => __('Eigener PKW', true), 'after' => $this->Form->input('Profile.freeseatsinpassengercar', array(
		'label' => __('Freie Plätze im eigenen PKW', true), 'error' => array(
			'correctFormat' => __('Bitte gib hier eine ganze Zahl ein.', true)
		)
	))
));
$this->Js->buffer("$('#ProfileOwnpassengercar').click(function(event) { $(event.target).siblings('.input').css('visibility', (event.target.checked ? 'visible' : 'hidden')); });");
$this->Js->buffer("$('#ProfileFreeseatsinpassengercar').parent().css('visibility', ($('#ProfileOwnpassengercar').prop('checked') ? 'visible' : 'hidden'));");
?>
  </fieldset>
  <fieldset class="equipment">
    <legend><?php __('Ausrüstung'); ?></legend>
<?php
echo $this->Form->input('Profile.ownsinglerope', array(
	'label' => __('Eigenes Einfachseil vorhanden', true), 'after' => $this->Form->input('Profile.lengthsinglerope', array(
		'label' => __('Länge in Meter', true), 'error' => array(
			'correctFormat' => __('Bitte gib hier die Länge in Meter ein. Beispiel: 40', true)
		)
	))
));
$this->Js->buffer("$('#ProfileOwnsinglerope').click(function(event) { $(event.target).siblings('.input').css('visibility', (event.target.checked ? 'visible' : 'hidden')); });");
$this->Js->buffer("$('#ProfileLengthsinglerope').parent().css('visibility', ($('#ProfileOwnsinglerope').prop('checked') ? 'visible' : 'hidden'));");
echo $this->Form->input('Profile.ownhalfrope', array(
	'label' => __('Eigenes Halbseilpaar vorhanden', true), 'after' => $this->Form->input('Profile.lengthhalfrope', array(
		'label' => __('Länge in Meter', true), 'error' => array(
			'correctFormat' => __('Bitte gib hier die Länge in Meter ein. Beispiel: 60', true)
		)
	))
));
$this->Js->buffer("$('#ProfileOwnhalfrope').click(function(event) { $(event.target).siblings('.input').css('visibility', (event.target.checked ? 'visible' : 'hidden')); });");
$this->Js->buffer("$('#ProfileLengthhalfrope').parent().css('visibility', ($('#ProfileOwnhalfrope').prop('checked') ? 'visible' : 'hidden'));");
echo $this->Form->input('Profile.owntent', array('label' => __('Eigenes Zelt vorhanden', true)));
echo $this->Html->para('', __('Im folgenden Feld kannst du ggf. weitere Ausrüstung angeben, die du mitbringen kannst (Expressen, etc.).', true));
echo $this->Form->input('Profile.additionalequipment', array('label' => __('Zus. Ausrüstung', true)));

?>
  </fieldset>
  <fieldset class="additionalinformation">
    <legend><?php __('Weitere Angaben'); ?></legend>
<?php
echo $this->Widget->dateTime('Profile.birthdate', array(
	'label' => __('Geburtstag', true), 'datepicker' => array(
		'changeMonth' => true, 'changeYear' => true, 'minDate' => "'-90y'", 'maxDate' => "'-3y'", 'yearRange' => "'-90:-3'"
	)
));
echo $this->Form->input('Profile.sex', array(
	'label' => __('Geschlecht', true), 'empty' => __('Keine Angabe', true),
	'options' => $this->Display->getSexOptions()
));
?>
  </fieldset>
  <fieldset class="healthinformation">
    <legend><?php __('Gesundheitliche Hinweise'); ?></legend>
<?php
echo $this->Html->para('', __('Bitte gib im folgenden Feld Informationen zu deiner Gesundheit an, die wichtig für den Tourenleiter sind (Medikamente, etc.)', true));
echo $this->Form->input('Profile.healthinformation', array('label' => __('Gesundheitliche Hinweise', true)));
?>
  </fieldset>
</div>
<?php
echo $this->Form->end(__('Speichern', true));