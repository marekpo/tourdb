<?php
$this->Excel->startNewDocument(true);

$this->Excel->setFilename(sprintf('%d_%s', $this->Time->format($tour['Tour']['startdate'], '%Y'), $tour['Tour']['title']));

$emergencyContactsOffset = 10;
$experienceInformationOffset = $exportEmergencyContacts ? $emergencyContactsOffset + 6 : $emergencyContactsOffset;
$additionalInformationOffset = $exportExperienceInformation ? $experienceInformationOffset + 8 : $experienceInformationOffset;

$endColumn = $emergencyContactsOffset + ($exportEmergencyContacts ? 6 : 0) + ($exportExperienceInformation ? 8 : 0) + ($exportAdditionalInformation ? 2 : 0) - 1;

/* sac section name */
$rowOffset = 2;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, __('SAC Sektion Am Albis', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(1, $rowOffset)->applyFromArray(array('font' => array('size' => 14, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:G%1$d', $rowOffset));

/* tour guide */
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(7, $rowOffset, sprintf(__('Leiter: %s', true), $this->TourDisplay->getTourGuide($tour)));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(7, $rowOffset)->applyFromArray(array('font' => array('size' => 9, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('H%1$d:J%1$d', $rowOffset));

/* tour title */
$rowOffset = 3;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, $tour['Tour']['title']);
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(1, $rowOffset)->applyFromArray(array('font' => array('size' => 14, 'bold' => true), 'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));
$this->Excel->getActiveSheet()->getRowDimension($rowOffset)->setRowHeight(35);
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:J%1$d', $rowOffset));

/* date */
$rowOffset = 4;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, sprintf('%s-%s [%s - %s]',
	$this->Time->format($tour['Tour']['startdate'], '%d.%m.%Y'), $this->Time->format($tour['Tour']['enddate'], '%d.%m.%Y'),
	$this->Time->format($tour['Tour']['startdate'], '%a'), $this->Time->format($tour['Tour']['enddate'], '%a')
));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(1, $rowOffset)->applyFromArray(array('font' => array('size' => 9, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:J%1$d', $rowOffset));

/* list section headers */
$rowOffset = 6;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, __('Kontaktdaten', true));

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($emergencyContactsOffset, $rowOffset, __('Notfall1', true));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($emergencyContactsOffset + 3, $rowOffset, __('Notfall2', true));
}

if($exportExperienceInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($experienceInformationOffset, $rowOffset, __('Erfahrung', true));
}

if($exportAdditionalInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($additionalInformationOffset, $rowOffset, __('Sonstiges', true));
}

$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:J%1$d', $rowOffset));

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset), PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset + 2)));
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset + 3), PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset + 5)));
}

if($exportExperienceInformation)
{
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset), PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset + 7)));
}

if($exportAdditionalInformation)
{
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset), PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset + 1)));
}

$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->applyFromArray(array(
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
	'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('argb' => 'ffdddddd'))
));

/* list colum headers */
$rowOffset = 7;
$cell = 0;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Nr.', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(4.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Name', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Vorname', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Adresse', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('PLZ', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Ort', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(12.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon privat', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon gesch.', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon mobil', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('E-Mail', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Kontaktadresse', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('E-Mail', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Kontaktadresse', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('E-Mail', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
}

if($exportExperienceInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Seilführer', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Knotentechnik', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Seilhandhabung', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Lawinenausbildung', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Klettern Vorstieg', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Klettern Nachstieg', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Alpin-/Hochtouren', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Skitouren', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);

	$this->Excel->getActiveSheet()->getStyle(sprintf(
		'%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset), PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset + 7)
	))->applyFromArray(array('alignment' => array('rotation' => 90)));
}

if($exportAdditionalInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Mitteilung', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(30.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Status', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(11.75);
}

$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->applyFromArray(array(
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
	'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
	'font' => array('bold' => true),
	'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('argb' => 'ff689cd3'))
));

/* list */
$rowOffset = 8;
$index = 0;

foreach($tourParticipations as $tourParticipation)
{
	$cell = 0;
	
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($index + 1));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['firstname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['lastname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, sprintf('%s %s', $tourParticipation['User']['Profile']['street'], $tourParticipation['User']['Profile']['housenumber']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['zip']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['city']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['phoneprivate']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['phonebusiness']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['cellphone']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['email']);

	if($exportEmergencyContacts)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['emergencycontact1_address']);
		$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset + $index)->getAlignment()->setWrapText(true);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['emergencycontact1_phone']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['emergencycontact1_email']);
	
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['emergencycontact2_address']);
		$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset + $index)->getAlignment()->setWrapText(true);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['emergencycontact2_phone']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['emergencycontact2_email']);
	}

	if($exportExperienceInformation)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayYesNoDontKnow($tourParticipation['User']['Profile']['experience_rope_guide']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayExperience($tourParticipation['User']['Profile']['experience_knot_technique']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayExperience($tourParticipation['User']['Profile']['experience_rope_handling']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayExperience($tourParticipation['User']['Profile']['experience_avalanche_training']));

		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['LeadClimbNiveau']['name']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['SecondClimbNiveau']['name']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['AlpineTourNiveau']['name']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['User']['Profile']['SkiTourNiveau']['name']);
	}

	if($exportAdditionalInformation)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['note_participant']);
		$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset + $index)->getAlignment()->setWrapText(true);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipationStatus']['statusname']);
	}

	$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset + $index, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

	$index++;
}

$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%3$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset + $index - 1))->applyFromArray(array(
	'borders' => array(
		'left' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'right' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'vertical' => array('style' => PHPExcel_Style_Border::BORDER_HAIR)
	)
));

$this->Excel->outputDocument();