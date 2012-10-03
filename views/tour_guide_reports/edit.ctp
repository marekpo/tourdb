<?php
$this->set('title_for_layout', __('Tourenrapport', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Tourenrapport', true));

echo $this->Html->para('', sprintf(__('Hier kannst du Tourenrapport für deine Tour "%s" ausfüllen und speichern.', true), $tour['Tour']['title']));
echo $this->Form->create('TourGuideReport', array('url' => array($tour['Tour']['id'])));
?>

<div class="tourguidereports">
<?php 
echo $this->Form->input('Tour.tour_status_id', array(
	'type' => 'radio',
	'tabindex' => 1,
	'legend' => 'Wurde die Tour durchgeführt?',
	'default' => $reportStatusDefault
));
?>
  <fieldset class="description">
   <legend><?php __('Beschreibung der Tour (Route, Zeiten, Verhältnisse, Wetter, Besonderes)'); ?></legend>
<?php
echo $this->Form->input('TourGuideReport.description', array(
	'tabindex' => 2,
	'label' => __('Beschreibung der Tour', true),
	'error' => array('notEmpty' => __('Trag bitte die Beschreibung ein.', true))
));

?>

</fieldset>
  <fieldset class="substitutetour">
    <legend><?php __('Bei Änderung, Bezeichnung der Ersatztour'); ?></legend>
<?php
echo $this->Form->input('TourGuideReport.substitute_tour', array('type' => 'text', 'tabindex' => 3, 'label' => __('Ersatztour inkl. Tourencode', true)));
?>
  </fieldset>

  <fieldset class="expenses">
    <legend><?php __('Spesen'); ?></legend>
<?php
$decnumText = __('Spesen müssen als Dezimalzahlen eingegeben werden. (z.B. 68.00 oder 70.50)', true);
echo $this->Form->input('TourGuideReport.expenses_organsiation', array(
	'type' => 'text',
	'tabindex' => 4,
	'label' => __('Spesen Telefon, Porti etc.', true),
	'error' => array('decnum' => $decnumText) 
));

echo $this->Form->input('TourGuideReport.driven_km', array(
	'type' => 'text',
	'tabindex' => 5,
	'label' => __('Auto (km)', true),
	'error' => array('km' => __('Kilometer müssen als ganze Zahlen eingegeben werden. (z.B. 128, max. 9999)', true))
));

echo $this->Form->input('TourGuideReport.expenses_transport', array(
	'type' => 'text',
	'tabindex' => 6,
	'label' => __('ÖV (1/2 Tax)', true),
	'error' => array('decnum' => $decnumText)
));

echo $this->Form->input('TourGuideReport.expenses_accommodation', array(
	'type' => 'text',
	'tabindex' => 7,
	'label' => __('Übernachtung inkl. HP', true),
	'error' => array('decnum' => $decnumText)
));

echo $this->Html->div('columncontainer',
	$this->Html->div('half',
		$this->Form->input('TourGuideReport.expenses_others1', array(
		    'type' => 'text',
			'label' => __('Sonstiges1', true),
		    'tabindex' => 8,
		    'error' => array('decnum' => $decnumText)
		))
		. $this->Form->input('TourGuideReport.expenses_others2', array(
			'type' => 'text',
			'label' => __('Sonstiges2', true),
			'tabindex' => 10,
			'error' => array('decnum' => $decnumText)
		))
		. $this->Form->input('TourGuideReport.paid_donation', array(
					'type' => 'text',
					'label' => __('Spende zu Gunsten Seniorenkasse', true),
					'tabindex' => 12
			))
		)		
		. $this->Html->div('half',
			$this->Form->input('TourGuideReport.expenses_others1_text', array(
			    'type' => 'text',
				'label' => __('Begründung zu Sonstiges1 (z.B. Bergführer Honorar)', true),
			    'tabindex' => 9
		))
		. $this->Form->input('TourGuideReport.expenses_others2_text', array(
				'type' => 'text',
				'label' => __('Begründung zu Sonstiges2', true),
				'tabindex' => 11
		))
		)			
);
?>
  </fieldset>
</div>
<?php
echo $this->Form->end(__('Tourenrapport speichern', true));