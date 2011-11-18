<div class="profiles">
  <fieldset class="experience">
    <legend><?php __('Erfahrung'); ?></legend>
<?php
	echo $this->Html->div('input radio',
		$this->Form->label('Profile.experience_rope_guide', __('Einsetzbar als Seilschaftsführer', true))
		. $this->Form->input('Profile.experience_rope_guide', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => array(
				1 => 'Ja', 2 => 'Nein', 0 => 'Weiss nicht'
			)
		))
	);
	echo $this->Html->div('input radio',
		$this->Form->label('Profile.experience_knot_technique', __('Kenntnisse in Knotentechnik', true))
		. $this->Form->input('Profile.experience_knot_technique', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => array(
				'Keine', 'Wenig', 'Mittel', 'Viel'
			)
		))
	);
	echo $this->Html->div('input radio',
		$this->Form->label('Profile.experience_rope_handling', __('Kenntnisse in Seilhandhabung', true))
		. $this->Form->input('Profile.experience_rope_handling', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => array(
				'Keine', 'Wenig', 'Mittel', 'Viel'
			)
		))
	);
	echo $this->Html->div('input radio',
		$this->Form->label('Profile.experience_avalanche_training', __('Lawinenausbildung', true))
		. $this->Form->input('Profile.experience_avalanche_training', array(
			'type' => 'radio', 'div' => false, 'legend' => false, 'options' => array(
				'Keine', 'Wenig', 'Mittel', 'Viel'
			)
		))
	);
	echo $this->Form->input('Profile.lead_climb_niveau_id', array(
		'label' => __('Kletterniveau im Vorstieg', true), 'options' => $climbingDifficulties, 'empty' => '', 'error' => array(
			'notEmpty' => __('Gib bitte dein Kletterniveau im Vorstieg an.', true)
		)
	));
	echo $this->Form->input('Profile.second_climb_niveau_id', array(
		'label' => __('Kletterniveau im Nachstieg', true), 'options' => $climbingDifficulties, 'empty' => '', 'error' => array(
			'notEmpty' => __('Gib bitte dein Kletterniveau im Nachstieg an.', true)
		)
	));
	echo $this->Form->input('Profile.alpine_tour_niveau_id', array(
		'label' => __('Alpin-/Hochtourenniveau', true), 'options' => $skiAndAlpineTourDifficulties, 'empty' => '', 'error' => array(
			'notEmpty' => __('Gib bitte dein Niveau bei Alpin-/Hochtouren an.', true)
		)
	));
	echo $this->Form->input('Profile.ski_tour_niveau_id', array(
		'label' => __('Skitourenniveau', true), 'options' => $skiAndAlpineTourDifficulties, 'empty' => '', 'error' => array(
			'notEmpty' => __('Gib bitte dein Niveau bei Skitouren an.', true)
		)
	));
?>
  </fieldset>
</div>