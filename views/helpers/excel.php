<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel' . DS . 'PHPExcel.php'));

class ExcelHelper extends AppHelper
{
	var $phpExcelObject;

	var $filename = "Export.xlsx";

	function __construct()
	{
		parent::__construct();
	}

	function startNewDocument()
	{
		$this->phpExcelObject = new PHPExcel();
	}

	function getActiveSheet()
	{
		return $this->phpExcelObject->getActiveSheet();
	}

	function setFilename($filename)
	{
		$this->filename = $filename;

		if(!preg_match('/\.xlsx$/i', $this->filename))
		{
			$this->filename .= '.xlsx';
		}
	}

	function outputDocument()
	{
		Configure::write('debug', 0);
		$view =& ClassRegistry::getObject('view');
		$view->layout = 'csv';

		header('Content-type: application/excel');
		header(sprintf('Content-disposition:attachment; filename=%s', $this->filename));

		$writer = new PHPExcel_Writer_Excel2007($this->phpExcelObject);
		$writer->save('php://output');
	}
}