<?php
$this->set('title_for_layout', __('Tourenrapport', true));
$this->Html->addCrumb($tour['Tour']['title'], array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']));
$this->Html->addCrumb(__('Tourenrapport', true));

echo $this->Html->para('', sprintf(__('Hier kannst du Tourenrapport für deine Tour "%s" ausfüllen und speichern.', true), $tour['Tour']['title']));
echo $this->Form->create('TourGuideReport', array('url' => array($tour['Tour']['id'])));
?>

<div class="tourguidereports">
  <fieldset class="tourstatus">
<?php 
echo $this->Form->input('Tour.tour_status_id', array(
	'type' => 'radio',
	'legend' => 'Wurde die Tour durchgeführt?',
	'default' => $reportStatusDefault
));
?>
  </fieldset>
  <fieldset class="description">
   <legend><?php __('Beschreibung der Tour (Route, Zeiten, Verhältnisse, Wetter, Besonderes)'); ?></legend>
<?php
echo $this->Form->input('TourGuideReport.description', array(
		'label' => __('Beschreibung der Tour', true),
		'error' => array('notEmpty' => __('Trag bitte die Beschreibung ein.', true))
		));

?>

</fieldset>
  <fieldset class="substitutetour">
    <legend><?php __('Bei Änderung, Bezeichnung der Ersatztour'); ?></legend>
<?php
echo $this->Form->input('TourGuideReport.substitute_tour', array('type' => 'text', 'label' => __('Ersatztour', true)));
?>
  </fieldset>

  <fieldset class="expenses">
    <legend><?php __('Spesen'); ?></legend>
<?php
$decnumText = __('Spesen müssen als Dezimalzahlen eingegeben werden. (z.B. 68.00 oder 70.50)', true);
echo $this->Form->input('TourGuideReport.expenses_organsiation', array(
		'type' => 'text',
		'label' => __('Spesen Telefon, Porti etc.', true),
		'error' => array('decnum' => $decnumText) 
		));

echo $this->Form->input('TourGuideReport.driven_km', array(
		'type' => 'text',
		'label' => __('Auto (km)', true),
		'error' => array('km' => __('Kilometer müssen als ganze Zahlen eingegeben werden. (z.B. 128, max. 9999)', true))
		));

echo $this->Form->input('TourGuideReport.expenses_transport', array('type' => 'text',
		 'label' => __('ÖV (1/2 Tax)', true),
		'error' => array('decnum' => $decnumText)
		));

echo $this->Form->input('TourGuideReport.expenses_accommodation', array('type' => 'text',
		'label' => __('Hütte', true),
		'error' => array('decnum' => $decnumText)
		));

echo $this->Form->input('TourGuideReport.expenses_others1', array('type' => 'text',
		'label' => __('Bergführer', true),
		'error' => array('decnum' => $decnumText)
		));

echo $this->Form->input('TourGuideReport.expenses_others2', array('type' => 'text',
		'label' => __('Sonstiges', true),
		'error' => array('decnum' => $decnumText)
		));

echo $this->Form->input('TourGuideReport.paid_donation', array('type' => 'text',
		'label' => __('Spende zu Gunsten Seniorenkasse', true),
		'error' => array('decnum' => $decnumText)
		));
?>
  </fieldset>
</div>
<?php
echo $this->Form->end(__('Tourenrapport speichern', true));