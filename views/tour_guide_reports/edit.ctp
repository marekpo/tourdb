<?php
$this->set('title_for_layout', __('Tourenrapport', true));
$this->Html->addCrumb($this->data['Tour']['title'], array('action' => 'view', $this->data['Tour']['id']));
$this->Html->addCrumb(__('Tourenrapport', true));

echo $this->Html->para('', sprintf(__('Hier kannst du Tourenrapport für deine Tour "%s" ausfüllen und speichern.', true), $this->data['Tour']['title']));
echo $this->Form->create();
echo $this->Form->hidden('Tour.id');
echo $this->Form->hidden('TourGuideReport.tour_id');
/*echo $this->Form->input('change_status', array('label' => __('Tour wurde', true), 'options' => $reportStatusOptions));*/
echo $this->Form->input('TourGuideReport.description', array('type' => 'textarea', 'label' => __('Beschreibung der Tour', true), 'after' => __('Route, Zeiten, Verhältnisse, Wetter, Besonderes')));
echo $this->Form->input('TourGuideReport.substitute_tour', array('type' => 'text', 'label' => __('Ersatztour', true), 'after' => __('bei Änderung')));
echo $this->Form->input('TourGuideReport.expenses_organsiation', array('type' => 'text', 'label' => __('Spesen Telefon, Porti etc.', true)));
echo $this->Form->input('TourGuideReport.driven_km', array('type' => 'text', 'label' => __('Auto (km)', true)));
echo $this->Form->input('TourGuideReport.expenses_transport', array('type' => 'text', 'label' => __('ÖV (1/2 Tax)', true)));
echo $this->Form->input('TourGuideReport.expenses_accommodation', array('type' => 'text', 'label' => __('Hütte', true)));
echo $this->Form->input('TourGuideReport.expenses_others1', array('type' => 'text', 'label' => __('Sonstiges I', true)));
echo $this->Form->input('TourGuideReport.expenses_others2', array('type' => 'text', 'label' => __('Sonstiges II', true)));
echo $this->Form->input('TourGuideReport.paid_donation', array('type' => 'text', 'label' => __('Spende zu Gunsten Seniorenkasse', true)));
echo $this->Form->end(__('Tourenrapport speichern', true));