<?php
$this->set('title_for_layout', __('Tourensuche', true));
$this->Html->addCrumb(__('Tourensuche', true));

$urlSearchParameters = $this->params['url'];
unset($urlSearchParameters['url']);
$this->Paginator->options(array('url' => array('?' => $urlSearchParameters)));

echo $this->Form->create(false, array('type' => 'GET', 'url' => $this->passedArgs));

echo $this->Form->input('Tour.query', array('label' => __('Text', true)));

echo $this->Widget->dateTime('Tour.startdate', array('label' => __('Datum von', true)));
echo $this->Widget->dateTime('Tour.enddate', array('label' => __('bis', true)));

echo $this->Html->div('input select',
	$this->Form->label(__('Tourentypen', true))
	. $this->Form->input('Tour.TourType', array(
		'label' => false, 'div' => false, 'multiple' => 'checkbox',
		'after' => $this->Html->div('', '', array('style' => 'clear: left')),
	)),
	array('id' => 'tourtypes')
);

echo $this->Form->input('Tour.ConditionalRequisite', array(
	'label' => __('Anforderungen', true), 'multiple' => 'checkbox',
	'after' => $this->Html->div('', '', array('style' => 'clear: left'))
));

echo $this->Html->div('input select',
	$this->Form->label(__('Schwierigkeit', true))
	. $this->Html->div('difficulty-select checkbox-container',
		$this->Html->div('diff-s diff-h',
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSkiAndAlpineTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left'))
			))
		)
		. $this->Html->div('diff-h', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesAlpineTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left'))
			))
		))
		. $this->Html->div('diff-w', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesHike,
				'after' => $this->Html->div('', '', array('style' => 'clear: left'))
			))
		))
		. $this->Html->div('diff-ss', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesSnowshowTour,
				'after' => $this->Html->div('', '', array('style' => 'clear: left'))
			))
		))
		. $this->Html->div('diff-ks', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesViaFerrata,
				'after' => $this->Html->div('', '', array('style' => 'clear: left'))
			))
		))
		. $this->Html->div('diff-k diff-p', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesRockClimbing,
				'after' => $this->Html->div('', '', array('style' => 'clear: left'))
			))
		))
		. $this->Html->div('diff-e', $this->Widget->stripHidden(
			$this->Form->input('Tour.Difficulty', array(
				'label' => false, 'multiple' => 'checkbox', 'options' => $difficultiesIceClimbing,
				'after' =>  $this->Html->div('', '', array('style' => 'clear: left'))
			))
		))
	)
	. $this->Html->div('', '', array('style' => 'clear: left'))
);
$this->Js->buffer(sprintf("$('#tourtypes input[type=checkbox]').click(TourDB.Tours.Form.switchDifficulty); TourDB.Tours.Form.switchDifficulty();"));

echo $this->Form->end(__('Suchen', true));

$tableHeaders = array(
	$this->Paginator->sort(__('Status', true), 'TourStatus.statusname'),
	$this->Paginator->sort(__('Tourbezeichnung', true), 'title'),
	$this->Paginator->sort(__('Datum von', true), 'startdate'),
	$this->Paginator->sort(__('Datum bis', true), 'enddate'),
	__('Code', true),
	$this->Paginator->sort(__('Tourenleiter', true), 'TourGuide.username')
);

$tableRows = array();

foreach($tours as $tour)
{
	$tableRows[] = array(
		$tour['TourStatus']['statusname'],
		$this->Html->link($this->Text->truncate($tour['Tour']['title'], 40), array(
			'action' => 'view', $tour['Tour']['id']
		)),
		$this->Time->format('d.m.Y', $tour['Tour']['startdate']),
		$this->Time->format('d.m.Y', $tour['Tour']['enddate']),
		$this->TourDisplay->getClassification($tour),
		$this->TourDisplay->getTourGuide($tour)
	);
}

echo $this->Html->tag('table', $this->Html->tableHeaders($tableHeaders) . $this->Html->tableCells($tableRows), array('class' => 'list'));

echo $this->element('paginator');