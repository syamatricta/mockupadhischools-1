<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------


	require_once 'Excel/oleread.php';
	define('Spreadsheet_Excel_Reader_BIFF8', 										0x600		);
	define('Spreadsheet_Excel_Reader_BIFF7', 										0x500		);
	define('Spreadsheet_Excel_Reader_WorkbookGlobals', 								0x5			);
	define('Spreadsheet_Excel_Reader_Worksheet', 									0x10		);
	define('Spreadsheet_Excel_Reader_Type_BOF', 									0x809		);
	define('Spreadsheet_Excel_Reader_Type_EOF', 									0x0a		);
	define('Spreadsheet_Excel_Reader_Type_BOUNDSHEET', 								0x85		);
	define('Spreadsheet_Excel_Reader_Type_DIMENSION', 								0x200		);
	define('Spreadsheet_Excel_Reader_Type_ROW', 									0x208		);
	define('Spreadsheet_Excel_Reader_Type_DBCELL', 									0xd7		);
	define('Spreadsheet_Excel_Reader_Type_FILEPASS', 								0x2f		);
	define('Spreadsheet_Excel_Reader_Type_NOTE', 									0x1c		);
	define('Spreadsheet_Excel_Reader_Type_TXO', 									0x1b6		);
	define('Spreadsheet_Excel_Reader_Type_RK', 										0x7e		);
	define('Spreadsheet_Excel_Reader_Type_RK2', 									0x27e		);
	define('Spreadsheet_Excel_Reader_Type_MULRK', 									0xbd		);
	define('Spreadsheet_Excel_Reader_Type_MULBLANK', 								0xbe		);
	define('Spreadsheet_Excel_Reader_Type_INDEX', 									0x20b		);
	define('Spreadsheet_Excel_Reader_Type_SST', 									0xfc		);
	define('Spreadsheet_Excel_Reader_Type_EXTSST', 									0xff		);
	define('Spreadsheet_Excel_Reader_Type_CONTINUE', 								0x3c		);
	define('Spreadsheet_Excel_Reader_Type_LABEL', 									0x204		);
	define('Spreadsheet_Excel_Reader_Type_LABELSST', 								0xfd		);
	define('Spreadsheet_Excel_Reader_Type_NUMBER', 									0x203		);
	define('Spreadsheet_Excel_Reader_Type_NAME', 									0x18		);
	define('Spreadsheet_Excel_Reader_Type_ARRAY', 									0x221		);
	define('Spreadsheet_Excel_Reader_Type_STRING', 									0x207		);
	define('Spreadsheet_Excel_Reader_Type_FORMULA', 								0x406		);
	define('Spreadsheet_Excel_Reader_Type_FORMULA2', 								0x6			);
	define('Spreadsheet_Excel_Reader_Type_FORMAT', 									0x41e		);
	define('Spreadsheet_Excel_Reader_Type_XF', 										0xe0		);
	define('Spreadsheet_Excel_Reader_Type_BOOLERR', 								0x205		);
	define('Spreadsheet_Excel_Reader_Type_UNKNOWN',									0xffff		);
	define('Spreadsheet_Excel_Reader_Type_NINETEENFOUR', 							0x22		);
	define('Spreadsheet_Excel_Reader_Type_MERGEDCELLS', 							0xE5		);
	define('Spreadsheet_Excel_Reader_utcOffsetDays' , 								25569		);
	define('Spreadsheet_Excel_Reader_utcOffsetDays1904', 							24107		);
	define('Spreadsheet_Excel_Reader_msInADay', 									24 * 60 * 60);
	define('Spreadsheet_Excel_Reader_DEF_NUM_FORMAT', 								"%s"		);
		if (!function_exists('file_get_contents')) {
    		function file_get_contents($filename, $use_include_path = 0) {
        		$data 												= 	'';
        		$file 												= 	@fopen($filename, "rb", $use_include_path);
        	if ($file) {
            	while (!feof($file)) $data .= fread($file, 1024);
            	fclose($file);
       			} else {
            		$data 											= 	FALSE;
					}
        return $data; 
    		}
		}
	class Spreadsheet_Excel_Reader {
		var $_is_percent											=	FALSE;		
	    var $boundsheets 											= 	array();
    	var $formatRecords 											= 	array();
	    var $sst 													= 	array();
    	var $sheets 												= 	array();
	    var $data;
    	var $pos;
	    var $_ole;
    	var $_defaultEncoding;
	    var $_defaultFormat 										= 	Spreadsheet_Excel_Reader_DEF_NUM_FORMAT;
	    var $_columnsFormat 										= 	array();
	    var $_rowoffset 											= 	1;
    	var $_coloffset 											= 	1;
        var $dateFormats 											= 	array (
	        0xe => "m/d/Y",
    	    0xf => "M-d-Y",
        	0x10 => "M-d",
	        0x11 => "M-Y",
    	    0x12 => "h:i a",
        	0x13 => "h:i:s a",
	        0x14 => "H:i",
    	    0x15 => "H:i:s",
	        0x16 => "m/d/Y H:i",
	        0x2d => "i:s",
	        0x2e => "H:i:s",
    	    0x2f => "i:s.S");
	    var $numberFormats 											=	 array(
    	    0x1 => "%1.0f", 
        	0x2 => "%1.2f", 
	        0x3 => "%1.0f", 
    	    0x4 => "%1.2f", 
        	0x5 => "%1.0f", 
	        0x6 => '$%1.0f', 
	        0x7 => '$%1.2f', 
	        0x8 => '$%1.2f', 
    	    0x9 => '%1.0f%%', 
        	0xa => '%.2f%%', 
	        0xb => '%1.2f', 
	        0x25 => '%1.0f', 
	        0x26 => '%1.0f',
    	    0x27 => '%1.2f', 
	        0x28 => '%1.2f', 
    	    0x29 => '%1.0f', 
        	0x2a => '$%1.0f',
	        0x2b => '%1.2f', 
	        0x2c => '$%1.2f', 
	        0x30 => '%1.0f');
	    function Spreadsheet_Excel_Reader(){
	        $this->_ole 											= 	new OLERead();
    	    $this->setUTFEncoder('iconv');
    	}
	    function setOutputEncoding($Encoding){
        	$this->_defaultEncoding 								= 	$Encoding;
    	}
	    function setUTFEncoder($encoder = 'iconv'){
    		$this->_encoderFunction 								= 	'';
		    	if ($encoder == 'iconv'){
        			$this->_encoderFunction 						=	function_exists('iconv') ? 'iconv' : '';
		        }elseif ($encoder == 'mb') {
        			$this->_encoderFunction 						= 	function_exists('mb_convert_encoding') ? 'mb_convert_encoding' : '';
    			}
    	}
	    function setRowColOffset($iOffset){
    	    $this->_rowoffset 										= 	$iOffset;
			$this->_coloffset 										= 	$iOffset;
    	}
	    function setDefaultFormat($sFormat){
    	    $this->_defaultFormat 									= 	$sFormat;
	    }
	    function setColumnFormat($column, $sFormat){
    	    $this->_columnsFormat[$column] 							= 	$sFormat;
	    }
	    function read($sFileName) {
    		$errlevel 												= 	error_reporting();
    		error_reporting($errlevel ^ E_NOTICE);
	        $res = $this->_ole->read($sFileName);
				if($res === false) {
					if($this->_ole->error == 1) {
       	        		die('The filename ' . $sFileName . ' is not readable');	
        			}
                }
	        $this->data 											= 	$this->_ole->getWorkBook();
	        $this->pos 												= 	0;
            $this->_parse();
    		error_reporting($errlevel);
		}
	    function _parse(){
    	    $pos 													= 	0;
	        $code 													= 	ord($this->data[$pos]) | ord($this->data[$pos+1])<<8;
     		$length 												= 	ord($this->data[$pos+2]) | ord($this->data[$pos+3])<<8;
	        $version 												= 	ord($this->data[$pos + 4]) | ord($this->data[$pos + 5])<<8;
    	    $substreamType 											= 	ord($this->data[$pos + 6]) | ord($this->data[$pos + 7])<<8;
			if (($version != Spreadsheet_Excel_Reader_BIFF8) && ($version != Spreadsheet_Excel_Reader_BIFF7)) {
				return false;
			}
			if ($substreamType != Spreadsheet_Excel_Reader_WorkbookGlobals){
				return false;
			}
    	    $pos 													+= 	$length + 4;
	        $code 													= 	ord($this->data[$pos]) | ord($this->data[$pos+1])<<8;
    	    $length 												= 	ord($this->data[$pos+2]) | ord($this->data[$pos+3])<<8;
	    	    while ($code != Spreadsheet_Excel_Reader_Type_EOF){
					switch ($code) {
						case Spreadsheet_Excel_Reader_Type_SST:
							$spos 									= 	$pos + 4;
                     		$limitpos 								= 	$spos + $length;
                     		$uniqueStrings 							= 	$this->_GetInt4d($this->data, $spos+4);
                            $spos 									+= 	8;
                            for ($i = 0; $i < $uniqueStrings; $i++) {
                                if ($spos == $limitpos) {
                                    $opcode 						= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
									$conlength 						= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
									if ($opcode != 0x3c) {
										return -1;
									}
									$spos 							+= 	4;
									$limitpos 						= 	$spos + $conlength;
								}
								$numChars 							= 	ord($this->data[$spos]) | (ord($this->data[$spos+1]) << 8);
								$spos 								+= 	2;
								$optionFlags 						= 	ord($this->data[$spos]);
								$spos++;
								$asciiEncoding 						= 	(($optionFlags & 0x01) == 0) ;
								$extendedString 					= 	(($optionFlags & 0x04) != 0);
								$richString 						= 	(($optionFlags & 0x08) != 0);
								if ($richString) {
									$formattingRuns 				= 	ord($this->data[$spos]) | (ord($this->data[$spos+1]) << 8);
									$spos 							+= 	2;
								}
								if ($extendedString) {
									$extendedRunLength 				= 	$this->_GetInt4d($this->data, $spos);
									$spos 							+= 	4;
								}
								$len = ($asciiEncoding)? $numChars : $numChars*2;
								if ($spos + $len < $limitpos) {
									$retstr 						= 	substr($this->data, $spos, $len);
									$spos 							+= 	$len;
								}else{
									$retstr 						= 	substr($this->data, $spos, $limitpos - $spos);
									$bytesRead 						= 	$limitpos - $spos;
									$charsLeft 						= 	$numChars - (($asciiEncoding) ? $bytesRead : ($bytesRead / 2));
									$spos = $limitpos;
									while ($charsLeft > 0){
										$opcode 					= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
										$conlength 					= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
										if ($opcode != 0x3c) {
											return -1;
										}
										$spos 						+= 	4;
										$limitpos 					= 	$spos + $conlength;
										$option 					= 	ord($this->data[$spos]);
										$spos 						+= 	1;
										if ($asciiEncoding && ($option == 0)) {
											$len 					= 	min($charsLeft, $limitpos - $spos); 
											$retstr 				.= 	substr($this->data, $spos, $len);
											$charsLeft 				-= 	$len;
											$asciiEncoding 			= 	true;
										}elseif (!$asciiEncoding && ($option != 0)){
											$len 					= 	min($charsLeft * 2, $limitpos - $spos);
											$retstr 				.= 	substr($this->data, $spos, $len);
											$charsLeft 				-= 	$len/2;
											$asciiEncoding 			= 	false;
										}elseif (!$asciiEncoding && ($option == 0)) {
											$len = min($charsLeft, $limitpos - $spos); 
											for ($j = 0; $j < $len; $j++) {
												$retstr 			.= 	$this->data[$spos + $j].chr(0);
											}
											$charsLeft -= $len;
											$asciiEncoding 			= 	false;
										}else{
											$newstr = '';
												for ($j = 0; $j < strlen($retstr); $j++) {
													$newstr 		= 	$retstr[$j].chr(0);
												}
											$retstr 				= 	$newstr;
											$len 					= 	min($charsLeft * 2, $limitpos - $spos); 
											$retstr 				.= 	substr($this->data, $spos, $len);
											$charsLeft 				-= 	$len/2;
											$asciiEncoding 			= 	false;
										}
										$spos += $len;
									}
								}
								$retstr = ($asciiEncoding) ? $retstr : $this->_encodeUTF16($retstr);
								if ($richString){
									$spos 							+= 	4 * $formattingRuns;
								}
								if ($extendedString) {
									$spos 							+= 	$extendedRunLength;
								}
								$this->sst[]						=	$retstr;
							}
							break;
                		case Spreadsheet_Excel_Reader_Type_FILEPASS:
							return false;
							break;
						case Spreadsheet_Excel_Reader_Type_NAME:
							break;
						case Spreadsheet_Excel_Reader_Type_FORMAT:
							$indexCode 								= 	ord($this->data[$pos+4]) | ord($this->data[$pos+5]) << 8;
							if ($version == Spreadsheet_Excel_Reader_BIFF8) {
                    			$numchars 							= 	ord($this->data[$pos+6]) | ord($this->data[$pos+7]) << 8;
                        		if (ord($this->data[$pos+8]) == 0){
                            		$formatString 					= 	substr($this->data, $pos+9, $numchars);
                        		} else {
                        			$formatString 					= 	substr($this->data, $pos+9, $numchars*2);
                        		}
                        	} else {
								$numchars 							= 	ord($this->data[$pos+6]);
								$formatString 						= 	substr($this->data, $pos+7, $numchars*2);
							}
                    		$this->formatRecords[$indexCode] 		= 	$formatString;
                			break;
						case Spreadsheet_Excel_Reader_Type_XF:
	                		$indexCode = ord($this->data[$pos+6]) | ord($this->data[$pos+7]) << 8;
                    		if (array_key_exists($indexCode, $this->dateFormats)) {
								$this->formatRecords['xfrecords'][] = 	array(
								'type' => 'date',
								'format' => $this->dateFormats[$indexCode]
								);
                        	}elseif (array_key_exists($indexCode, $this->numberFormats)) {
								$this->formatRecords['xfrecords'][] = 	array(
								'type' => 'number',
								'format' => $this->numberFormats[$indexCode]
								);
								
                        	}else{
                            	$isdate = FALSE;
                            	if ($indexCode > 0){
                            		if (isset($this->formatRecords[$indexCode]))
                                		$formatstr 					= 	$this->formatRecords[$indexCode];
                                	if ($formatstr)
                               			if (preg_match("/[^hmsday\/\-:\s]/i", $formatstr) == 0) {
                                    		$isdate 				= 	TRUE;
                                    		$formatstr 				= 	str_replace('mm', 'i', $formatstr);
                                    		$formatstr 				= 	str_replace('h', 'H', $formatstr);
                                        }
                       			}
								if ($isdate){
									$this->formatRecords['xfrecords'][] = array(
									'type' => 'date',
									'format' => $formatstr,
									);
								}else{
									$this->formatRecords['xfrecords'][] = array(
									'type' => 'other',
									'format' => '',
									'code' => $indexCode
									);
								}
                        	}
							break;
						case Spreadsheet_Excel_Reader_Type_NINETEENFOUR:
        	        		$this->nineteenFour 					= 	(ord($this->data[$pos+4]) == 1);
                			break;
                		case Spreadsheet_Excel_Reader_Type_BOUNDSHEET:
							$rec_offset 							= 	$this->_GetInt4d($this->data, $pos+4);
							$rec_typeFlag 							= 	ord($this->data[$pos+8]);
							$rec_visibilityFlag 					= 	ord($this->data[$pos+9]);
							$rec_length 							= 	ord($this->data[$pos+10]);
							if ($version == Spreadsheet_Excel_Reader_BIFF8){
								$chartype 							=  	ord($this->data[$pos+11]);
								if ($chartype == 0){
									$rec_name    					= 	substr($this->data, $pos+12, $rec_length);
								} else {
									$rec_name    					= 	$this->_encodeUTF16(substr($this->data, $pos+12, $rec_length*2));
								}	
							}elseif ($version == Spreadsheet_Excel_Reader_BIFF7){
									$rec_name    					= 	substr($this->data, $pos+11, $rec_length);
							}
							$this->boundsheets[] = array('name'=>$rec_name,
													 'offset'=>$rec_offset);
                    		break;
					}
					$pos 											+= 	$length + 4;
					$code 											= 	ord($this->data[$pos]) | ord($this->data[$pos+1])<<8;
					$length 										= 	ord($this->data[$pos+2]) | ord($this->data[$pos+3])<<8;
		        }
				foreach ($this->boundsheets as $key=>$val){
					$this->sn 										= 	$key;
					$this->_parsesheet($val['offset']);
				}
       		 return true;
		}
		function _parsesheet($spos){
        	$cont 													= 	true;
        	$code 													= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
        	$length 												= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
        	$version 												= 	ord($this->data[$spos + 4]) | ord($this->data[$spos + 5])<<8;
        	$substreamType 											= 	ord($this->data[$spos + 6]) | ord($this->data[$spos + 7])<<8;
        	if (($version != Spreadsheet_Excel_Reader_BIFF8) && ($version != Spreadsheet_Excel_Reader_BIFF7)) {
            	return -1;
        	}
			if ($substreamType != Spreadsheet_Excel_Reader_Worksheet){
				return -2;
			}
        	$spos += $length + 4;
        	while($cont) {
				$lowcode 											= 	ord($this->data[$spos]);
				if ($lowcode == Spreadsheet_Excel_Reader_Type_EOF) break;
				$code 												= 	$lowcode | ord($this->data[$spos+1])<<8;
				$length 											= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
				$spos += 4;
				$this->sheets[$this->sn]['maxrow'] 					= 	$this->_rowoffset - 1;
				$this->sheets[$this->sn]['maxcol'] 					= 	$this->_coloffset - 1;
				unset($this->rectype);
				$this->multiplier 									= 	1; 
            	switch ($code) {
                	case Spreadsheet_Excel_Reader_Type_DIMENSION:
						if (!isset($this->numRows)) {
							if (($length == 10) ||  ($version == Spreadsheet_Excel_Reader_BIFF7)){
								$this->sheets[$this->sn]['numRows'] = 	ord($this->data[$spos+2]) | ord($this->data[$spos+3]) << 8;
								$this->sheets[$this->sn]['numCols'] = 	ord($this->data[$spos+6]) | ord($this->data[$spos+7]) << 8;
							} else {
								$this->sheets[$this->sn]['numRows'] = 	ord($this->data[$spos+4]) | ord($this->data[$spos+5]) << 8;
								$this->sheets[$this->sn]['numCols'] = 	ord($this->data[$spos+10]) | ord($this->data[$spos+11]) << 8;
							}
						}
                    	break;
                	case Spreadsheet_Excel_Reader_Type_MERGEDCELLS:
                    	$cellRanges = ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
						for ($i = 0; $i < $cellRanges; $i++) {
							$fr 									=  	ord($this->data[$spos + 8*$i + 2]) | ord($this->data[$spos + 8*$i + 3])<<8;
							$lr 									=  	ord($this->data[$spos + 8*$i + 4]) | ord($this->data[$spos + 8*$i + 5])<<8;
							$fc 									=  	ord($this->data[$spos + 8*$i + 6]) | ord($this->data[$spos + 8*$i + 7])<<8;
							$lc 									=  	ord($this->data[$spos + 8*$i + 8]) | ord($this->data[$spos + 8*$i + 9])<<8;
							if ($lr - $fr > 0) {
								$this->sheets[$this->sn]['cellsInfo'][$fr+1][$fc+1]['rowspan'] = $lr - $fr + 1;
							}
							if ($lc - $fc > 0) {
								$this->sheets[$this->sn]['cellsInfo'][$fr+1][$fc+1]['colspan'] = $lc - $fc + 1;
							}
						}
                    	break;
                	case Spreadsheet_Excel_Reader_Type_RK:
                	case Spreadsheet_Excel_Reader_Type_RK2:
						$row 										= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
						$column 									= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
						$rknum 										= 	$this->_GetInt4d($this->data, $spos + 6);
						$numValue 									= 	$this->_GetIEEE754($rknum);
						if ($this->isDate($spos)) {
							list($string, $raw) 					= 	$this->createDate($numValue);
						}else{
							$raw = $numValue;
							if (isset($this->_columnsFormat[$column + 1])){
									$this->curformat 				= 	$this->_columnsFormat[$column + 1];
							}
							
							$string 								= 	sprintf($this->curformat, $numValue * $this->multiplier);
							if($this->_is_percent == TRUE) {
								$string		.=	"%";							
								$this->_is_percent = FALSE;
							}							
						}
                    	$this->addcell($row, $column, $string, $raw);
                    	break;
                	case Spreadsheet_Excel_Reader_Type_LABELSST:
                        $row        								= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
                        $column     								= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
                        $xfindex    								= 	ord($this->data[$spos+4]) | ord($this->data[$spos+5])<<8;
                        $index  									= 	$this->_GetInt4d($this->data, $spos + 6);
                        $this->addcell($row, $column, $this->sst[$index]);
                    	break;
                	case Spreadsheet_Excel_Reader_Type_MULRK:
						$row        								= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
						$colFirst   								= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
						$colLast    								= 	ord($this->data[$spos + $length - 2]) | ord($this->data[$spos + $length - 1])<<8;
						$columns    								= 	$colLast - $colFirst + 1;
						$tmppos 									= 	$spos+4;
                    	for ($i = 0; $i < $columns; $i++) {
                        	$numValue 								= 	$this->_GetIEEE754($this->_GetInt4d($this->data, $tmppos + 2));
                        	if ($this->isDate($tmppos-4)) {
                            	list($string, $raw) 				= 	$this->createDate($numValue);
                        	}else{
                            	$raw = $numValue;
                            	if (isset($this->_columnsFormat[$colFirst + $i + 1])){
									$this->curformat 				= 	$this->_columnsFormat[$colFirst + $i + 1];
                                }
                            	$string 							= 	sprintf($this->curformat, $numValue * $this->multiplier);
                        	}
                      		$tmppos 								+= 	6;
                      		$this->addcell($row, $colFirst + $i, $string, $raw);
                    	}
                   	 	break;
                	case Spreadsheet_Excel_Reader_Type_NUMBER:
                    	$row    									= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
                    	$column 									= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
                    	$tmp 										= 	unpack("ddouble", substr($this->data, $spos + 6, 8)); 
                    	if ($this->isDate($spos)) {
                        	list($string, $raw) 					= 	$this->createDate($tmp['double']);
                    	}else{
							if (isset($this->_columnsFormat[$column + 1])){
									$this->curformat 				= 	$this->_columnsFormat[$column + 1];
							}
							$raw 									= 	$this->createNumber($spos);
							$string 								= 	sprintf($this->curformat, $raw * $this->multiplier);
                    	}
                    	$this->addcell($row, $column, $string, $raw);
                    	break;
					case Spreadsheet_Excel_Reader_Type_FORMULA:
					case Spreadsheet_Excel_Reader_Type_FORMULA2:
						$row    									= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
						$column 									= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
						if ((ord($this->data[$spos+6])==0) && (ord($this->data[$spos+12])==255) && (ord($this->data[$spos+13])==255)) {
						} elseif ((ord($this->data[$spos+6])==1) && (ord($this->data[$spos+12])==255) && (ord($this->data[$spos+13])==255)) {
						} elseif ((ord($this->data[$spos+6])==2) && (ord($this->data[$spos+12])==255) && (ord($this->data[$spos+13])==255)) {
						} elseif ((ord($this->data[$spos+6])==3) && (ord($this->data[$spos+12])==255) && (ord($this->data[$spos+13])==255)) {
						} else {
	                    	$tmp 									= 	unpack("ddouble", substr($this->data, $spos + 6, 8)); 
	                    	if ($this->isDate($spos)) {
	                        	list($string, $raw) 				= 	$this->createDate($tmp['double']);
	                    	}else{
	                        	if (isset($this->_columnsFormat[$column + 1])){
	                                $this->curformat 				= 	$this->_columnsFormat[$column + 1];
	                        	}
	                        	$raw 								= 	$this->createNumber($spos);
								$string 							= 	sprintf($this->curformat, $raw * $this->multiplier);
	                    	}
	                    	$this->addcell($row, $column, $string, $raw);
						}
						break;                    
                	case Spreadsheet_Excel_Reader_Type_BOOLERR:
						$row    									= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
						$column 									= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
						$string 									= 	ord($this->data[$spos+6]);
						$this->addcell($row, $column, $string);
                    	break;
					case Spreadsheet_Excel_Reader_Type_ROW:
					case Spreadsheet_Excel_Reader_Type_DBCELL:
					case Spreadsheet_Excel_Reader_Type_MULBLANK:
						break;
					case Spreadsheet_Excel_Reader_Type_LABEL:
                    	$row    									= 	ord($this->data[$spos]) | ord($this->data[$spos+1])<<8;
                    	$column 									= 	ord($this->data[$spos+2]) | ord($this->data[$spos+3])<<8;
                    	$this->addcell($row, $column, substr($this->data, $spos + 8, ord($this->data[$spos + 6]) | ord($this->data[$spos + 7])<<8));
                    	break;
                	case Spreadsheet_Excel_Reader_Type_EOF:
						$cont = false;
						break;
                	default:
                    	break;
            	}
            	$spos += $length;
        	}
			if (!isset($this->sheets[$this->sn]['numRows']))
				 $this->sheets[$this->sn]['numRows'] 				= 	$this->sheets[$this->sn]['maxrow'];
			if (!isset($this->sheets[$this->sn]['numCols']))
				 $this->sheets[$this->sn]['numCols'] 				= 	$this->sheets[$this->sn]['maxcol'];
		}
		function isDate($spos){
			$xfindex = ord($this->data[$spos+4]) | ord($this->data[$spos+5]) << 8;
			if ($this->formatRecords['xfrecords'][$xfindex]['type'] == 'date') {
				$this->curformat 									= 	$this->formatRecords['xfrecords'][$xfindex]['format'];
				$this->rectype 										= 	'date';
				return true;
			} else {
				if ($this->formatRecords['xfrecords'][$xfindex]['type'] == 'number') {
					$this->curformat 								= 	$this->formatRecords['xfrecords'][$xfindex]['format'];
					$this->rectype 									= 	'number';
					if (($xfindex == 0x9) || ($xfindex == 0xa)){
						$this->multiplier 							= 	100;
					}
				}else{
					$this->curformat = $this->_defaultFormat;
					$this->rectype 									= 	'unknown';
				}
				return false;
			}
		}
		function createDate($numValue){
			if ($numValue > 1){
				$utcDays 											= 	$numValue - ($this->nineteenFour ? Spreadsheet_Excel_Reader_utcOffsetDays1904 : Spreadsheet_Excel_Reader_utcOffsetDays);
				$utcValue 											= 	round($utcDays * Spreadsheet_Excel_Reader_msInADay);
				$string 											= 	date ($this->curformat, $utcValue);
				$raw 												= 	$utcValue;
			}else{
				$raw 												= 	$numValue;
				$hours 												= 	floor($numValue * 24);
				$mins 												= 	floor($numValue * 24 * 60) - $hours * 60;
				$secs 												= 	floor($numValue * Spreadsheet_Excel_Reader_msInADay) - $hours * 60 * 60 - $mins * 60;
				$string 											= 	date ($this->curformat, mktime($hours, $mins, $secs));
			}
			return array($string, $raw);
		}
		function createNumber($spos){
			$rknumhigh 												= 	$this->_GetInt4d($this->data, $spos + 10);
			$rknumlow 												= 	$this->_GetInt4d($this->data, $spos + 6);
			$sign 													= 	($rknumhigh & 0x80000000) >> 31;
			$exp 													=  	($rknumhigh & 0x7ff00000) >> 20;
			$mantissa 												= 	(0x100000 | ($rknumhigh & 0x000fffff));
			$mantissalow1 											= 	($rknumlow & 0x80000000) >> 31;
			$mantissalow2 											= 	($rknumlow & 0x7fffffff);
			$value 													= 	$mantissa / pow( 2 , (20- ($exp - 1023)));
			if ($mantissalow1 != 0) $value += 1 / pow (2 , (21 - ($exp - 1023)));
			$value 													+= 	$mantissalow2 / pow (2 , (52 - ($exp - 1023)));
			if ($sign) {$value = -1 * $value;}
			return  $value;
		}
		function addcell($row, $col, $string, $raw = ''){
			$this->sheets[$this->sn]['maxrow'] 						= 	max($this->sheets[$this->sn]['maxrow'], $row + $this->_rowoffset);
			$this->sheets[$this->sn]['maxcol'] 						= 	max($this->sheets[$this->sn]['maxcol'], $col + $this->_coloffset);
			$this->sheets[$this->sn]['cells'][$row + $this->_rowoffset][$col + $this->_coloffset] = $string;
			if ($raw)
				$this->sheets[$this->sn]['cellsInfo'][$row + $this->_rowoffset][$col + $this->_coloffset]['raw'] = $raw;
			if (isset($this->rectype))
				$this->sheets[$this->sn]['cellsInfo'][$row + $this->_rowoffset][$col + $this->_coloffset]['type'] = $this->rectype;
		}
    	function _GetIEEE754($rknum){
			if (($rknum & 0x02) != 0) {
					$value 											= 	$rknum >> 2;
			} else {
				$sign 												= 	($rknum & 0x80000000) >> 31;
				$exp 												= 	($rknum & 0x7ff00000) >> 20;
				$mantissa 											= 	(0x100000 | ($rknum & 0x000ffffc));
				$value 												= 	$mantissa / pow( 2 , (20- ($exp - 1023)));
				if ($sign) {$value = -1 * $value;}
			}
			if (($rknum & 0x01) != 0) {
				//$value /= 100;
				$this->_is_percent = TRUE;
			}
			return $value;
		}
		function _encodeUTF16($string){
			$result = $string;
			if ($this->_defaultEncoding){
				switch ($this->_encoderFunction){
					case 'iconv' : 	$result = iconv('UTF-16LE', $this->_defaultEncoding, $string);
									break;
					case 'mb_convert_encoding' : 	$result 		= 	mb_convert_encoding($string, $this->_defaultEncoding, 'UTF-16LE' );
									break;
				}
			}
			return $result;
		}
		/*function _GetInt4d($data, $pos) {
			return ord($data[$pos]) | (ord($data[$pos+1]) << 8) | (ord($data[$pos+2]) << 16) | (ord($data[$pos+3]) << 24);
		}*/
		function _GetInt4d($data, $pos)
         {
                 // FIX: represent numbers correctly on 64-bit system
                 // http://sourceforge.net/tracker/index.php?func=detail&aid=1487372&group_id=99160&atid=623334
                 // Hacked by Andreas Rehm 2006 to ensure correct result of the <<24 block on 32 and 64bit systems
                 $_or_24 = ord($data[$pos + 3]);
                 if ($_or_24 >= 128) {
                         // negative number
                         $_ord_24 = -abs((256 - $_or_24) << 24);
                 } else {
                         $_ord_24 = ($_or_24 & 127) << 24;
                 }
                 return ord($data[$pos]) | (ord($data[$pos + 1]) << 8) | (ord($data[$pos + 2]) << 16) | $_ord_24;
         }
	}
	/**
	 * function for read the content from xls and save in the db
	 *
	 * @param  $file_path  //path of the xls file
	 * @param  $course_id 
	 */
	function read_excel_validate($file_path, $type="exam", $listid="", $courseid="") 
	{
		$ci = &get_instance();
		$ci->load->helper('remote_file_exists');
		
		if($type == 'quiz') {
			$ci->load->model("admin_quiz_model");
		} else {
			$ci->load->model("admin_exam_model");
		}
			
		$action = $file_path;
		if($action != "") {
			@end();	
		}
			
		$data = new Spreadsheet_Excel_Reader();
		
		$data->setOutputEncoding('CP1251');
		$data->read($action);
		error_reporting(E_ALL ^ E_NOTICE);
		
		$answerOption = 1;
		//$videoError = ' Videos does not exist for ';
		
		$q=0; $m=0;
/*		echo $data->sheets[0]['numRows'];die();
		if(count($data->sheets[0]['numRows']))
			redirect ($ci->config->item ('upload_exam'));*/
		$k=0;
		
		if($data->sheets[0]['numRows']==0){
			$ci->session->set_flashdata('msg', 'Xls is not in appropriate format');
			
			if($type == 'quiz'){
				$ci->admin_quiz_model->delete_quizlist ($listid);
				redirect ($ci->config->item ('upload_quiz').$courseid);
			} else {
				redirect ($ci->config->item ('upload_exam').$courseid);	
			}
			
		} else {
			
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) { 
				for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
					if($data->sheets[0]['numCols'] < 4){
						
						$newData =$data->sheets[0]['cells'][$i][$j];
						
						if($i==1 || $i==$m+6) {
							$answerOption = 1;
							$No=$k+1;
							if(empty($newData) && $j==1) {
								
								$error=1;
								$a = "Error in Question No ";
								$error_repeat = $No;
								$error_que .= $No.',';
								
								if($i == 1)
									$invalid = 1;
								if($i == 6)
									$invalid = 1+$invalid;
								
								if($i==11){
									if($invalid >= 2){
										$ci->session->set_flashdata('msg', 'Xls is not in appropriate format');
										if($type == 'quiz'){
											$ci->admin_quiz_model->delete_raw_quizlist ($listid);
											redirect ($ci->config->item ('upload_quiz').$courseid);
										} else {
											redirect ($ci->config->item ('upload_exam').$courseid);
										}
									}
								}
							}
							if((!empty($data->sheets[0]['cells'][$i][2])) || (!empty($data->sheets[0]['cells'][$i][3]))){
								return 'Error in  Question No ' . $k . ' or ' . $No . '. Either answer option or video is missing.';
							}
							
							if($j==$data->sheets[0]['numCols']) {
								$question = ++$k;
								$q = $i;
								$m = $q;
							}
							
							if($data->sheets[0]['numRows']-$i<4) {
								if(!$error) {
									$error=1;
									return 'Error in  Question No  ' .$k.' or '.$No;
								}
							}
						} else {
							//if(!empty($newData)){
							if($j==2) {
								
								// Check for video
								if($answerOption == 5) { 
									
									//validate vido, generate appropriate error message
									if(!empty($newData)){  
										// Validate video
										$remoteFileCheck = remote_file_exists(trim($newData));
										if(!$remoteFileCheck){ 
											$error = 1;
											if($error_repeat != $k && $error_ans != $k) {
												$error_ans = $k;
												$error_que .= " " . $k .",";
												$videoError .= " " . $k. ",";
											}
										}
									}
								} else {
									if(empty($newData)) {
										$error = 1;
										if($error_repeat != $k && $error_ans != $k) { 
											$error_ans = $k;
											$error_que .= " " . $k . ",";
											$answer_option_error .= " " . $k . ",";
										}
									}
								}
								
							} else if($j==3 ) {
								
								if($answerOption < 5) { 
									if(empty($newData)) {
										$error = 1;
	
										if($error_repeat!=$k && $error_ans!=$k) { 
											$error_ans = $k;
											$error_que .= " " . $k . ",";
											$answer_value_error .= " " . $k . ",";
										}
									} elseif(!(trim($newData)=='Y' || trim($newData)=='N' || trim($newData)=='n' || trim($newData)=='y')) {
										return 'Answer options not in correct format for Question' .$k;
									}
								}
								
								// Count answer option, if it is 5 then reset to 0
								if($answerOption == 5) {
									$answerOption = 1;
								} else {
									$answerOption++;	
								}
								 
							}
							//}
							
						}
					} else {
						return 'Inappropriate Format: Number of columns is not less than 4';
					}
				}
			} 
		}
		
		if(empty($a))
			$a = 'Error in Question No ';
		
		$error_data = trim($a . $error_que, ',');
		
		// Append answer option errors
		if($answer_option_error){
			$error_data .= '<br/>Question No. ' . trim($answer_option_error, ',') . ' having error in answer options.';
		}
		
		// Append answer value error
		if($answer_value_error){
			$error_data .= '<br/>Question No ' . trim($answer_value_error, ',') . ' having error in answer value.' ;
		}
		
		// Append video errors
		if($videoError){
			$error_data .= "<br/> Question No. " . trim($videoError, ',') . ' having invalid Video file name. Please check File Names with FTP folder.'; 
		}
		
		
		if($error) {
			return trim($error_data,',');
		} else { 	
			return false;
		}
	}

	/**
	 * function for read the content from xls and save in the db
	 *
	 * @param  $file_path  //path of the xls file
	 * @param  $course_id 
	 */
	 

	function fix($a) {
	
			$htmlin  = array("�", "�","�","�","�");
			$htmlout = array(" \" "," \" ","'","'","");
			return str_replace($htmlin, $htmlout, $a);
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $file_path
	 * @param int $course_id
	 * @param string $type
	 */	
	function read_excel($file_path, $course_id,$edition_id, $type = 'exam') 
	{
		// get ci instance	
		$ci = &get_instance();
		
		if($type == 'exam')
			$ci->load->model("admin_exam_model");
		elseif($type == 'quiz')
			$ci->load->model("admin_quiz_model");
		
		$action = $file_path;
		if($action != "") @end();
			
		$data =	new Spreadsheet_Excel_Reader();
		
		$data->setOutputEncoding('CP1251');
		$data->read($action);
		error_reporting(E_ALL ^ E_NOTICE);
		
		$q=0;$m=0;
		$answerOption = 1;
		$result = array('total' => 0, 'inserted' => 0, 'duplicates' => 0);
			
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				$newData =$data->sheets[0]['cells'][$i][$j];
				if($i==1 || $i==$m+6){
					if(!empty($newData) && $j==1){
                        $result['total'] = $result['total'] + 1;
						$answerOption = 1;
						//$newData = fix($newData);
						$ask = mb_detect_encoding($newData);
							
						//echo  $ask;
						//$newData = iconv("", "UTF-8", $newData);
						$newData = trim(fncReplaceQuotes($newData));//echo $newData."<br>";

						if($type == 'exam') {
                            $ques_id = $ci->admin_exam_model->saveXls_question($newData, $course_id, $edition_id);
                        }elseif($type == 'quiz') {
                            $ques_id = $ci->admin_quiz_model->saveXls_question($newData, $course_id, $edition_id);
                        }
                        if($ques_id > 0){$result['total']= $result['total']+1;}else{if($ques_id > 0){$result['duplicates']= $result['duplicates']+1;}}
							
					}
					
					if($j==$data->sheets[0]['numCols']){
						$q=$i;
						$m=$q;
					}
				} else { 
					if(!empty($newData)){ 
						if($j==2){ 
							if($answerOption == 5) {  
								// if not empty of video anda type == quiz then save records to table
								if(!empty($newData) && ($type == 'quiz')) {
									// save to admin_quiz_model
									$ci->admin_quiz_model->save_xls_question_vedio($ques_id, trim($newData));
									$answerOption = 1;
								}
							} else {
								//echo $newData."<br>";
								$newData = trim(fncReplaceQuotes($newData));
								//echo $newData."<br>";
								//$newData =fncSpecialchars2numeric(iconv("","UTF-8",$newData));
								// $newData =html_entity_decode($newData);
							 	//$newData =  htmlspecialchars(utf8_encode($newData));
								if($type=='exam')
									$ans_id=$ci->admin_exam_model->saveXls_ans($newData,$ques_id);
								elseif($type=='quiz')
									$ans_id=$ci->admin_quiz_model->saveXls_ans($newData,$ques_id);
							}
							
						} else if($j==3){ 
							if($answerOption < 5) {  
								// $newData = fncReplaceQuotes($newData);
								// $newData =html_entity_decode($newData);
							 	//$newData =  htmlspecialchars(utf8_encode($newData));
								if($type=='exam')
									$ans_id=$ci->admin_exam_model->updateXls_ans($newData,$ans_id);
								elseif($type=='quiz')
									$ans_id=$ci->admin_quiz_model->updateXls_ans($newData,$ans_id);
							}	
							// Count answer option, if it is 5 then reset to 0
							if($answerOption == 5) {
								$answerOption = 1;
							} else {
								$answerOption++;	
							}
						}
					}
					
				}
		
			}
	
		}

		return $result;
	
	
	}
	
	
	////////////////////////////////////////////////////////////////////////
	/**
	 * function for read the dictionary content from xls and save in the db
	 *
	 * @param  $file_path  //path of the xls file
	 * @param  $course_id 
	 */
	function read_dictionary_excel_validate($file_path,$listid="") {
		
		$ci = &get_instance();
		
		$ci->load->model("dictionary_model");
		
		$action		= 	$file_path;
		if($action != "") @end();
			
		$data 		= 	new Spreadsheet_Excel_Reader();
				
		$data->setOutputEncoding('CP1251');
		$data->read($action);
		//error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(0);
		$q=0;$m=0;
		
/*		echo $data->sheets[0]['numRows'];die();
		if(count($data->sheets[0]['numRows']))
			redirect ($ci->config->item ('upload_exam'));*/
		$k=0; 
		if($data->sheets[0]['numRows']==0){		
			$ci->session->set_flashdata('msg', 'Xls is not in appropriate format');	//errrorrrr							
			redirect ('dictionary/upload');
		}else{
			$invalid = 0;
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {			
				//for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				for ($j = 1; $j <= 1; $j++) {
					$newData =$data->sheets[0]['cells'][$i][$j];
					$newData1 =$data->sheets[0]['cells'][$i][$j+1];
					if(empty($newData) || empty($newData1)) {
						$invalid++;
					}
					if($invalid>=1){
						$ci->session->set_flashdata('msg', 'Xls is not in appropriate format');
						redirect ('dictionary/upload');
					}					
					
				}
			}
		}
		
		$error_data=$a.$error_que;
		if($error)
			return trim($error_data,',');
		else 	
			return false;
		
	}
	
	function read_excel_dictionary($file_path) {
		
		$ci = &get_instance();		
		$ci->load->model("dictionary_model");
		
		$action		= 	$file_path;
		if($action != "") @end();
			
		$data 		= 	new Spreadsheet_Excel_Reader();
		
		$data->setOutputEncoding('CP1251');
		$data->read($action);
		//error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(0);
		$q=0;$m=0;

		$dict_keys = $ci->dictionary_model->qry_s_get_dictionary_contents ();
		$query = 'INSERT INTO cc_dictionary (dct_keyword, dct_definition, dct_created_date, dct_updated_date) VALUES ';
		//$counts = 1;
		
		$duplicated_vals = '';
		$dupliacted_word = array();
		foreach($data->sheets[0]['cells'] as $key=>$value) {			 
			/*$newData['dct_keyword'] 		= trim(fncReplaceQuotes($value[1]));
			$newData['dct_definition'] 		= trim(fncReplaceQuotes($value[2]));
			$newData['dct_created_date'] 	= date('Y-m-d H:i:s');
			$newData['dct_updated_date'] 	= date('Y-m-d H:i:s');*/
			
			
			$full_array[] 		= trim(fncReplaceQuotes($value[1]));
			$org_array[trim(fncReplaceQuotes($value[1]))] 		= trim(fncReplaceQuotes($value[2]));
			
			/*if($counts<count($data->sheets[0]['cells']))
			{
			 $query      .= " ('".trim(mysql_escape_string(fncReplaceQuotes($value[1])))."','".trim(mysql_escape_string(fncReplaceQuotes($value[2])))."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."'), "; 
			} else {
				$query      .= " ('".trim(mysql_escape_string(fncReplaceQuotes($value[1])))."','".trim(mysql_escape_string(fncReplaceQuotes($value[2])))."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."') ";
			}
			$counts++;*/
			
			if(in_array(strtolower(trim(fncReplaceQuotes($value[1]))),array_map("strtolower",$dict_keys))) {
				$dupliacted_word[] = trim(fncReplaceQuotes($value[1]));				
			} 
			//$ques_id = $ci->dictionary_model->qry_i_saveXls_dictionary($query);
		}
		$unique_array		= array_unique($full_array);
		$duplicated_array 	= array_unique(array_diff_assoc($full_array,$unique_array));
		$inserted_words 	= array_unique(array_diff($unique_array,$dupliacted_word));
		$inserted_count 	= count($inserted_words);
		$duplCount 			= 1; 		
		$duplicated_vals 	= implode(', ',$duplicated_array);
		
		//$org_array 			=array_unique($org_array);
		
		if($duplicated_vals != '') {
			//$ci->session->set_flashdata('msg', 'The following entries already exist in the Xls. You must remove or rename the keywords and upload again '.$duplicated_vals.'.');
			$ci->session->set_flashdata('msg', 'Xls contains duplicated values.');
			redirect ('dictionary/upload');
		} else {
			if($inserted_count > 0){
				$counts = 1;
				foreach($inserted_words as $key=>$value) {			 
					if($counts < $inserted_count)
					{
					 	$query      .= " ('".trim(mysql_escape_string(fncReplaceQuotes($value)))."','".trim(mysql_escape_string(fncReplaceQuotes($org_array[$value])))."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."'), "; 
					} else {
						$query      .= " ('".trim(mysql_escape_string(fncReplaceQuotes($value)))."','".trim(mysql_escape_string(fncReplaceQuotes($org_array[$value])))."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."') ";
					}
					$counts++;
					
					if(in_array(trim(fncReplaceQuotes($value[1])),$dict_keys)) {
						$dupliacted_word[] = trim(fncReplaceQuotes($value[1]));				
					} 				
				}//echo $query;
				$ques_id = $ci->dictionary_model->qry_i_saveXls_dictionary($query);
			} else {		
				
				
				if(isset ($dupliacted_word) && count($dupliacted_word) > 0) {
					//$words = implode(' , ',$dupliacted_word);
					//$ci->session->set_flashdata('msg',"The following entries already exist in the dictionary. You must remove or rename the keywords and upload again. <br> $words.");
					$ci->session->set_flashdata('msg', 'Keywords already exist in the system.');
					redirect('dictionary/upload');
				}			
			}
		}
	}
	
	////////////////////////////////////////////////////////////////////
	
	
	///////////////////////////////////////////////////////////////////
	/**
	 * function for read the content from xls and save in the db
	 *
	 * @param  $file_path  //path of the xls file
	 * @param  $course_id 
	 */
	function read_question_excel_validate($file_path,$listid="") {
		
		$ci = &get_instance();
		
		$ci->load->model("questions_model");
		
		$action		= 	$file_path;
		if($action != "") @end();
			
		$data 		= 	new Spreadsheet_Excel_Reader();
		
		$data->setOutputEncoding('CP1251');
		$data->read($action);
		//error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(0);
		$q=0;$m=0;
		//echo $data->sheets[0]['numRows'];die();
/*		if(count($data->sheets[0]['numRows']))
			redirect ($ci->config->item ('upload_exam'));*/
		$k=0;
		if($data->sheets[0]['numRows'] == 0 || $data->sheets[0]['numCols'] == 0){		
			//$ci->session->set_flashdata('msg', 'Xls is not in appropriate format');								
			//redirect ($ci->config->item ('upload_exam'));
			$err_msg = 'Xls is not in appropriate format';
			return $err_msg;
		}else{	
			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {		
				for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
					$newData =$data->sheets[0]['cells'][$i][$j];
					if($i==1 || $i==$m+6){						
						if(empty($newData) && $j==1){
							
							$error=1;
							$No=$k+1;
							$a		="Error in question No ";
							$error_repeat=$No;
							$error_que	.=$No.', ';
							
							if($i==1)
								$invalid=1;
							if($i==7)
								$invalid=1+$invalid;
							if($i==13){
								if($invalid>=2){
									//$ci->session->set_flashdata('msg', 'Xls is not in appropriate format');								
									//redirect ($ci->config->item ('upload_exam'));
									$err_msg = 'Xls is not in appropriate format';
									return $err_msg;
								}
							}							
						}
						$arr_answers = array();
						for ($answ_i = 1;$answ_i <= 4; $answ_i++) {
							if($data->sheets[0]['cells'][$i+$answ_i][3] != '') {
								$arr_answers[] = $data->sheets[0]['cells'][$i+$answ_i][3];
							}
							else {
								$err_msg = 'Xls is not in appropriate format';
								return $err_msg;
							}	
						}
						if(is_array($arr_answers) && count($arr_answers) == 4) {
							$answers_arr = array_count_values($arr_answers);
							if(($answers_arr['Y'] != 1) || ($answers_arr['N'] != 3)) {
								$err_msg = 'Xls is not in appropriate format';
								return $err_msg;
							}
						} else {
							$err_msg = 'Xls is not in appropriate format';
							return $err_msg;
						}
						
						if($j==$data->sheets[0]['numCols']){
							$question=++$k;
							$q=$i;
							$m=$q;
						}
	
								
					}else{ 
						//if(!empty($newData)){
							if($j==2){
								if(empty($newData)){
									$error=1;
									
									if($error_repeat!=$k && $error_ans!=$k){
										
										$error_ans	=$k;
										$error_que	.=$k.", ";
									}
								
								
							}
							else if($j==3){
								if(empty($newData)){
									$error=1;
									
									if($error_repeat!=$k && $error_ans!=$k){
										
										$error_ans	=$k;
										$error_que	.=$k.",";
									}
								
								}
								
							
							}
						//}
						
						}
			
					}
				}
			}
		}
		$error_data=$a.$error_que;//echo $error_data;die();
		if($error)
			//return trim($error_data,', ');
			return 'Xls is not in appropriate format';
		else 	
			return false;
		
	}
	
	function read_question_excel($file_path,$course_id,$user_type) {
		$ci = &get_instance();
			$ci->load->model("questions_model");
		
		$action		= 	$file_path;
		if($action != "") @end();
			
		$data 		= 	new Spreadsheet_Excel_Reader();
		
		$data->setOutputEncoding('CP1251');
		$data->read($action);
		//error_reporting(E_ALL ^ E_NOTICE);
		error_reporting(0);
		$q=0;$m=0;


			
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				$newData =$data->sheets[0]['cells'][$i][$j];
				
				if($i==1 || $i==$m+6){
					$video_file = $data->sheets[0]['cells'][$i+5][$j+1]; 
					if(!empty($newData) && $j==1){
				
					//$newData = fix($newData);
						
						$ask = mb_detect_encoding($newData);
							
						//echo  $ask;
						  //$newData = iconv("", "UTF-8", $newData);
						$newData = trim(fncReplaceQuotes($newData));//echo $newData."<br>";
								$ques_id=$ci->questions_model->saveXls_question($newData,$video_file,$course_id,$user_type);
							
					}if($j==$data->sheets[0]['numCols']){
						$q=$i;
						$m=$q;
					}

							
				}else{ 
					if(!empty($newData)){
						if($j==2 && $i < ($m+5)){
					//echo $newData."<br>";
					$newData = trim(fncReplaceQuotes($newData));
						//echo $newData."<br>";
					//$newData =fncSpecialchars2numeric(iconv("","UTF-8",$newData));
							// $newData =html_entity_decode($newData);
						 //$newData =  htmlspecialchars(utf8_encode($newData));
								$ans_id=$ci->questions_model->saveXls_ans($newData,$ques_id);
							
						}
						else if($j==3 && $i < ($m+5)){
							// $newData = fncReplaceQuotes($newData);
							 // $newData =html_entity_decode($newData);
						 //$newData =  htmlspecialchars(utf8_encode($newData));
								$ans_id=$ci->questions_model->updateXls_ans($newData,$ans_id);
						
						}
					}
					
				}
		
			}
	
		}	
	
	}
	
	///////////////////////////////////////////////////////////////////
	
	
?>
