<?php

foreach($tours as $tour)
{
	$this->Csv->addRow(array(
		$tour['Tour']['title'], $tour['Tour']['startdate'], $tour['Tour']['enddate']
	));
}

echo $this->Csv->render('touren', 'ISO-8859-15');