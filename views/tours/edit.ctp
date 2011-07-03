<?php
$this->set('title_for_layout', __('Tour bearbeiten', true));
echo $this->Html->tag('h1', __('Tour bearbeiten', true));

echo $this->element('../tours/elements/tour_form');