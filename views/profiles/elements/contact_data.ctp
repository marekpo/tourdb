<div class="profiles">
  <fieldset>
    <legend><?php __('Kontaktdaten'); ?></legend>
<?php
echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('Profile.firstname', array(
			'label' => __('Vorname', true), 'tabindex' => 1, 'error' => array(
				'notEmpty' => __('Trag bitte deinen Vornamen ein.', true),
				'correctFormat' => __('Der Vorname darf nur Buchstaben, Punkte, Bindestriche und Leerzeichen enthalten.', true)
			)
		))
		. $this->Form->input('Profile.street', array(
			'label' => __('Strasse', true), 'tabindex' => 3, 'error' => array(
				'notEmpty' => __('Trag bitte die Strasse ein.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('Profile.lastname', array(
			'label' => __('Nachname', true), 'tabindex' => 2, 'error' => array(
				'notEmpty' => __('Trag bitte deinen Nachnamen ein.', true),
				'correctFormat' => __('Der Nachname darf nur Buchstaben, Bindestriche und Leerzeichen enthalten.', true)
			)
		))
		. $this->Form->input('Profile.housenumber', array(
			'label' => __('Hausnummer', true), 'tabindex' => 4
		))
	)
);

echo $this->Form->input('Profile.extraaddressline', array(
	'label' => __('Adresszusatz', true), 'tabindex' => 5
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('Profile.zip', array(
			'label' => __('Postleitzahl', true), 'tabindex' => 6, 'error' => array(
				'notEmpty' => __('Trag bitte deine Postleitzahl ein.', true),
				'validRange' => __('Die Postleitzahl ist nicht korrekt.', true)
			)
		))
		. $this->Form->input('Profile.country_id', array(
			'label' => __('Land', true), 'empty' => true, 'tabindex' => 8, 'error' => array(
				'notEmpty' => __('Bitte wähle dein Land aus.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('Profile.city', array(
			'label' => __('Stadt', true), 'tabindex' => 7, 'error' => array(
				'notEmpty' => __('Trag bitte deine Stadt ein.', true)
			)
		))
	)
);

echo $this->Html->tag('hr', '');

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('Profile.phoneprivate', array(
			'label' => __('Telefon privat', true), 'tabindex' => 8, 'error' => array(
				'notEmpty' => __('Trag bitte deine Telefonnummer ein.', true),
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
		. $this->Form->input('Profile.cellphone', array(
			'label' => __('Mobil Nr.', true), 'tabindex' => 10, 'error' => array(
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('Profile.phonebusiness', array(
			'label' => __('Telefon gesch.', true), 'tabindex' => 9, 'error' => array(
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
	)
);
?>
  </fieldset>

  <fieldset>
    <legend><?php __('Notfallkontaktdaten'); ?></legend>
<?php
echo $this->Form->input('Profile.emergencycontact1_address', array(
	'label' => 'Kontakt Person 1', 'tabindex' => 11, 'error' => array(
		'notEmpty' => __('Trag bitte den Namen und die Adresse deiner Notfallkontaktperson ein.', true)
	)
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('Profile.emergencycontact1_phone', array(
			'label' => __('Telefon', true), 'tabindex' => 12, 'error' => array(
				'notEmpty' => __('Trag bitte die Telefon-/Mobilnummer deiner Notfallkontaktperson ein.', true),
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)				
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('Profile.emergencycontact1_email', array(
			'label' => __('E-Mail', true), 'tabindex' => 13, 'error' => array(
				'correctFormat' => __('Dies ist keine gültige E-Mail-Adresse.', true)
			)
		))
	)
);

echo $this->Html->tag('hr', '');

echo $this->Form->input('Profile.emergencycontact2_address', array(
	'label' => __('Kontakt Person 2', true), 'tabindex' => 14
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('Profile.emergencycontact2_phone', array(
			'label' => __('Telefon', true), 'tabindex' => 15, 'error' => array(
				'validPhone' => __('Die Telefonnumer darf nur Pluszeichen (+), Leerzeichen ( ) und Ziffern (0-9) beinhalten.', true)
			)
		))
	)
	. $this->Html->div('half',
		$this->Form->input('Profile.emergencycontact2_email', array(
			'label' => __('E-Mail', true), 'tabindex' => 16, 'error' => array(
				'correctFormat' => __('Dies ist keine gültige E-Mail-Adresse.', true)
			)
		))
	)
);
?>
  </fieldset>
</div>