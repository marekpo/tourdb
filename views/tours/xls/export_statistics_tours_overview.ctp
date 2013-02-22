<?php

$sektionName = "SEKTION AM ALBIS";
$fontSizeHeader = 18;

$labelColumn = 0;

$startColumn = 0;
$endColumn = 10;

if($exportExpenses)
{
	$endColumn += 8;
}

$this->Excel->startNewDocument(true);
$this->Excel->setFilename('statistik_touren_uebersicht');

/* Tourenrapport */
$rowOffset = 2;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn, $rowOffset, __('TOURENÜBERSICHT', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeHeader, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($startColumn + 2)));

/*Sektionsname*/
$rowOffset = 3;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn, $rowOffset, __($sektionName, true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeHeader, 'bold' => true)));
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
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Anz. Nächte', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(12);

if($exportExpenses)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Spesen Telefon, Porti etc.', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(25);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('ÖV (1/2 Tax)', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(12);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Übernachtung inkl. HP', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(20);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Auto (km)', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Sonstiges1', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Begründung zu Sonstiges1', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(25);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Sonstiges2', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(10);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Begründung zu Sonstiges2', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(25);
}

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

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->getDateRangeText($tour['Tour']['startdate'], $tour['Tour']['enddate'], true, true));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->getDayOfWeekText($tour['Tour']['startdate'], $tour['Tour']['enddate']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGroup']['tourgroupname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['title']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->TourDisplay->getClassification($tour, array('span' => false)));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->TourDisplay->getTourGuide($tour));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourStatus']['statusname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['members']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['others']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['participantDays']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['Tour']['nights']);

	if($exportExpenses)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_organsiation']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_transport']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_accommodation']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['driven_km']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_others1']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_others1_text']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_others2']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tour['TourGuideReport']['expenses_others2_text']);
	}

	$index++;
}

/*vier Spalten zentrieren*/
$this->Excel->getActiveSheet()->getStyle(sprintf('H%1$d:K%2$d', $rowOffset -1, $rowOffset + $index - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

/*Seite für Druck vorbereiten*/
$this->Excel->getActiveSheet()->getPageMargins()->setTop(0.195); /*Inches*/
$this->Excel->getActiveSheet()->getPageMargins()->setBottom(0.195); /*Inches*/
$this->Excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&D&R&P/&N'); /*Datum links, Seitenzahl rechts*/
$this->Excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&D&R&P/&N');
if($exportExpenses)	{
	$this->Excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
}
$this->Excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

$this->Excel->outputDocument();