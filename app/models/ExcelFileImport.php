<?php
class ExcelFileImport extends Eloquent{

	public static function Spreadsheet_Excel_Reader($file='',$store_extended_info=true,$outputEncoding=''){
		//$this->_ole =& new OLERead();
		ExcelFileImport::setUTFEncoder('iconv');
		if ($outputEncoding != '') { 
			ExcelFileImport::setOutputEncoding($outputEncoding);
		}
		for ($i=1; $i<245; $i++) {
			$name = strtolower(( (($i-1)/26>=1)?chr(($i-1)/26+64):'') . chr(($i-1)%26+65));
			$this->colnames[$name] = $i;
			$this->colindexes[$i] = $name;
		}
		$store_extended_info = $store_extended_info;
		if ($file!="") {
			ExcelFileImport::read($file);
		}
	}

	public static function setUTFEncoder($encoder = 'iconv') {
		$encoderFunction = '';
		if ($encoder == 'iconv') {
			$encoderFunction = function_exists('iconv') ? 'iconv' : '';
		} elseif ($encoder == 'mb') {
			$encoderFunction = function_exists('mb_convert_encoding') ? 'mb_convert_encoding' : '';
		}
	}

	public static function setOutputEncoding($encoding) {
		$this->_defaultEncoding = $encoding;
	}

	public static function read($sFileName) {
		$res = $this->_ole->read($sFileName);

		// oops, something goes wrong (Darko Miljanovic)
		if($res === false) {
			// check error code
			if($this->_ole->error == 1) {
				// bad file
				die('The filename ' . $sFileName . ' is not readable');
			}
			// check other error codes here (eg bad fileformat, etc...)
		}
		$data = $this->_ole->getWorkBook();
		$this->_parse();
	}


}


?>