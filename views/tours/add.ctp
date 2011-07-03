<?php
$this->set('title_for_layout', __('Neue Tour anlegen', true));
echo $this->Html->tag('h1', __('Neue Tour anlegen', true));

echo $this->element('../tours/elements/tour_form');