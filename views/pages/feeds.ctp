<?php
$this->set('title_for_layout', __('RSS Feeds', true));
$this->Html->addCrumb(__('RSS Feeds', true));

echo $this->Html->para('', __('Auf dieser Seite findest du alle RSS Feeds, die zur Verfügung stehen.', true));

echo $this->Html->link(__('Aktuelle Touren', true), '/tours/search.rss');
echo $this->Html->para('', __('Listet bis zu 25 zukünftige Touren auf.', true));

echo $this->Html->link(__('Aktuelle Anlässe', true), array('controller' => 'appointments', 'action' => 'upcomingAppointments', 'ext' => 'rss'));
echo $this->Html->para('', __('Zeigt alle zukünftigen Anlässe der SAC Sektion Baldern.', true));
