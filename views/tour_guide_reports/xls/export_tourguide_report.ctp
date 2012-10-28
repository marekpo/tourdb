<?php
$sektionName = "SEKTION AM ALBIS";
$fontSizeHeader = 18;
$fontSizeNormal = 11;

$labelColumn1 = 0;
$labelColumn2 = 2; /*2 ist Absturz*/
$labelColumn3 = 4;

$startColumn = 0;
$endColumn = 6;

$kmCosts = ".2";

$countMembers = 1; /*Tourenleiter ist immer als Mitglied*/
$countOthers = 0;

foreach($tourParticipations as $tourParticipation)
{
	if($tourParticipation['User']['Profile']['sac_member'] == 1)
	{
		$countMembers++;
	}
	else
	{
		$countOthers++;
	}
}

$this->Excel->startNewDocument(true);

$this->Excel->setFilename(sprintf('%d_%s_Rapport', $this->Time->format($tour['Tour']['startdate'], '%Y'), $tour['Tour']['title']));

/* Tourenrapport */
$rowOffset = 2;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('TOURENRAPPORT', true));
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

/*Tour und Ersatztour*/
if(empty($tour['TourGuideReport']['substitute_tour']))
{
	$madeTour = $tour['Tour']['title'];
	$planedTour = "";
}
else
{
	$madeTour = $tour['TourGuideReport']['substitute_tour'];
	$planedTour = $tour['Tour']['title'];
}
$madeTour .=  ' ' . $this->TourDisplay->getClassification($tour, array('span' => false));

 /*durchgeführt*/
 $rowOffset = 5;
 $this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Durchgeführe Tour:', true));
 $this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => false)));
 $this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, $madeTour);
 $this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn2, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeHeader, 'bold' => true)));
 $this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($labelColumn2), PHPExcel_Cell::stringFromColumnIndex($endColumn)));

 /*geplant*/
 $rowOffset = 7;
 if(!empty($tour['TourGuideReport']['substitute_tour']))
 {
	 $this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Ursprünflich geplant:', true));
	 $this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => false)));
	 $this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, $planedTour);
	 $this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn2, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));
 }
 $this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
 	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
 ));

/*Touren Details*/
$rowOffset = 9;
/*Datum*/
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Ausgeführt am:', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => false)));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, sprintf('%s-%s [%s - %s]',
	$this->Time->format($tour['Tour']['startdate'], '%d.%m.%Y'), $this->Time->format($tour['Tour']['enddate'], '%d.%m.%Y'),
	$this->Time->format($tour['Tour']['startdate'], '%a'), $this->Time->format($tour['Tour']['enddate'], '%a')
));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn2, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));

/*Sektion/Jugend/Senioren*/
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn3, $rowOffset, __($tour['TourGroup']['tourgroupname'], true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn3, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));

/*TourenleiterIn*/
$rowOffset = 10;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('TourenleiterIn:', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => false)));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, $this->TourDisplay->getTourGuide($tour));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn2, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

/*Teilnehmende*/
$rowOffset = 12;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Teilnehmende:', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => false)));

/*Anzahl SAC Mitglieder*/
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, __('a) Mitglieder (inkl. Leiter)', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn3, $rowOffset, $countMembers);

/*Anzahl Gäste*/
$rowOffset = 13;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, __('b) Gäste', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn3, $rowOffset, $countOthers);

$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($labelColumn2), PHPExcel_Cell::stringFromColumnIndex($labelColumn3), $rowOffset))->applyFromArray(array(
	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

$rowOffset = 14;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset, __('Total', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn2, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));

/*Zusammen*/
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn3, $rowOffset, $countMembers + $countOthers);
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn3, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));

/*Beschreibung*/
$rowOffset = 16;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Beschreibung der Tour (Route, Zeiten, Verhältnisse, Wetter, Besonderes)', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
 	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

$rowOffset = 17;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, $tour['TourGuideReport']['description']);
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array(
	'font' => array('size' => $fontSizeNormal, 'bold' => false),
	'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP)
));

$this->Excel->getActiveSheet()->mergeCells(sprintf('%1s%3$d:%2$s%4$d', PHPExcel_Cell::stringFromColumnIndex($labelColumn1), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset, $rowOffset + 9 ));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%4$d', PHPExcel_Cell::stringFromColumnIndex($labelColumn1), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset, $rowOffset + 9 ))
->getAlignment()->setWrapText(true);

/*Teilnehmerliste*/
$rowOffset = 28;
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Teilnehmerliste (ohne TL)', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array(
	'font' => array('size' => $fontSizeNormal, 'bold' => true)
));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

/* list colum headers */
$rowOffset = 29;
$cell = $labelColumn1;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Nr.', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(9.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Name', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Vorname', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Adresse', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(26.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('PLZ', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Ort', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(17.75);
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
	'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('argb' => 'ffdddddd'))
));

/* list */
$rowOffset = 30;
$index = 0;

foreach($tourParticipations as $tourParticipation)
{
	$cell = $labelColumn1;

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($index + 1));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['lastname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['firstname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, sprintf('%s %s', $tourParticipation['User']['Profile']['street'], $tourParticipation['User']['Profile']['housenumber']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['zip']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['city']);

	$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset + $index, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	$index++;
}

$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%4$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset - 1, $rowOffset + $index - 1 ))->applyFromArray(array(
	'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
));

/*Spesen*/
$rowOffset = $rowOffset + $index + 2;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset, __('Spesen', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($startColumn), PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset))->applyFromArray(array(
	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 1, __('Telefon, Porti etc.:', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 1, $tour['TourGuideReport']['expenses_organsiation']);

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 2, __('Auto (km):', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1 + 1, $rowOffset + 2, $tour['TourGuideReport']['driven_km']);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 2, sprintf('=%3$s%1$d * %2$s', $rowOffset + 2 , $kmCosts, PHPExcel_Cell::stringFromColumnIndex($labelColumn1 + 1)));

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 3, __('ÖV (1/2 Tax):', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 3 , $tour['TourGuideReport']['expenses_transport']);

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 4, __('Hütte:', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 4 , $tour['TourGuideReport']['expenses_accommodation']);

if(!empty($tour['TourGuideReport']['expenses_others1_text'])) {
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 5, $tour['TourGuideReport']['expenses_others1_text'] . ':');
}
else
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 5, __('Sonstiges 1:', true));
}
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 5 , $tour['TourGuideReport']['expenses_others1']);
if(!empty($tour['TourGuideReport']['expenses_others2_text'])) {
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 6, $tour['TourGuideReport']['expenses_others2_text'] . ':');
}
else
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 6, __('Sonstiges 2:', true));
}
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%3$d:%2$s%3$d', PHPExcel_Cell::stringFromColumnIndex($labelColumn1), PHPExcel_Cell::stringFromColumnIndex($labelColumn2), $rowOffset + 6))->applyFromArray(array(
	'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM))
));

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 6 , $tour['TourGuideReport']['expenses_others2']);

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 7, __('Total:', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn1, $rowOffset + 7 )->applyFromArray(array(
	'font' => array('size' => $fontSizeNormal, 'bold' => true)
));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 7, sprintf('=SUM(%3$s%1$d:%3$s%2$d)', $rowOffset + 1 , $rowOffset + 6, PHPExcel_Cell::stringFromColumnIndex($labelColumn2) ));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow($labelColumn2, $rowOffset + 7)->applyFromArray(array('font' => array('size' => $fontSizeNormal, 'bold' => true)));

if($tour['TourGroup']['key'] == TourGroup::SENIORS) {
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 8 , __('Spende Seniorenkasse:', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn2, $rowOffset + 8 , $tour['TourGuideReport']['paid_donation']);
}

/*Zahlen formatieren alle in einem Schritt*/
$this->Excel->getActiveSheet()->getStyle(sprintf('%1s%2$d:%1$s%3$d', PHPExcel_Cell::stringFromColumnIndex($labelColumn2), $rowOffset + 1, $rowOffset + 8))
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

/*Fusszeile*/
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 11, __('Diesen Rapport bitte umgehend nach der Tour wie auch im Falle der Absage der Tour zustellen an:', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 13, __('Sektion -> tourenrapport.sektion@sac-albis.ch', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn3, $rowOffset + 13, __('Schweizer Alpen-Club SAC', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn1, $rowOffset + 14, __('Senioren -> tourenrapport.senioren@sac-albis.ch', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($labelColumn3, $rowOffset + 14, __('Sektion Am Albis, Tourenkommision', true));

/*Seite für Druck vorbereiten*/
$this->Excel->getActiveSheet()->getPageMargins()->setTop(0.5);
$this->Excel->getActiveSheet()->getPageMargins()->setBottom(0.5);
$this->Excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&D&R&P/&N'); /*Datum links, Seitenzahl rechts*/
$this->Excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&D&R&P/&N');
$this->Excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

$this->Excel->outputDocument();