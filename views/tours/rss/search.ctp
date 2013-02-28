<?php
$this->set('channel', array(
	'title' => __('Aktuelle Touren', true),
	'link' => $this->Html->url(array('controller' => 'tours', 'action' => 'tours', 'ext' => 'rss'), true),
	'description' => __('Alle aktuellen Touren des SAC Am Albis', true)
));

foreach($tours as $tour)
{
	$itemTitle = $tour['Tour']['title'];
	$itemTitle .= ($tour['Tour']['tourweek'] == 1 ? sprintf(' %s', __('TW',true)) : '');
	$itemTitle .= ($tour['Tour']['withmountainguide'] == 1 ? sprintf(' %s', __('BGF',true)) : '');
	$itemTitle = sprintf('%s (%s) %s', $itemTitle, $this->TourDisplay->getClassification($tour, array('span' => false)), $this->TourDisplay->getTourGuide($tour));

	echo $this->Rss->item(array(), array(
		'title' => $itemTitle,
		'link' => $this->Html->url(array('controller' => 'tours', 'action' => 'view', $tour['Tour']['id']), true),
		'guid' => $tour['Tour']['id'],
		'description' => sprintf('%s [%s] %s',
				$this->Display->getDateRangeText($tour['Tour']['startdate'], $tour['Tour']['enddate'], true),
				$this->Display->getDayOfWeekText($tour['Tour']['startdate'], $tour['Tour']['enddate']),
				$tour['Tour']['description']),
		'author' => $this->TourDisplay->getTourGuide($tour),
		'pubDate' => $this->Time->format('d.m.Y H:i:s', $tour['Tour']['startdate']),
	));
}
