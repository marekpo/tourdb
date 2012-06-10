<?php

$startColumn = 0;
$endColumn = 9;

$this->Excel->startNewDocument(true);

$this->Excel->setFilename('touren');



$rowOffset = 1;
$cell = 0;

/* row header */
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Datum', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tag', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(8);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Beschreibung', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(20);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Detailbeschreibung', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(80);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('TW', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(4);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Mit Bergführer', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(15);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tourencode', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(15);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tourenleiter(-in)', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(20);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Anmeldeschluss', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(15);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefonnummer', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(20);
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('argb' => 'ffdddddd'))
));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
		'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

/* list rows */
$rowOffset = 2;
$index = 0;
foreach($tours as $tour)
{
	$cell = 0;

	$startTime = strtotime($tour['Tour']['startdate']);
	$endTime = strtotime($tour['Tour']['enddate']);
	
	$dateColumn = $this->Time->format($startTime, '%#d.') . $this->Time->format($startTime, '%#m.');
	
	$dayColumn = $this->Time->format($startTime, '%a');
	$duration = $endTime - $startTime;
	
	if($duration > 0)
	{
		$dateColumn = sprintf('%s-%s', $dateColumn, $this->Time->format($endTime, '%#d.') . $this->Time->format($endTime, '%#m.'));
		$dayColumn = sprintf('%s-%s', $dayColumn, $this->Time->format($endTime, '%a'));
	}	
	
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $dateColumn);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $dayColumn);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['title']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['description']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($tour['Tour']['tourweek'] == true ? 'TW' : ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($tour['Tour']['withmountainguide'] == true ? 'Ja' : ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->TourDisplay->getClassification($tour, array('span' => false)));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->TourDisplay->getTourGuide($tour));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Time->format($format = 'd.m.Y', $tour['Tour']['deadline'] ));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayUsersPhoneContact($tour['TourGuide']['Profile']));
	
	$index++;
}

$this->Excel->outputDocument();