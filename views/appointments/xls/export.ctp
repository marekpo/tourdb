<?php

$startColumn = 0;
$endColumn = 6;

$this->Excel->startNewDocument(true);
$this->Excel->setFilename('anlaesse');

/* row header */
$rowOffset = 1;
$cell = 0;
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(10);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Datum', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(8);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tag', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(20);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Beschreibung', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(80);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Detailbeschreibung', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(30);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Ort', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(8);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Start', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell))->setWidth(8);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Ende', true));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
	'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('argb' => 'ffdddddd'))
));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

/* list rows */
$rowOffset = 2;
$index = 0;
foreach($appointments as $appointment)
{
	$cell = 0;

	$startTime = strtotime($appointment['Appointment']['startdate']);
	$endTime = strtotime($appointment['Appointment']['enddate']);

	$startDate = $this->Time->format($startTime, '%#d.') . $this->Time->format($startTime, '%#m.');
	$endDate = $this->Time->format($endTime, '%#d.') . $this->Time->format($endTime, '%#m.');

	$startDay = $this->Time->format($startTime, '%a');
	$endDay = $this->Time->format($endTime, '%a');

	$dateColumn = ($startDate == $endDate) ? $startDate : sprintf('%s-%s', $startDate, $endDate);
	$dayColumn = ($startDate == $endDate) ? $startDay: sprintf('%s-%s', $startDay, $endDay);

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $dateColumn);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $dayColumn);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $appointment['Appointment']['title']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $appointment['Appointment']['description']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $appointment['Appointment']['location']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Time->format('H:i', $appointment['Appointment']['startdate']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Time->format('H:i', $appointment['Appointment']['enddate']));

	$index++;
}

$this->Excel->outputDocument();