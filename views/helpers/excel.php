<?php
App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel' . DS . 'PHPExcel.php'));

class ExcelHelper extends AppHelper
{
	var $phpExcelObject;

	var $filename = 'Export.xlsx';

	var $fileExtension = '.xlsx';

	var $legacyMode;

	function __construct()
	{
		parent::__construct();
	}

	function startNewDocument($legacyMode = false)
	{
		$this->phpExcelObject = new PHPExcel();

		if($legacyMode)
		{
			$this->fileExtension = '.xls';
			$this->setFilename('Export');
		}

		$this->legacyMode = $legacyMode;
	}

	function getActiveSheet()
	{
		return $this->phpExcelObject->getActiveSheet();
	}

	function setFilename($filename)
	{
		$filename = preg_replace('/[^\s\p{L}\p{N}_-]/u', '', $filename);
		$filename = preg_replace('/\s+/u', '_', $filename);

		if(!preg_match(sprintf('/\%s$/iu', $this->fileExtension), $filename))
		{
			$filename .= $this->fileExtension;
		}

		$this->filename = $filename;
	}

	function outputDocument()
	{
		Configure::write('debug', 0);
		$view =& ClassRegistry::getObject('view');
		$view->layout = 'csv';

		header('Content-type: application/excel');
		header(sprintf("Content-disposition:attachment; filename*=UTF-8''%s", urlencode($this->filename)));

		if($this->legacyMode)
		{
			$writer = new PHPExcel_Writer_Excel5($this->phpExcelObject);
		}
		else
		{
			$writer = new PHPExcel_Writer_Excel2007($this->phpExcelObject);
		}

		$writer->save('php://output');
	}
}