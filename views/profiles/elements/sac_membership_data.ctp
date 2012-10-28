<div class="profiles">
  <fieldset class="sacmembership">
    <legend><?php __('SAC Mitgliedschaft'); ?></legend>
<?php
echo $this->Form->input('Profile.sac_member', array(
	'label' => __('SAC Mitglied', true), 'options' => $this->Display->getSacMemberOptions(),
	'empty' => __('Bitte wählen', true), 'error' => array(
		'notEmpty' => __('Bitte wähle eine Möglichkeit aus.', true)
	)
));


echo $this->Html->div('',
	$this->Form->input('Profile.sac_membership_number', array('label' => __('Mitgliedernummer', true)))
	. $this->Form->input('Profile.sac_main_section_id', array('label' => __('Hauptsektion', true), 'options' => $sacSections, 'empty' => ''))
	. $this->Form->input('Profile.sac_additional_section1_id', array('label' => __('Zweitsektion', true), 'options' => $sacSections, 'empty' => ''))
	. $this->Form->input('Profile.sac_additional_section2_id', array('label' => __('Drittsektion', true), 'options' => $sacSections, 'empty' => ''))
	. $this->Form->input('Profile.sac_additional_section3_id', array('label' => __('Viertsektion', true), 'options' => $sacSections, 'empty' => '')),
	array('id' => 'sacmembershipfields')
);

$this->Js->buffer("$('#ProfileSacMember').change(function(event) { if($(event.target).val() == 1) { $('#sacmembershipfields').show(); } else { $('#sacmembershipfields').hide(); } });");
$this->Js->buffer("if($('#ProfileSacMember').val() == 1) { $('#sacmembershipfields').show(); } else { $('#sacmembershipfields').hide(); }");
?>
  </fieldset>
</div>