<?php

$sektionName = "SEKTION AM ALBIS";
$fontSizeHeader = 18;

$labelColumn1 = 0;
$labelColumn2 = 2; /*2 ist Absturz*/

$startColumn = 0;
$endColumn = 9;

$this->Excel->startNewDocument(true);
$this->Excel->setFilename('statistik_touren_uebersicht');

/* Tourenrapport */
$rowOffset = 2;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('TOURENÜBERSICHT', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeHeader, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($startColumn + 2)));

/*Sektionsname*/
$rowOffset = 3;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __($sektionName, true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeHeader, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($startColumn + 2)));

/*Logo*/
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('SAC Logo');
$objDrawing->setPath('./img/sac_logo.png');
$objDrawing->setResizeProportional(false);
$objDrawing->setHeight(59);
$objDrawing->setCoordinates('D1');
$objDrawing->setWorksheet($this->Excel->getActiveSheet());

/* row header */
$rowOffset = 5;
$cell = 0;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Datum', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tag', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(8);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Gruppe', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(15);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tour', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(40);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Tourencode', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(15);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('TourenleiterIn', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(20);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Status', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(20);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Mitgl.', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Gäste', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('TT', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
		'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('argb' => 'ffdddddd'))
));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
		'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

/* list rows */
$rowOffset = 6;
$index = 0;
foreach($tours as $tour)
{
	$cell = 0;
	$startTime = strtotime($tour['Tour']['startdate']);
	$endTime = strtotime($tour['Tour']['enddate']);
	$dateColumn = $this->Time->format($startTime, '%#d.') . $this->Time->format($startTime, '%#m.') . $this->Time->format($startTime, '%#Y');
	$dayColumn = $this->Time->format($startTime, '%a');
	$duration = ($endTime - $startTime);
	$participantsDays = (($duration / 86400) + 1) * ($tour['Tour']['members'] + $tour['Tour']['others']);
	if($duration > 0)
	{
		$dayColumn = sprintf('%s-%s', $dayColumn, $this->Time->format($endTime, '%a'));
	}
	
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $dateColumn);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $dayColumn);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGroup']['tourgroupname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['title']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->TourDisplay->getClassification($tour, array('span' => false)));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->TourDisplay->getTourGuide($tour));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourStatus']['statusname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['members']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['others']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $participantsDays);
	$index++;
}

/*drei Spalten zentrieren*/
$this->Excel->getActiveSheet()->getStyle(sprintf('H%1$d:J%2$d', $rowOffset -1, $rowOffset + $index - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

/*Seite für Druck vorbereiten*/
$this->Excel->getActiveSheet()->getPageMargins()->setTop(0.195); /*Inches*/
$this->Excel->getActiveSheet()->getPageMargins()->setBottom(0.195); /*Inches*/
$this->Excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&D&R&P/&N'); /*Datum links, Seitenzahl rechts*/
$this->Excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&D&R&P/&N');
$this->Excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

$this->Excel->outputDocument();