<?php
$this->Excel->startNewDocument(true);

$this->Excel->setFilename(sprintf('%s_%s', $this->Time->format($tour['Tour']['startdate'], '%Y_%m_%d'), $tour['Tour']['title']));

$emergencyContactsOffset = 9;
$experienceInformationOffset = $exportEmergencyContacts ? $emergencyContactsOffset + 3 : $emergencyContactsOffset;
$additionalInformationOffset = $exportExperienceInformation ? $experienceInformationOffset + 8 : $experienceInformationOffset;

$endColumn = $emergencyContactsOffset + ($exportEmergencyContacts ? 3 : 0) + ($exportExperienceInformation ? 8 : 0) + ($exportAdditionalInformation ? 10 : 0) - 1;

/* sac section name */
$rowOffset = 2;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, __('SAC, Sektion Am Albis', true));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(1, $rowOffset)->applyFromArray(array('font' => array('size' => 14, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:G%1$d', $rowOffset));

/* tour guide */
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(7, $rowOffset, sprintf(__('Leiter: %s', true), $this->TourDisplay->getTourGuide($tour)));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(7, $rowOffset)->applyFromArray(array('font' => array('size' => 14, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('H%1$d:J%1$d', $rowOffset));

/* tour title */
$rowOffset = 3;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, $tour['Tour']['title'] . ' ' . $this->TourDisplay->getClassification($tour, array('span' => false)));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(1, $rowOffset)->applyFromArray(array('font' => array('size' => 14, 'bold' => true), 'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));
$this->Excel->getActiveSheet()->getRowDimension($rowOffset)->setRowHeight(35);
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:G%1$d', $rowOffset));

/* tour group */
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(7, $rowOffset, sprintf(__('Gruppe: %s', true), $tour['TourGroup']['tourgroupname']));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(7, $rowOffset)->applyFromArray(array('font' => array('size' => 14, 'bold' => true), 'alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('H%1$d:J%1$d', $rowOffset));

/* date */
$rowOffset = 4;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, sprintf('%s [%s]', $this->Display->getDateRangeText($tour['Tour']['startdate'], $tour['Tour']['enddate'], true), $this->Display->getDayOfWeekText($tour['Tour']['startdate'], $tour['Tour']['enddate'])));
$this->Excel->getActiveSheet()->getStyleByColumnAndRow(1, $rowOffset)->applyFromArray(array('font' => array('size' => 9, 'bold' => true)));
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:J%1$d', $rowOffset));

/* list section headers */
$rowOffset = 6;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowOffset, __('Kontaktdaten', true));
$this->Excel->getActiveSheet()->mergeCells(sprintf('B%1$d:%2$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset - 1)));

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($emergencyContactsOffset, $rowOffset, __('Notfall1', true));
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset), PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset + 2)));
}

if($exportExperienceInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($experienceInformationOffset, $rowOffset, __('Erfahrung', true));
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset), PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset + 7)));
}

if($exportAdditionalInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($additionalInformationOffset, $rowOffset, __('Sonstiges', true));
	$this->Excel->getActiveSheet()->mergeCells(sprintf('%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset), PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset + 7)));
}

$this->Excel->getActiveSheet()->getStyle(sprintf('B%1$d:%2$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->applyFromArray(array(
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
	'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)),
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
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(17.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon privat', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon mobil', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('E-Mail', true));
$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(30.75);

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Kontaktadresse', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Telefon', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(14.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('E-Mail', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(30.75);
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
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('ÖV-Abo', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Eigener PKW', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Freie Sitzplätze', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Eigenes Einfachseil', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Eigenes Halbseilpaar', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Eigenes Zelt', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(6.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('Zusätzliche Ausrüstung', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(30.75);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('SAC-Sektion', true));
	$this->Excel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($cell - 1))->setWidth(22.75);

	$this->Excel->getActiveSheet()->getStyle(sprintf(
			'%2$s%1$d:%3$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset + 2), PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset + 7)
	))->applyFromArray(array('alignment' => array('rotation' => 90)));
}

$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->applyFromArray(array(
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
	'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
	'font' => array('bold' => true)
));

/* tour guide */
$rowOffset = 8;
$cell = 0;

$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, __('TL', true));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['lastname']);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['firstname']);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, sprintf('%s %s', $tour['TourGuide']['Profile']['street'], $tour['TourGuide']['Profile']['housenumber']));
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['zip']);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['city']);

$this->Excel->getActiveSheet()->getCell(sprintf('%s%d', PHPExcel_Cell::stringFromColumnIndex($cell++), $rowOffset))->setValueExplicit($tour['TourGuide']['Profile']['phoneprivate'], PHPExcel_Cell_DataType::TYPE_STRING);
$this->Excel->getActiveSheet()->getCell(sprintf('%s%d', PHPExcel_Cell::stringFromColumnIndex($cell++), $rowOffset))->setValueExplicit($tour['TourGuide']['Profile']['cellphone'], PHPExcel_Cell_DataType::TYPE_STRING);
$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['email']);

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['emergencycontact1_address']);
	$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset)->getAlignment()->setWrapText(true);
	$this->Excel->getActiveSheet()->getCell(sprintf('%s%d', PHPExcel_Cell::stringFromColumnIndex($cell++), $rowOffset))->setValueExplicit($tour['TourGuide']['Profile']['emergencycontact1_phone'], PHPExcel_Cell_DataType::TYPE_STRING);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['emergencycontact1_email']);
}

if($exportExperienceInformation)
{
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $this->Display->displayYesNoDontKnow($tour['TourGuide']['Profile']['experience_rope_guide']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $this->Display->displayExperience($tour['TourGuide']['Profile']['experience_knot_technique']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $this->Display->displayExperience($tour['TourGuide']['Profile']['experience_rope_handling']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $this->Display->displayExperience($tour['TourGuide']['Profile']['experience_avalanche_training']));

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, (!empty($tour['TourGuide']['Profile']['LeadClimbNiveau']) ? $tour['TourGuide']['Profile']['LeadClimbNiveau']['name'] : ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, (!empty($tour['TourGuide']['Profile']['SecondClimbNiveau']) ? $tour['TourGuide']['Profile']['SecondClimbNiveau']['name']: ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, (!empty($tour['TourGuide']['Profile']['AlpineTourNiveau']) ? $tour['TourGuide']['Profile']['AlpineTourNiveau']['name'] : ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, (!empty($tour['TourGuide']['Profile']['SkiTourNiveau']) ? $tour['TourGuide']['Profile']['SkiTourNiveau']['name'] : ''));
}

if($exportAdditionalInformation)
{
	$cell = $cell + 2;
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $this->Display->displayPublicTransportSubscription($tour['TourGuide']['Profile']['publictransportsubscription']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, ($tour['TourGuide']['Profile']['ownpassengercar'] ? __('Ja', true) : __('Nein', true)));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['freeseatsinpassengercar']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, ($tour['TourGuide']['Profile']['ownsinglerope'] ? sprintf('%dm', $tour['TourGuide']['Profile']['lengthsinglerope']) : ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, ($tour['TourGuide']['Profile']['ownhalfrope'] ? sprintf('%dm', $tour['TourGuide']['Profile']['lengthhalfrope']) : ''));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, ($tour['TourGuide']['Profile']['owntent'] ? __('Ja', true) : __('Nein', true)));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $tour['TourGuide']['Profile']['additionalequipment']);
	$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset)->getAlignment()->setWrapText(true);
	/*SAC Membership*/
	$sacMembershipCell = "";
	if($tour['TourGuide']['Profile']['sac_member'] <= 1)
	{
		$sacMembershipCell = $this->Display->displaySacMember($tour['TourGuide']['Profile']['sac_member']);

		if(!empty($tour['TourGuide']['Profile']['sac_main_section_id']))
		{
			$sacMembershipCell = $sacMembershipCell . " " . $tour['TourGuide']['Profile']['SacMainSection']['title'];
		}
	}

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset, $sacMembershipCell);
}

$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

/* list */
$rowOffset = 9;
$index = 0;

foreach($tourParticipations as $tourParticipation)
{
	$cell = 0;

	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($index + 1));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['lastname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['firstname']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, sprintf('%s %s', $tourParticipation['TourParticipation']['street'], $tourParticipation['TourParticipation']['housenumber']));
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['zip']);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['city']);

	$this->Excel->getActiveSheet()->getCell(sprintf('%s%d', PHPExcel_Cell::stringFromColumnIndex($cell++), $rowOffset + $index))->setValueExplicit($tourParticipation['TourParticipation']['phoneprivate'], PHPExcel_Cell_DataType::TYPE_STRING);
	$this->Excel->getActiveSheet()->getCell(sprintf('%s%d', PHPExcel_Cell::stringFromColumnIndex($cell++), $rowOffset + $index))->setValueExplicit($tourParticipation['TourParticipation']['cellphone'], PHPExcel_Cell_DataType::TYPE_STRING);
	$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['email']);

	if($exportEmergencyContacts)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['emergencycontact1_address']);
		$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset + $index)->getAlignment()->setWrapText(true);
		$this->Excel->getActiveSheet()->getCell(sprintf('%s%d', PHPExcel_Cell::stringFromColumnIndex($cell++), $rowOffset + $index))->setValueExplicit($tourParticipation['TourParticipation']['emergencycontact1_phone'], PHPExcel_Cell_DataType::TYPE_STRING);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['emergencycontact1_email']);
	}

	if($exportExperienceInformation)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayYesNoDontKnow($tourParticipation['TourParticipation']['experience_rope_guide']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_knot_technique']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_rope_handling']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayExperience($tourParticipation['TourParticipation']['experience_avalanche_training']));

		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, (!empty($tourParticipation['LeadClimbNiveau']) ? $tourParticipation['LeadClimbNiveau']['name'] : ''));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, (!empty($tourParticipation['SecondClimbNiveau']) ? $tourParticipation['SecondClimbNiveau']['name'] : ''));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, (!empty($tourParticipation['AlpineTourNiveau']) ? $tourParticipation['AlpineTourNiveau']['name'] : ''));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, (!empty($tourParticipation['SkiTourNiveau']) ? $tourParticipation['SkiTourNiveau']['name'] : ''));
	}

	if($exportAdditionalInformation)
	{
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['note_participant']);
		$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset + $index)->getAlignment()->setWrapText(true);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipationStatus']['statusname']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $this->Display->displayPublicTransportSubscription($tourParticipation['TourParticipation']['publictransportsubscription']));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($tourParticipation['TourParticipation']['ownpassengercar'] ? __('Ja', true) : __('Nein', true)));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['freeseatsinpassengercar']);
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($tourParticipation['TourParticipation']['ownsinglerope'] ? sprintf('%dm', $tourParticipation['TourParticipation']['lengthsinglerope']) : ''));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($tourParticipation['TourParticipation']['ownhalfrope'] ? sprintf('%dm', $tourParticipation['TourParticipation']['lengthhalfrope']) : ''));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, ($tourParticipation['TourParticipation']['owntent'] ? __('Ja', true) : __('Nein', true)));
		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $tourParticipation['TourParticipation']['additionalequipment']);
		$this->Excel->getActiveSheet()->getStyleByColumnAndRow($cell - 1, $rowOffset + $index)->getAlignment()->setWrapText(true);
		/*SAC Membership*/
		$sacMembershipCell = "";
		if($tourParticipation['TourParticipation']['sac_member'] <= 1)
		{
			$sacMembershipCell = $this->Display->displaySacMember($tourParticipation['TourParticipation']['sac_member']);

			if(!empty($tourParticipation['TourParticipation']['sac_main_section_id']))
			{
				$sacMembershipCell .= " " . $tourParticipation['SacMainSection']['title'];
			}
		}

		$this->Excel->getActiveSheet()->setCellValueByColumnAndRow($cell++, $rowOffset + $index, $sacMembershipCell);
	}

	$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%1$d', $rowOffset + $index, PHPExcel_Cell::stringFromColumnIndex($endColumn)))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

	$index++;
}

$this->Excel->getActiveSheet()->getStyle(sprintf('A%1$d:%2$s%3$d', $rowOffset - 1, PHPExcel_Cell::stringFromColumnIndex($endColumn), $rowOffset + $index - 1))->applyFromArray(array(
	'borders' => array(
		'left' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'right' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'vertical' => array('style' => PHPExcel_Style_Border::BORDER_HAIR),
		'horizontal' => array('style' => PHPExcel_Style_Border::BORDER_HAIR)
	)
));

$this->Excel->getActiveSheet()->getStyle(sprintf('B%1$d:B%2$d', $rowOffset - 2, $rowOffset + $index - 1))->applyFromArray(array(
	'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)),
));

if($exportEmergencyContacts)
{
	$this->Excel->getActiveSheet()->getStyle(sprintf('%1$s%2$d:%1$s%3$d', PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset), $rowOffset - 2, $rowOffset + $index - 1))->applyFromArray(array(
		'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)),
	));
	$this->Excel->getActiveSheet()->getStyle(sprintf('%1$s%2$d:%1$s%3$d', PHPExcel_Cell::stringFromColumnIndex($emergencyContactsOffset + 3), $rowOffset - 2, $rowOffset + $index - 1))->applyFromArray(array(
		'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)),
	));
}

if($exportExperienceInformation)
{
	$this->Excel->getActiveSheet()->getStyle(sprintf('%1$s%2$d:%1$s%3$d', PHPExcel_Cell::stringFromColumnIndex($experienceInformationOffset), $rowOffset - 2, $rowOffset + $index - 1))->applyFromArray(array(
		'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)),
	));
}

if($exportAdditionalInformation)
{
	$this->Excel->getActiveSheet()->getStyle(sprintf('%1$s%2$d:%1$s%3$d', PHPExcel_Cell::stringFromColumnIndex($additionalInformationOffset), $rowOffset - 2, $rowOffset + $index - 1))->applyFromArray(array(
		'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)),
	));
}

/*Seite für Druck vorbereiten*/

$this->Excel->getActiveSheet()->getPageMargins()->setTop(0.195);
$this->Excel->getActiveSheet()->getPageMargins()->setBottom(0.195);
$this->Excel->getActiveSheet()->getPageMargins()->setLeft(0.195);
$this->Excel->getActiveSheet()->getPageMargins()->setRight(0.195);
$this->Excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&D&R&P/&N'); /*Datum links, Seitenzahl rechts*/
$this->Excel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&D&R&P/&N');
$this->Excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$this->Excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$this->Excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

$this->Excel->outputDocument();