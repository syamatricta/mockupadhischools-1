<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	* Function to Compress Javascript
*/
function load_js_files ($js_files)
{  
   $ci = &get_instance();    
   //array_unshift($js_files);
  // $lang_js     =   $ci->session->userdata ('language_name')."_lang.js";
  // array_unshift($js_files,$lang_js);
   array_unshift($js_files);
   $js_files		=	array_unique($js_files);
   //$js_files[]	=	"prototype.js";
   //$js_files[]	=	"applicationvalidation.js";   
   $ci->lang->load ("javascript",$ci->session->userdata ('language_name'));
   $con_name = $ci->uri->segment (1);
   $fun_name = $ci->uri->segment (2);
   $js_file_path= $ci->config->item ('js_path');  
   $js_dest_file_path= $ci->config->item ('js_path_parsed');         
   $act_filename    =   'ma8ta3ee_'.$con_name.'_'.$fun_name."_".substr($ci->session->userdata ('language_name'),0,2).'.php';
   $filename = $js_dest_file_path.$act_filename;
  if (file_exists($filename) ) {
	  return $act_filename;
	 // unlink($filename);
	 // unlink($js_dest_file_path.'ma8ta3ee_'.$con_name.'_'.$fun_name.'.php');
  }  
  else 
  {	
	@unlink($filename);
   	  $file_header = '<?php if(!ob_start("ob_gzhandler")) ob_start();header("Content-type: text/javascript"); ?>';
	  file_put_contents($filename,$file_header,FILE_APPEND);
	  
      $file_header = '<?php header("Cache-Control: max-age=315360000,public"); ?>';
	  file_put_contents($filename,$file_header,FILE_APPEND);

      $date = date('D j M Y h:i:s', strtotime('10 years'));				
	  $file_header = '<?php header("Expires: '.$date.' GMT"); ?>';
	  file_put_contents($filename,$file_header,FILE_APPEND); 	  
	  
	  foreach ($js_files as $files )
	  {
		$file_to_open = $js_file_path.$files;			  
		$file_contents = file_get_contents($file_to_open,true);				 
		file_put_contents($filename,$file_contents,FILE_APPEND);
	  }  
	  file_put_contents($filename,"<?php ob_end_flush(); ?>",FILE_APPEND); 
 }
   return $act_filename;
} 

/**
	* Function to Compress admin Javascript
*/
function load_admin_js_files ($js_files)
{
   $ci = &get_instance();    
   array_unshift($js_files,"prototype.js","validation.js","common.js");
   $js_files		=	array_unique($js_files);
  
   $con_name = $ci->uri->segment (1);
   $fun_name = $ci->uri->segment (2);
   
   $js_file_path    = $ci->config->item ('js_path');  
   $js_dest_file_path   = $ci->config->item ('js_path_parsed');          
   
   $act_filename    =   'adhi_'.$con_name.'_'.$fun_name.'.php';
   $filename    =   $js_dest_file_path.$act_filename;

  
   if (file_exists($filename) ) //{
	 return $act_filename;
	 @unlink($filename);
	  //unlink($js_dest_file_path.'ma8ta3ee_'.$con_name.'_'.$fun_name.'.php');
   //} else {
	 $file_header = '<?php if(!ob_start("ob_gzhandler")) ob_start();?>';
	 file_put_contents($filename,$file_header,FILE_APPEND );
   
   	 $file_header = '<?php header("Content-type: text/javascript"); ?>';
	 file_put_contents($filename,$file_header,FILE_APPEND);
	    
      $file_header = '<?php header("Cache-Control: max-age=315360000,public"); ?>';
	  file_put_contents($filename,$file_header,FILE_APPEND);

      $date = date('D j M Y h:i:s', strtotime('10 years'));				
	  $file_header = '<?php header("Expires: '.$date.' GMT"); ?>';
	  file_put_contents($filename,$file_header,FILE_APPEND); 	  
	    
	    
	  foreach ($js_files as $files )
	  {
		$file_to_open = $js_file_path.$files;			  
		$file_contents = file_get_contents($file_to_open,true);				 
		file_put_contents($filename,$file_contents,FILE_APPEND);
	  }   
	  file_put_contents($filename,"<?php ob_end_flush(); ?>",FILE_APPEND); 	  
  //}
   return $act_filename;
} 
/**
	* Function to Compress Style Sheet Files	
*/
function load_css_files ($css_files)
{    
	//array_unshift($css_files,"");
	$css_files	=	array_unique($css_files);
	$ci = &get_instance();	     
	$con_name = $ci->uri->segment (1);
	$fun_name = $ci->uri->segment (2);
	$css_file_path= $ci->config->item ('css_path');  
	$css_dest_file_path= $ci->config->item ('css_path_parsed');          
	$filename = $css_dest_file_path.'adhi_'.$con_name.'_'.$fun_name.'.php';
	
	if (file_exists($filename)) //{
//		return 'ma8ta3ee_'.$con_name.'_'.$fun_n<?php ame.'.php';
		 unlink($filename);
//		// @unlink($css_dest_file_path.'ma8ta3ee_'.$con_name.'_'.$fun_name.'.php');
	//} else {		   
		//$file_header = '<?php if(!ob_start("ob_gzhandler")) ob_start(); define("BASEPATH","'.constant("BASEPATH").'"); ';
		//file_put_contents($filename,$file_header,FILE_APPEND );
		
		//$file_header = '<?php include_once("../../system/application/config/ma8ta3ee.php"); ';
		//file_put_contents($filename,$file_header,FILE_APPEND);

		$file_header = '<?php $image_url	=	\''.ssl_url_img().'\'?>';	
		file_put_contents($filename,$file_header,FILE_APPEND);
				
		$file_header = '<?php header("Content-type: text/css"); ?>';
		file_put_contents($filename,$file_header,FILE_APPEND);
			
        //$file_header = '<?php header("Cache-Control: max-age=315360000,public"); ';
		//file_put_contents($filename,$file_header,FILE_APPEND);

        //$date = date('D j M Y h:i:s', strtotime('10 years'));				
		//$file_header = '<?php header("Expires: '.$date.' GMT");';
		//file_put_contents($filename,$file_header,FILE_APPEND);        
		
		foreach ($css_files as $files )
		{
			$file_to_open = $css_file_path.$files;	
			$file_contents = file_get_contents($file_to_open,true);				 
			file_put_contents($filename,$file_contents,FILE_APPEND);
		}
		//file_put_contents($filename,"<?php ob_end_flush(); ",FILE_APPEND); 
	//}
	return 'adhi_'.$con_name.'_'.$fun_name.'.php';

}


	 function check_extension($upload_text_name) {	
	 			
		$CI     = &get_instance();
		$ext 	= get_extension ($upload_text_name); 
		if(!in_array($ext,$CI->config->item("image_extensions"))) {
			return false;
		}
		return true;
	}
	
	function get_extension($upload_text_name) {
		
		$name_array = explode(".",$_FILES[$upload_text_name]['name']);
		$ext        = $name_array[count($name_array)-1];
		return strtolower($ext);
	}
	
 	function store_uploaded($upload_text_name,$file_name,$upload_path,$cur_image = '') {
 		
		if(isset($_FILES[$upload_text_name]) && $_FILES[$upload_text_name]['error'] == 0 ) {
			if($cur_image != '') {
				$image =$cur_image;			
				if (file_exists($upload_path.$image)) {		
					@unlink($upload_path.$image);	
				}
			}
			if(!move_uploaded_file($_FILES[$upload_text_name]['tmp_name'], $upload_path.$file_name)) {
				  return false;
			}                
		}
		return true;
	}
	function formatDate($dDate){
		
		$dNewDate = strtotime($dDate);
		return date('m/d/Y',$dNewDate);
		
		} 
	function formatDate_search($dDate){
		
		$dNewDate = strtotime($dDate);
		return date('Y-m-d',$dNewDate);
		
		}	
	function convert_UTC_to_PST_datetime($datetime){
		$convertdatetime = date('Y-m-d H:i:s',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}	
	function convert_UTC_to_PST_date($datetime){
		$convertdatetime = date('Y-m-d',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}	
	function convert_UTC_to_PST_time($datetime){
		$convertdatetime = date('H:i:s',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}	
	function convert_UTC_to_PST_year($datetime){
		//$EndtimeUTS = strtotime(date('Y'));
		$convertdatetime = date('Y',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}
	function convert_UTC_to_PST_month($datetime){
		$convertdatetime = date('m',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}	
	function convert_UTC_to_PST_date_slash($datetime){
		$convertdatetime = date('m/d/Y',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}
	function convert_UTC_to_PST_date_slash_pdf($datetime){
		$convertdatetime = date('d/m/Y',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}	
	function convert_UTC_to_PST_timeonly(){	
		$covertime	=	time() - (8 * 60 * 60);
		return $covertime;
	
	}
        function convert_PST_to_UTC_timeonly($time){
		$covertime	=	$time + (8 * 60 * 60 );
		return $covertime;

	}
function fncReplaceQuotes($string) { 
	$search = array(
					chr(34),
					chr(174),
					chr(169),

				
					chr(191),
					chr(171),
					chr(187),
					
					chr(62),
					chr(60),
					chr(181),
					chr(183),
					chr(182),
					
					chr(177),
					chr(163),
					chr(167),
					chr(153),
					chr(165),
					chr(193),
					
					chr(192),
					chr(194),
					chr(197),
					chr(195),
					chr(196),
					chr(198),
					
					chr(199),
					chr(200),
					chr(202),
					chr(203),
					chr(205),
					chr(204),					
					chr(206),
					
					

					
					chr(210),
					chr(211),
					chr(209),
					chr(208),
					chr(201),
					chr(145),
					chr(146),
					chr(147),
					chr(148),
					chr(151),
					chr(150),
					chr(133),

					chr(212),
					chr(213),
					chr(214),
					chr(215),
					chr(216),
					chr(217),
					chr(218),
					chr(219),
					chr(220),
					chr(221),
					chr(222),
					chr(223),
					chr(224),
					chr(225),
					chr(226),
					chr(227),
					
					chr(228),
					chr(229),
					chr(230),
					chr(231),
					chr(232),
					chr(233),
					chr(234),
					chr(235),
					chr(236),
					chr(237),
					chr(238),
					chr(239),
					chr(240),
					chr(241),
					chr(242),
					chr(243),
					
					chr(244),
					chr(245),
					chr(246),
					chr(247),
					chr(248),
					chr(249),
					chr(250),
					chr(251),
					chr(252),
					chr(253),
					chr(254),
					chr(255),
					
					chr(244),
					chr(245),
					chr(246),
					chr(247),
					chr(248),
					chr(249),
					chr(250),
					chr(251),
					chr(252),
					chr(253),
					chr(254),
					chr(255),
					chr(160)
				
					
					
					

					
					);
 
 

$replace = array(
					'&#34;',
					'&#174;',
					'&#169;',
					
					
					'&#191;',
					'&#171;',
					'&#187;',
					
					
					
					'&#62;',
					'&#60;',
					'&#181;',
					'&#183;',
					'&#182;',
					
					'&#177;',
					'&#163;',
					'&#167;',
					'&#153;',
					'&#165;',
					'&#193;',
					
					'&#192;',
					'&#194;',
					'&#197;',
					'&#195;',
					'&#196;',
					'&#198;',
					
					'&#199;',
					'&#200;',
					'&#202;',
					'&#203;',
					'&#205;',
					'&#204;',					
					'&#206;',
					

					
					'&#210' ,
					'&#211' ,
					'&#209' ,
					'&#208' ,				
					'&#201' ,
					'&#8216' ,
					'&#8217' ,
					'&#8220' ,
					'&#8221' ,
					'&#8212' ,
					'&#8211' ,
					'&#8230' ,


					'&#212;',					
					'&#213;',
					'&#214;',					
					'&#215;',					
					'&#216;',
					'&#217;',
					'&#218;',					
					'&#219;',
					'&#220;',					
					'&#221;',					
					'&#222;',
					'&#223;',

					'&#224;',					
					'&#225;',
					'&#226;',					
					'&#227;',					
					'&#228;',
					'&#229;',
					'&#230;',					
					'&#231;',
					'&#232;',					
					'&#233;',					
					'&#234;',
					'&#235;',
					
					'&#236;',					
					'&#237;',
					'&#238;',					
					'&#239;',					
					'&#240;',
					'&#241;',
					'&#242;',					
					'&#243;',
					'&#244;',					
					'&#245;',					
					'&#246;',
					'&#247;',


					'&#248;',					
					'&#249;',
					'&#250;',					
					'&#251;',					
					'&#252;',
					'&#253;',
					'&#254;',					
					'&#255;',
					'&#8201;'
					
					
			
					

					);
    return str_replace($search, $replace, $string); 
} 

function fncSpecialchars2numeric($text){
		$text	=	charset_decode_utf_8($text);
		$to_ncr = array(
		//'�' =>	'&ldquo;',
		'�' => '&#161;',
		'�' => '&#162;',
		'�' => '&#163;',
		'�' => '&#164;',
		'�' => '&#165;',
		'�' => '&#166;',
		'�' => '&#167;',
		'�' => '&#168;',
		'�' => '&#169;',
		'�' => '&#170;',
		'�' => '&#171;',
		'�' => '&#172;',
		'�' => '&#174;',
		'�' => '&#175;',
		'�' => '&#176;',
		'�' => '&#177;',
		'�' => '&#178;',
		'�' => '&#179;',
		'�' => '&#180;',
		'�' => '&#181;',
		'�' => '&#182;',
		'�' => '&#183;',
		'�' => '&#184;',
		'�' => '&#185;',
		'�' => '&#186;',
		'�' => '&#187;',
		'�' => '&#188;',
		'�' => '&#189;',
		'�' => '&#190;',
		'�' => '&#191;',
		'�' => '&#192;',
		'�' => '&#193;',
		'�' => '&#194;',
		'�' => '&#195;',
		'�' => '&#196;',
		'�' => '&#197;',
		'�' => '&#198;',
		'�' => '&#199;',
		'�' => '&#200;',
		'�' => '&#201;',
		'�' => '&#202;',
		'�' => '&#203;',
		'�' => '&#204;',
		'�' => '&#205;',
		'�' => '&#206;',
		'�' => '&#207;',
		'�' => '&#208;',
		'�' => '&#209;',
		'�' => '&#210;',
		'�' => '&#211;',
		'�' => '&#212;',
		'�' => '&#213;',
		'�' => '&#214;',
		'�' => '&#215;',
		'�' => '&#216;',
		'�' => '&#217;',
		'�' => '&#218;',
		'�' => '&#219;',
		'�' => '&#220;',
		'�' => '&#221;',
		'�' => '&#222;',
		'�' => '&#223;',
		'�' => '&#224;',
		'�' => '&#225;',
		'�' => '&#226;',
		'�' => '&#227;',
		'�' => '&#228;',
		'�' => '&#229;',
		'�' => '&#230;',
		'�' => '&ccedil;',
		'�' => '&#231;',
		'�' => '&#232;',
		'�' => '&#233;',
		'�' => '&#234;',
		'�' => '&#235;',
		'�' => '&#236;',
		'�' => '&#237;',
		'�' => '&#238;',
		'�' => '&#239;',
		'�' => '&#240;',
		'�' => '&#241;',
		'�' => '&#242;',
		'�' => '&#243;',
		'�' => '&#244;',
		'�' => '&otilde;',
		'�' => '&#245;',
		'�' => '&#246;',
		'�' => '&#247;',
		'�' => '&#248;',
		'�' => '&#249;',
		'�' => '&#250;',
		'�' => '&#251;',
		'�' => '&#252;',
		'�' => '&#253;',
		'�' => '&#254;',
		'�' => '&#255;');
    
		foreach ($to_ncr as $entity => $ncr)
		$text = str_replace($entity, $ncr, $text);
		return $text; 
	} 


function charset_decode_utf_8 ($string) {
      /* Only do the slow convert if there are 8-bit characters */
    /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
    if (! ereg("[\200-\237]", $string) and ! ereg("[\241-\377]", $string))
        return $string;

    // decode three byte unicode characters
    $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/e",       
    "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",   
    $string);

    // decode two byte unicode characters
    $string = preg_replace("/([\300-\337])([\200-\277])/e",
    "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
    $string);

    return $string;
} 

function fncReplaceQuotes_reverese($string) { 
	
 //$replace =array('"', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '' );
 $replace = array('"',
'Ò',
'Ó',
'Ñ',
'Ð',
'É',
'‘',
'’',
'“',
'”',
'—',
'–',
'…',
'Ô',
'Õ',
'Ö',
'×',
'Ø',
'Ù',
'Ú',
'Û',
'Ü',
'Ý',
'Þ',
'ß',
'à',
'á',
'â',
'ã',
'ä',
'å',
'æ',
'ç',
'è',
'é',
'ê',
'ë',
'ì',
'í',
'î',
'ï',
'ð',
'ñ',
'ò',
'ó',
'ô',
'õ',
'ö',
'÷',
'ø',
'ù',
'ú',
'û',
'ü',
'ý',
'þ',
'ÿ','','®',

'©',
'>',
'<',
'µ',
'·',
'¶',
'±',
'£',
'§',
'™',
'¥',
'Á',
'À',
'Â',
'Å',
'Ã',
'Ä',
'Æ',
'Ç',
'È',
'Ê',
'Ë',
'Í',
'Ì',
'Î',

'¡',
'¿',
'«',
'»',
'&',
'¢'
);
$search =array(
					'&#34;',
					
					
					'&#210' ,
					'&#211' ,
					'&#209' ,
					'&#208' ,				
					'&#201' ,
					'&#8216' ,
					'&#8217' ,
					'&#8220' ,
					'&#8221' ,
					'&#8212' ,
					'&#8211' ,
					'&#8230' ,

					'&#212;',					
					'&#213;',
					'&#214;',					
					'&#215;',					
					'&#216;',
					'&#217;',
					'&#218;',					
					'&#219;',
					'&#220;',					
					'&#221;',					
					'&#222;',
					'&#223;',

					'&#224;',					
					'&#225;',
					'&#226;',					
					'&#227;',					
					'&#228;',
					'&#229;',
					'&#230;',					
					'&#231;',
					'&#232;',					
					'&#233;',					
					'&#234;',
					'&#235;',
					
					'&#236;',					
					'&#237;',
					'&#238;',					
					'&#239;',					
					'&#240;',
					'&#241;',
					'&#242;',					
					'&#243;',
					'&#244;',					
					'&#245;',					
					'&#246;',
					'&#247;',


					'&#248;',					
					'&#249;',
					'&#250;',					
					'&#251;',					
					'&#252;',
					'&#253;',
					'&#254;',					
					'&#255;',
					'&#8201;',
					'&#174;',
					
					'&#169;',
					
					'&#62;',
					'&#60;',
					'&#181;',
					'&#183;',
					'&#182;',
					
					'&#177;',
					'&#163;',
					'&#167;',
					'&#153;',
					'&#165;',
					'&#193;',
					
					'&#192;',
					'&#194;',
					'&#197;',
					'&#195;',
					'&#196;',
					'&#198;',
					
					'&#199;',
					'&#200;',
					'&#202;',
					'&#203;',
					'&#205;',
					'&#204;',
					
					'&#206;',
					
					'&#161;',
					'&#191;',
					'&#171;',
					'&#187;',
					'&#38;',
					'&#162;'
					
					
					
			
					

					);
 
    return str_replace($search, $replace, $string); 
} 

/**
 * function to encode a script by base64 encoding by passing script as string
 * @param string script
 *
 */
function fncEncodeJavascript($script){
	
	$CI     = &get_instance();
	$CI->load->plugin('javascriptpacker');
						
	$packer = new JavaScriptPacker($script, 'Normal', true, false);
	return $packer->pack();
	
}//EOF:fncEncodeJavascript

/**
 * function that is used to perform the same functionality of round() since its not working in PHP 5.2.9
 */
function fncCalculateFloat($number,$digit){
	
	$number = number_format($number,$digit);
			
	$fraction 	= abs($number) - floor(abs($number));
	if($fraction <= 0)
		$number = intval($number);		
			
	return $number;
}

/**
 * validates the uri segment
 */
function validate_segments($seg_no) {
    if($seg_no === FALSE)
        return TRUE;
        
    if (!is_numeric($seg_no) || intval($seg_no) < 0) { 
        return FALSE;
    }
    
    return TRUE;
}

if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}

if ( !function_exists('json_decode') ){
	function json_decode($json)
	{ 
	    // Author: walidator.info 2009
	    $comment = false;
	    $out = '$x=';
	   
	    for ($i=0; $i<strlen($json); $i++)
	    {
	        if (!$comment)
	        {
	            if ($json[$i] == '{')        $out .= ' array(';
	            else if ($json[$i] == '}')    $out .= ')';
	            else if ($json[$i] == ':')    $out .= '=>';
	            else                         $out .= $json[$i];           
	        }
	        else $out .= $json[$i];
	        if ($json[$i] == '"')    $comment = !$comment;
	    }
	    eval($out . ';');
	    return $x;
	} 
} 
   
    function image_resize($imgname,$upload_path,$width=100,$height=100)
	{
		$CI            				= &get_instance();
		$target_path 				= $upload_path;
		$Config 					= array();
		$Config['image_library'] 	= 'gd2';
		$Config['source_image'] 	= $target_path. basename($imgname);
		$Config['create_thumb'] 	= TRUE;
		$Config['maintain_ratio'] 	= TRUE;
		$Config['width'] 			= $width;
		$Config['height'] 			= $height;
		$Config['thumb_marker'] 	= '';
		$Config['new_image'] 		= $target_path.'thumbs/'.basename($imgname);
		
		$CI->load->library('image_lib', $Config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();
			
	}


/**
 *  function to get the meta data of a particular page
 */
 if (!function_exists('set_meta_data'))
{
	function set_meta_data ()
	{
		$CI             = &get_instance();
		
		$page_name		= array();
		
		($CI->uri->segment(1) ) ? $page_name[] = $CI->uri->segment(1) : '';
		
		($CI->uri->segment(2) ) ? $page_name[] = $CI->uri->segment(2) : '';
		
		if(!empty($page_name) && count($page_name) == 2 ) {
			$page_name_string = implode("_",$page_name);
		
		} else if (!empty($page_name) && count($page_name) == 1) {
			$page_name_string = $page_name[0];
		} else {
			$page_name_string = 'common_meta';
		}
			
		$CI->load->model ('admin_meta_data_model');  
		$page_meta_details 	= $CI->admin_meta_data_model->getMetaByTitle($page_name_string);
		
		if($page_meta_details !== FALSE){
			$data['page_title']  =  trim($page_meta_details->meta_page_title);
			$data['keyword']  	 =  trim($page_meta_details->meta_keyword);
			$data['description'] =  trim($page_meta_details->meta_description); 
			return $data;
		}/*else{
			$data['page_title']  =  "adhischools";
			$data['keyword']  	 =  "adhischools";
			$data['description'] =  "adhischools";
			return $data;
		}*/
	}
}
	
	if(!function_exists("mob_log_message")) {
	   function mob_log_message($action='',$msg='',$type='adhi')
		{	   					
			$ci		=	&get_instance();
			$today 		= 	date("Ymd");
			
			$type		=	$ci->session->userdata("USERID");
			$log_file	=	$ci->config->item('adhi_log_path')."log_{$type}_{$today}.txt";
			
			$pst_date	=	convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
	   		switch ($action) {
	   			case "start":
						$date		=	date('Y-m-d H:i:s');
						$history	=	"\n\n****************************************************************************************************\n";
						$history   .=	"-------		 LOGGED IN		------- \n";
						$history   .=	"UTC				$date 		 \n";
						$history   .=	"PST			  	  $pst_date 	\n";
						$history   .=	"BROWSER			".$_SERVER['HTTP_USER_AGENT']."  \n";
						$history   .=	"IP ADDRESS			".$ci->input->ip_address()." 	\n";
						
						$history   .=	"				$msg \n";
						$history	.=	"****************************************************************************************************\n";	
						break;
	   			case "msg":	   					
						$history   	=	"				$msg \n";
						$history   .=	"PST			$pst_date 	------- STARTS \n";						
						break;
	   			case "end":
						$date		=	date('Y-m-d H:i:s');
						$history	=	"****************************************************************************************************\n";
						$history	.=	"--------- LOGGED OUT	---------\n";
						$history	.=	"UTC				$date 		\n";
						$history   .=	"PST			      $pst_date 	\n";						
						$history   .=	"BROWSER			".$_SERVER['HTTP_USER_AGENT']." 	\n";
						$history   .=	"IP ADDRESS			".$ci->input->ip_address()." 	\n";
						
						$history	.=	"****************************************************************************************************\n\n";
						break;
	   		}
		   	file_put_contents($log_file,$history,FILE_APPEND);
	   }
   }
	
	/**
	 * set post values
	 *
	 * @param $field (feild name)
	 * @param $default (default value)
	 * @return set vale
	 */
	if(!function_exists('set_post_value')){
		function set_post_value($field = '', $default = ''){
			if ( ! isset($_POST[$field]))
			{
				return $default;
			}
	
			return $_POST[$field];
			
		}
	}
        
//create_image();
//print "<img src=image.png?".date("U").">";

function  create_image_sq($val,$svpath){
        $im = @imagecreate(7, 7) or die("Cannot Initialize new GD image stream");
         // $background_color = imagecolorallocate($im, 51, 153, 0);  // 339900
         // $background_color = imagecolorallocate($im, 102, 51, 0);  // 663300
           //$background_color = imagecolorallocate($im, 204, 0, 0);  // CC0000
        // $background_color = imagecolorallocate($im, 0, 0, 0);  //000000
         // $background_color = imagecolorallocate($im, 153, 0, 204);  // 9900CC
        //$background_color = imagecolorallocate($im, 204, 0, 153);  // CC0099
          //$background_color = imagecolorallocate($im, 255, 153, 0);  // FF9900
         //$background_color = imagecolorallocate($im, 102, 255, 102);  // 66FF66
          //$background_color = imagecolorallocate($im, 255, 255, 0);  // FFFF00
        //$background_color = imagecolorallocate($im, 0, 0, 255);  // 0000FF

       // $background_color = imagecolorallocate($im, 235, 193, 191);  // EBC1BF
               // $background_color = imagecolorallocate($im, 219, 222, 164);  // DBDEA4
              //  $background_color = imagecolorallocate($im, 168, 216, 232);  // A8D8E8
                //$background_color = imagecolorallocate($im, 181, 244, 154);  //   B5F49A
                //$background_color = imagecolorallocate($im, 226, 210, 137); //E2D289
               // $background_color = imagecolorallocate($im, 240, 254, 87); //F0FE57
        //$background_color = imagecolorallocate($im, 232, 226, 223); //E8E2DF
       // $background_color = imagecolorallocate($im, 248, 171, 147); //F8AB93
        //$background_color = imagecolorallocate($im, 182, 143, 255); //B68FFF
		$background_color = imagecolorallocate($im, 253, 182, 255); //FDB6FF

        imagepng($im,$svpath.$val.".png");
        imagedestroy($im);
}

function GetLatLong($postcode='',$myKey = ''){
	$URL = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($postcode)."&sensor=false";
     // $URL = "http://maps.google.co.uk/maps/geo?q=" .urlencode($postcode). "&key=".$myKey;
     // $handler	=	curl_init($URL); // change this url as per your need
      //$data		=	curl_exec($handler);
      $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		//curl_setopt($ch, CURLOPT_URL, 'https://www.carwebuk.com/CarweBVRRB2Bproxy/carwebvrrwebservice.asmx?op=strB2BGetVehicleByVRM');
		//curl_setopt($ch, CURLOPT_HEADER, 0); // Don’t return the header, just the html
		//curl_setopt($ch, CURLOPT_CAINFO, $ca); // Set the location of the CA-bundle
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return contents as a string
		//curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		$result = curl_exec($ch);
		//echo curl_error($ch);
		curl_close($ch);
                if($result){
                $data =json_decode($result);
                //$long = $data->Placemark[0]->Point->coordinates[0];
               // $lat = $data->Placemark[0]->Point->coordinates[1];
		$long = $data->results[0]->geometry->location->lng;
                $lat = $data->results[0]->geometry->location->lat;
      /*if($data){
        $data = json_decode($data[0]);
      //  $long = $data->Placemark[0]->Point->coordinates[0];
        //$lat = $data->Placemark[0]->Point->coordinates[1];exit();*/
        return array('Latitude'=>$lat,'Longitude'=>$long);
      }else return false;
}

function identifyDictionaryWords($question,$option1,$option2,$option3,$option4){

	$ci = &get_instance();
	$ci->load->model('dictionary_model');
	$arr_dictionary_words = $ci->dictionary_model->getDiictionaryWordsAndDef ();
	$dictionary 		  = $arr_dictionary_words;
	$replaced_sentence			= array();
	$arr_replace_contents		= array ();
	$arr_pattern_contents    	= array();
	$arr_replace_option1		= array ();
	$arr_pattern_option1    	= array();
	$arr_replace_option2		= array ();
	$arr_pattern_option2    	= array();
	$arr_replace_option3		= array ();
	$arr_pattern_option3    	= array();
	$arr_replace_option4		= array ();
	$arr_pattern_option4    	= array();
	$question_key				='';
	$option1_key				='';
	$option2_key				='';
	$option3_key				='';
	$option4_key				='';
	$question_content			= array();
	$question_arr				= array();
	$unique_arr					= array();
	$replacenew_arr				= array();


	$option1_content			= array();
	$uniqueoption1_arr			= array();
	$replaceop1_arr				= array();
	$rewriteop1_arr				= array();
	$replacenewop1_arr			= array();

	$option2_content			= array();
	$uniqueoption2_arr			= array();
	$replaceop2_arr				= array();
	$rewriteop2_arr				= array();
	$replacenewop2_arr			= array();

	$option3_content			= array();
	$uniqueoption3_arr			= array();
	$replaceop3_arr				= array();
	$rewriteop3_arr				= array();
	$replacenewop3_arr			= array();

	$option4_content			= array();
	$uniqueoption4_arr			= array();
	$replaceop4_arr				= array();
	$rewriteop4_arr				= array();
	$replacenewop4_arr			= array();
	$rewrite_op1_array			= array();
	$replace_op1_array			= array();
	$rewrite_q_array			= array();
	$replace_q_array			= array();
	$rewrite_op2_array			= array();
	$replace_op2_array			= array();
	$rewrite_op3_array			= array();
	$replace_op3_array			= array();
	$rewrite_op4_array			= array();
	$replace_op4_array			= array();
	$arr_rewrite_contents		= array();
	$arr_rewrite_content_replace= array();
	$arr_rewrite_option1		= array();
	$arr_rewrite_option1_replace= array();
	$arr_rewrite_option2		= array();
	$arr_rewrite_option2_replace= array();
	$arr_rewrite_option3		= array();
	$arr_rewrite_option3_replace= array();
	$arr_rewrite_option4		= array();
	$arr_rewrite_option4_replace= array();
	$flag_question				= 0;
	$flag_option1				= 0;
	$flag_option2				= 0;
	$flag_option3				= 0;
	$flag_option4				= 0;

/*	echo "<pre>";
	print_r($arr_dictionary_words);
	echo "</pre>";*/
	if (count($arr_dictionary_words) > 0) {
		$counts = 1;
		foreach ($arr_dictionary_words as $key=> $value) {
			$pattern =  "/\b".$key."\b/i";
			if(preg_match($pattern, $question)){
				//recieving all keywords matching to question -- Match List
				$question_content[] 	= 	$key;
				$counts++;
			}

			if(preg_match($pattern, $option1)){
				//recieving all keywords matching to $option1 -- Match List
				$option1_content[] = $key;
			}

			if(preg_match($pattern, $option2)){
				//recieving all keywords matching to $option2 -- Match List
				$option2_content[] = $key;
			}

			if(preg_match($pattern, $option3)){
				//recieving all keywords matching to $option3 -- Match List
				$option3_content[] = $key;

			}

			if(preg_match($pattern, $option4)){
				//recieving all keywords matching to $option2 -- Match List
				$option4_content[] = $key;
			}

		}
	}

	/************************Find Question Matches***********************************/
/*	echo "MATCH LIST<pre>";
	print_r($question_content);
	echo "-----------------</pre>";*/
	//echo "No of Occurance<br>---------------<br>";
	foreach($question_content as $qcontent){

		$key_con	=	explode(" ",$qcontent);
		$count 		= 	count($key_con);
		$lastwrod 	=	$key_con[$count-1];
		$firstword 	=	$key_con[0];
		for($i=1;$i<count($question_content);$i++){
			$chunk	=	explode(" ",$question_content[$i]);
			$chunkfirstword 	=	$chunk[0];
			//echo '--'.$chunkfirstword;
			$chunklastword		= 	$chunk[count($chunk)-1];
			//echo '=='.$chunklastword;
			if(strtolower($chunkfirstword) == strtolower($lastwrod) ){
				$unique_arr[]	=	 $qcontent.' '.create_string($chunk,'first');
			}
			if(strtolower($firstword) == strtolower($chunklastword)){
				$unique_arr[]	=	 create_string($chunk,'last').' '.$qcontent;
			}

		}
	}

/*	echo "OVERLAPPING COMBINATIONS<pre>";
	print_r($unique_arr);
	echo "-------------------</pre>";*/


	if(is_array($unique_arr) && count($unique_arr)>0){

			// Sorting overlapping combination by length
			usort($unique_arr,'sortByLength');

			foreach($unique_arr as $oarr){
				$pattern_o = "/".$oarr."/i";
				if(preg_match($pattern_o, $question)){
					$replace_arr[] = trim($oarr," ");
				}
			}

			foreach($question_content as $qcontent){
				$replace_arr[] = $qcontent;
			}


			$replace_arr	= array_unique($replace_arr);
			$replace_arr	=	array_values($replace_arr);

			$check_rewrite =explode(' ',$replace_arr[0]);

			$rewrite_txt					=	'1x1x';
			$rewrite_arr[]					= 	"/\b".$rewrite_txt."\b/i";
			$replacenew_arr[]				= 	$replace_arr[0];

			for($j=0;$j<count($replace_arr);$j++){

					if($j == 0){

								$questn_array	 =	array();
								foreach($question_content as $key1=> $value1) {
										$pattern1 = "/\b".$value1."\b/i";
										if(preg_match($pattern1, $replace_arr[0])){
											$questn_array[] = $value1;
										}
									}


									if(count($questn_array) >0)
									{
										foreach ($questn_array as $qkey){
											$head_key_arr	= explode(' ',$qkey);
											for($i=0;$i<count($head_key_arr);$i++){
												$head_key_arr[$i] = substr($head_key_arr[$i],0,1).'#@$$@#'.substr($head_key_arr[$i],1);
											}
											$head_key	= implode(' ',$head_key_arr);
											$question_key.= "<br><a>".$qkey." : </a>".'<span>'.$arr_dictionary_words[$qkey]."</span><br>" ;
										}
									}

								$arr_replace_contents[] = "<span title='".$question_key."' class='help' >".$rewrite_txt."</span>";
								$arr_pattern_contents[] =  "/\b".$replace_arr[0]."\b/i";
								$replaced_sentence['questions'] = preg_replace (array_unique($arr_pattern_contents),array_unique($arr_replace_contents), $question);


					}else{
						//echo "hiiiiiiiiiii";
						$count_string = 0;

						$not_affected	=	array();

						if(in_array($replace_arr[$j],$question_content)){
							$count_string = substr_count($question,$replace_arr[$j]);
							if($count_string >0 && 0 != strcmp ($replace_arr[$j],$replace_arr[0])  ){

								$affected_str	= 	"<span title='".$question_key."' class='help' >".$rewrite_txt."</span>";
								$not_affected	=	explode($affected_str,$replaced_sentence['questions']);

								if(count($not_affected) >0){
									for($k=0;$k<count($not_affected);$k++){
										$npattern = "/\b".$replace_arr[$j]."\b/i";
										if(preg_match($npattern, $not_affected[$k])){
											$question_nkey			= 	'<br><label>'.$replace_arr[$j].' : </label>'."<span>".$arr_dictionary_words[$replace_arr[$j]].'</span><br>' ;

											if( 0 == strcmp ($replace_arr[$j],'title')){
												$replace_q_array[]		=	'title';
												$rewrite_q_array[]		=	"/\b".$j.$k.'xtx'.$j.$k."\b/i";
												$n_r_txt				=	"<span ".$j.$k."xtx".$j.$k."='".$j.$k."xx".$j.$k."' class='help' >".$replace_arr[$j]."</span>";
											}
											else{
												$rewrite_q_array[]		=	'/\b'.$j.$k."xx".$j.$k.'\b/i';
												$replace_q_array[]		=	$question_nkey;
												$n_r_txt				=	"<span title='".$j.$k."xx".$j.$k."' class='help' >".$replace_arr[$j]."</span>";
												$n_p_txt				=	'/\b'.$replace_arr[$j].'\b/i';
												$not_affected[$k] 		= 	preg_replace ($n_p_txt,$n_r_txt,$not_affected[$k]);
											}



										}
									}

									$replaced_sentence['questions']	=	implode($affected_str,$not_affected);

								}


							}

						}

					}
	}
}else{

		$question_content	= 	array_unique($question_content);
		$question_content	=	array_values($question_content);
		foreach($question_content as $key1=> $value1) {
			$head_key = substr($value1,0,1).'#@$$@#'.substr($value1,1);
			$question_key = '<br><a>'.$value1.' : </a>'."<span>".$arr_dictionary_words[$value1].'</span><br>' ;
			$arr_replace_contents[] = "<span title='".$question_key."' class='help' >".$value1."</span>";
			$arr_pattern_contents[] =  '/\b'.$value1 .'\b/i';

			$arr_rewrite_contents[] = $key1.'xxx';
			$arr_rewrite_content_replace[] = '/\b'.$key1.'xxx\b/i';
			//$replaced_sentence['questions'] = preg_replace (array_unique($arr_pattern_contents),array_unique($arr_rewrite_contents), $question);
			$question = preg_replace (array_unique($arr_pattern_contents),array_unique($arr_rewrite_contents), $question);
		}
		$flag_question = 1;
		//$replaced_sentence['questions'] = preg_replace (array_unique($arr_pattern_contents),array_unique($arr_replace_contents), $question);

}
/************************End - Find Question Matches***********************************/

/*************************Find Option1 Matches ****************************************/

 foreach($option1_content as $op1content){

		$key_con	=	explode(" ",$op1content);
		$count 		= 	count($key_con);
		 $lastwrod 	=	$key_con[$count-1];
		$firstword 	=	$key_con[0];
		for($i=1;$i<count($option1_content);$i++){
			$chunk	=	explode(" ",$option1_content[$i]);
			$chunkfirstword 	=	$chunk[0];
		//	echo '--'.$chunkfirstword;
			$chunklastword		= 	$chunk[count($chunk)-1];
		//	echo '=='.$chunklastword;
			if(strtolower($chunkfirstword) == strtolower($lastwrod) ){
				$uniqueoption1_arr[]	=	 $op1content.' '.create_string($chunk,'first');
			}
			if(strtolower($firstword) == strtolower($chunklastword)){
				$uniqueoption1_arr[]	=	 create_string($chunk,'last').' '.$op1content;
			}

		}
	}
/*	print_r($option1_content);

	echo "OVERLAPPING COMBINATIONS OPTION1<pre>";
	print_r($uniqueoption1_arr);
	echo "-------------------</pre>";*/


	if(is_array($uniqueoption1_arr) && count($uniqueoption1_arr)>0){

			// Sorting overlapping combination by length
			usort($uniqueoption1_arr,'sortByLength');

			foreach($uniqueoption1_arr as $op1arr){
				$pattern_o1 = "/".$op1arr."/i";
				if(preg_match($pattern_o1, $option1)){
					$replaceop1_arr[] = trim($op1arr," ");
				}
			}

			foreach($option1_content as $op1arr){

				$replaceop1_arr[] = $op1arr;
			}

			$replaceop1_arr	= 	array_unique($replaceop1_arr);
			$replaceop1_arr	=	array_values($replaceop1_arr);

/*			echo "REPLACE ARRAY<pre>";
			print_r($replaceop1_arr);
			echo "-------------------</pre>";*/

			$rewrite_txt						=	"1x1x";
			$rewriteop1_arr[]					= 	'/\b'.$rewrite_txt.'\b/i';
			$replacenewop1_arr[]				= 	$replaceop1_arr[0];

			for($j=0;$j<count($replaceop1_arr);$j++){
				if($j == 0){
					$option1_array	 =	array();

					foreach($option1_content as $key1=> $value1) {
							$pattern1 = '/\b'.$value1.'\b/i';
							if(preg_match($pattern1, $replaceop1_arr[0])){
								$option1_array[] = $value1;
							}
						}

						if(count($option1_array) >0)
						{
							foreach ($option1_array as $op1key){
								$head_key_arr	= explode(' ',$op1key);
								for($i=0;$i<count($head_key_arr);$i++){
									$head_key_arr[$i] = substr($head_key_arr[$i],0,1).'#@$$@#'.substr($head_key_arr[$i],1);
								}
								$head_key	= implode(' ',$head_key_arr);
								$option1_key.= '<br><a>'.$op1key.' : </a>'."<span>".$arr_dictionary_words[$op1key].'</span><br>' ;
							}
						}

					$arr_replace_option1[] = "<span title='".$option1_key."' class='help' >".$rewrite_txt."</span>";
					$arr_pattern_option1[] =  '/\b'.$replaceop1_arr[0].'\b/i';
					$replaced_sentence['option1'] 	= preg_replace (array_unique($arr_pattern_option1),array_unique($arr_replace_option1), $option1);
		}else{


			$count_string = 0;

			$not_affected	=	array();

			if(in_array($replaceop1_arr[$j],$option1_content)){
				$count_string = substr_count($option1,$replaceop1_arr[$j]);
				if($count_string >0 && 0 != strcmp ($replaceop1_arr[$j],$replaceop1_arr[0])  ){

					$affected_str	= 	"<span title='".$option1_key."' class='help' >".$rewrite_txt."</span>";
					$not_affected	=	explode($affected_str,$replaced_sentence['option1']);

					if(count($not_affected) >0){
						for($k=0;$k<count($not_affected);$k++){
							//$npattern = "/".$replaceop1_arr[$j]."/";
							$npattern = '/\b'.$replaceop1_arr[$j].'\b/i';
							if(preg_match($npattern, $not_affected[$k])){
								$option1_nkey						= '<br><label>'.$replaceop1_arr[$j].' : </label>'."<span>".$arr_dictionary_words[$replaceop1_arr[$j]].'</span><br>' ;

								if( 0 == strcmp ($replaceop1_arr[$j],'title')){
									$replace_op1_array[]				=	"title";
									$rewrite_op1_array[]				=	'/\b'.$j.$k."xtx".$j.$k.'\b/i';
									$n_r_txt							=	"<span ".$j.$k."xtx".$j.$k."='".$j.$k."xx".$j.$k."' class='help' >".$replaceop1_arr[$j]."</span>";
								}
								else{
									$rewrite_op1_array[]				=	'/\b'.$j.$k."xx".$j.$k.'\b/i';
									$replace_op1_array[]				=	$option1_nkey;
									$n_r_txt							=	"<span title='".$j.$k."xx".$j.$k."' class='help' >".$replaceop1_arr[$j]."</span>";
									$n_p_txt							=	'/\b'.$replaceop1_arr[$j].'\b/i';
									$not_affected[$k] 					= 	preg_replace ($n_p_txt,$n_r_txt,$not_affected[$k]);
								}


								//echo "<br>----------".$not_affected[$k]."<br>";
							}
						}

						$replaced_sentence['option1']	=	implode($affected_str,$not_affected);

					}


				}

			}

		}
	}
}else{

			$option1_content	= 	array_unique($option1_content);
			$option1_content	=	array_values($option1_content);
			foreach($option1_content as $key1=> $value1) {
				$head_key = substr($value1,0,1).'#@$$@#'.substr($value1,1);
				$option1_key = "<br><a>".$value1." : </a>".'<span>'.$arr_dictionary_words[$value1]."</span><br>" ;
				$arr_replace_option1[] = "<span title='".$option1_key."' class='help' >".$value1."</span>";
				$arr_pattern_option1[] =  '/\b'.$value1 .'\b/i';

				$arr_rewrite_option1[] = $key1.'xxxopt1';
				$arr_rewrite_option1_replace[] = '/\b'.$key1.'xxxopt1\b/i';
				$option1 = preg_replace (array_unique($arr_pattern_option1),array_unique($arr_rewrite_option1), $option1);

			}
			$flag_option1 = 1;

}

/*************************End - Find Option1 Matches **********************************/

/*************************Find Option1 Matches ****************************************/

 foreach($option2_content as $op2content){

		$key_con	=	explode(" ",$op2content);
		$count 		= 	count($key_con);
		$lastwrod 	=	$key_con[$count-1];
		$firstword 	=	$key_con[0];
		for($i=1;$i<count($option2_content);$i++){
			$chunk	=	explode(" ",$option2_content[$i]);
			$chunkfirstword 	=	$chunk[0];
			//echo '--'.$chunkfirstword;
			$chunklastword		= 	$chunk[count($chunk)-1];
			//echo '=='.$chunklastword;
			if(strtolower($chunkfirstword) == strtolower($lastwrod) ){
				$uniqueoption2_arr[]	=	 $op2content.' '.create_string($chunk,'first');
			}
			if(strtolower($firstword) == strtolower($chunklastword)){
				$uniqueoption2_arr[]	=	 create_string($chunk,'last').' '.$op2content;
			}

		}
	}

/*	echo "OVERLAPPING COMBINATIONS<pre>";
	print_r($unique_arr);
	echo "-------------------</pre>";*/


	if(is_array($uniqueoption2_arr) && count($uniqueoption2_arr)>0){

			// Sorting overlapping combination by length
			usort($uniqueoption2_arr,'sortByLength');

			foreach($uniqueoption2_arr as $op2arr){
				$pattern_o2 = "/".$op2arr."/i";
				if(preg_match($pattern_o2, $option2)){
					$replaceop2_arr[] = trim($op2arr," ");
				}
			}

			foreach($option2_content as $op2arr){
				$replaceop2_arr[] = $op2arr;
			}

			$replaceop2_arr	= 	array_unique($replaceop2_arr);
			$replaceop2_arr	=	array_values($replaceop2_arr);
			$rewrite_txt						=	"1x1x";
			$rewriteop2_arr[]					= 	'/\b'.$rewrite_txt.'\b/i';
			$replacenewop2_arr[]				= 	$replaceop2_arr[0];

			for($j=0;$j<count($replaceop2_arr);$j++){
				if($j == 0){

					$option2_array	 =	array();
					foreach($option2_content as $key1=> $value1) {
							$pattern1 = '/\b'.$value1.'\b/i';
							if(preg_match($pattern1, $replaceop2_arr[0])){
								$option2_array[] = $value1;
							}
						}

						if(count($option2_array) >0)
						{
							foreach ($option2_array as $op1key){
								$head_key_arr	= explode(' ',$op1key);
								for($i=0;$i<count($head_key_arr);$i++){
									$head_key_arr[$i] = substr($head_key_arr[$i],0,1).'#@$$@#'.substr($head_key_arr[$i],1);
								}
								$head_key	= implode(' ',$head_key_arr);
								$option2_key.= '<br><a>'.$op1key.' : </a>'."<span>".$arr_dictionary_words[$op1key].'</span><br>' ;
								//$option2_key.= "<br><a>".$op1key." : </a>".'<span>'.$arr_dictionary_words[$op1key]."</span><br>" ;
							}
						}

					$arr_replace_option2[] = "<span title='".$option2_key."' class='help' >".$rewrite_txt."</span>";
					$arr_pattern_option2[] =  "/\b".$replaceop2_arr[0]."\b/i";
					$replaced_sentence['option2'] 	= preg_replace (array_unique($arr_pattern_option2),array_unique($arr_replace_option2), $option2);
		}else{

			$count_string = 0;
			$not_affected	=	array();


			if(in_array($replaceop2_arr[$j],$option2_content)){
				$count_string = substr_count($option2,$replaceop2_arr[$j]);
				if($count_string >0 && 0 != strcmp ($replaceop2_arr[$j],$replaceop2_arr[0])  ){

					$affected_str	= 	"<span title='".$option2_key."' class='help' >".$rewrite_txt."</span>";
					$not_affected	=	explode($affected_str,$replaced_sentence['option2']);

					if(count($not_affected) >0){
						for($k=0;$k<count($not_affected);$k++){
							$npattern = "/\b".$replaceop2_arr[$j]."\b/i";

							if(preg_match($npattern, $not_affected[$k])){
								$option2_nkey			= '<br><label>'.$replaceop2_arr[$j].' : </label>'."<span>".$arr_dictionary_words[$replaceop2_arr[$j]].'</span><br>' ;

								if( 0 == strcmp ($replaceop2_arr[$j],'title')){
									$replace_op2_array[]	=	"title";
									$rewrite_op2_array[]	=	'/\b'.$j.$k."xtx".$j.$k.'\b/i';
									$n_r_txt				=	"<span ".$j.$k."xtx".$j.$k."='".$j.$k."xx".$j.$k."' class='help' >".$replaceop2_arr[$j]."</span>";
								}else{
									$rewrite_op2_array[]	=	'/\b'.$j.$k."xx".$j.$k.'\b/i';
									$replace_op2_array[]	=	$option2_nkey;
									$n_r_txt				=	"<span title='".$j.$k."xx".$j.$k."' class='help' >".$replaceop2_arr[$j]."</span>";
									$n_p_txt				=	'/\b'.$replaceop2_arr[$j].'\b/i';
									$not_affected[$k] 		= 	preg_replace ($n_p_txt,$n_r_txt,$not_affected[$k]);
								}


							}
						}

						$replaced_sentence['option2']	=	implode($affected_str,$not_affected);

					}


				}

			}

		}
	}
}else{

		$option2_content	= 	array_unique($option2_content);
		$option2_content	=	array_values($option2_content);
		foreach($option2_content as $key1=> $value1) {
			$head_key = substr($value1,0,1).'#@$$@#'.substr($value1,1);
			$option2_key = '<br><a>'.$value1.' : </a>'."<span>".$arr_dictionary_words[$value1].'</span><br>' ;
			$arr_replace_option2[] = "<span title='".$option2_key."' class='help' >".$value1."</span>";
			$arr_pattern_option2[] =  "/\b".$value1 ."\b/i";

			$arr_rewrite_option2[] = $key1.'xxxopt2';
			$arr_rewrite_option2_replace[] = "/\b".$key1."xxxopt2\b/i";
			$option2 = preg_replace (array_unique($arr_pattern_option2),array_unique($arr_rewrite_option2), $option2);
		}
		$flag_option2 = 1;
}

/*************************End - Find Option2 Matches **********************************/

/*************************Find Option3 Matches ****************************************/

 foreach($option3_content as $op3content){

		$key_con	=	explode(" ",$op3content);
		$count 		= 	count($key_con);
		$lastwrod 	=	$key_con[$count-1];
		$firstword 	=	$key_con[0];
		for($i=1;$i<count($option3_content);$i++){
			$chunk	=	explode(" ",$option3_content[$i]);
			$chunkfirstword 	=	$chunk[0];
			//echo '--'.$chunkfirstword;
			$chunklastword		= 	$chunk[count($chunk)-1];
			//echo '=='.$chunklastword;
			if(strtolower($chunkfirstword) == strtolower($lastwrod) ){
				$uniqueoption3_arr[]	=	 $op3content.' '.create_string($chunk,'first');
			}
			if(strtolower($firstword) == strtolower($chunklastword)){
				$uniqueoption3_arr[]	=	 create_string($chunk,'last').' '.$op3content;
			}

		}
	}



	if(is_array($uniqueoption3_arr) && count($uniqueoption3_arr)>0){

			// Sorting overlapping combination by length
			usort($uniqueoption3_arr,'sortByLength');

			foreach($uniqueoption3_arr as $op3arr){
				$pattern_o3 = "/".$op3arr."/i";
				if(preg_match($pattern_o3, $option3)){
					$replaceop3_arr[] = trim($op3arr," ");
				}
			}

			foreach($option3_content as $op3arr){
				$replaceop3_arr[] = $op3arr;
			}

			$replaceop3_arr						= 	array_unique($replaceop3_arr);
			$replaceop3_arr						=	array_values($replaceop3_arr);
			$rewrite_txt						=	'1x1x';
			$rewriteop3_arr[]					= 	"/\b".$rewrite_txt."\b/i";
			$replacenewop3_arr[]				= 	$replaceop3_arr[0];

			for($j=0;$j<count($replaceop3_arr);$j++){
				if($j == 0){
					$option3_array	 =	array();
					foreach($option3_content as $key1=> $value1) {
							$pattern1 = "/\b".$value1."\b/i";
							if(preg_match($pattern1, $replaceop3_arr[0])){
								$option3_array[] = $value1;
							}
						}

						if(count($option3_array) >0)
						{
							foreach ($option3_array as $op1key){
								$head_key_arr	= explode(' ',$op1key);
								for($i=0;$i<count($head_key_arr);$i++){
									$head_key_arr[$i] = substr($head_key_arr[$i],0,1).'#@$$@#'.substr($head_key_arr[$i],1);
								}
								$head_key	= implode(' ',$head_key_arr);
								$option3_key.= '<br><a>'.$op1key.' : </a>'."<span>".$arr_dictionary_words[$op1key].'</span><br>' ;
							}
						}
					$arr_replace_option3[] = "<span title='".$option3_key."' class='help' >".$rewrite_txt."</span>";
					$arr_pattern_option3[] =  "/\b".$replaceop3_arr[0]."\b/i";
					$replaced_sentence['option3'] 	= preg_replace (array_unique($arr_pattern_option3),array_unique($arr_replace_option3), $option3);
		}else{

			$count_string = 0;
			$not_affected	=	array();

			if(in_array($replaceop3_arr[$j],$option3_content)){
				$count_string = substr_count($option3,$replaceop3_arr[$j]);
				if($count_string >0 && 0 != strcmp ($replaceop3_arr[$j],$replaceop3_arr[0])  ){

					$affected_str	= 	"<span title='".$option3_key."' class='help' >".$rewrite_txt."</span>";
					$not_affected	=	explode($affected_str,$replaced_sentence['option3']);

					if(count($not_affected) >0){
						for($k=0;$k<count($not_affected);$k++){

							$npattern = "/\b".$replaceop3_arr[$j]."\b/i";
							if(preg_match($npattern, $not_affected[$k])){


								if( 0 == strcmp ($replaceop3_arr[$j],'title')){
									$replace_op3_array[]	=	'title';
									$rewrite_op3_array[]	=	'/\b'.$j.$k."xtx".$j.$k.'\b/i';
									$n_r_txt				=	"<span ".$j.$k.'xtx'.$j.$k."='".$j.$k."xx".$j.$k."' class='help' >".$replaceop3_arr[$j]."</span>";
								}else{

									$option3_nkey			= '<br><label>'.$replaceop3_arr[$j].' : </label>'."<span>".$arr_dictionary_words[$replaceop3_arr[$j]].'</span><br>' ;
									$rewrite_op3_array[]	=	'/\b'.$j.$k."xx".$j.$k.'\b/i';
									$replace_op3_array[]	=	$option3_nkey;
									$n_r_txt				=	"<span title='".$j.$k."xx".$j.$k."' class='help' >".$replaceop3_arr[$j]."</span>";
									$n_p_txt				=	"/\b".$replaceop3_arr[$j]."\b/i";
									$not_affected[$k] 		= 	preg_replace ($n_p_txt,$n_r_txt,$not_affected[$k]);
								}

							}
						}

						$replaced_sentence['option3']	=	implode($affected_str,$not_affected);

					}


				}

			}
		}
	}
}else{

		$option3_content	= 	array_unique($option3_content);
		$option3_content	=	array_values($option3_content);
		foreach($option3_content as $key1=> $value1) {
			$head_key = substr($value1,0,1).'#@$$@#'.substr($value1,1);
			$option3_key = '<br><a>'.$value1.' : </a>'."<span>".$arr_dictionary_words[$value1].'</span><br>' ;
			$arr_replace_option3[] = "<span title='".$option3_key."' class='help' >".$value1."</span>";
			$arr_pattern_option3[] =  "/\b".$value1 ."\b/i";

			$arr_rewrite_option3[] = $key1.'xxxopt3';
			$arr_rewrite_option3_replace[] = "/\b".$key1."xxxopt3\b/i";
			$option3 = preg_replace (array_unique($arr_pattern_option3),array_unique($arr_rewrite_option3), $option3);
		}
		$flag_option3 = 1;

}

/*************************End - Find Option3 Matches **********************************/

/*************************Find Option4 Matches ****************************************/

 foreach($option4_content as $op4content){

		$key_con	=	explode(" ",$op4content);
		$count 		= 	count($key_con);
		$lastwrod 	=	$key_con[$count-1];
		$firstword 	=	$key_con[0];
		for($i=1;$i<count($option4_content);$i++){
			$chunk	=	explode(" ",$option4_content[$i]);
			$chunkfirstword 	=	$chunk[0];
			//echo '--'.$chunkfirstword;
			$chunklastword		= 	$chunk[count($chunk)-1];
			//echo '=='.$chunklastword;
			if(strtolower($chunkfirstword) == strtolower($lastwrod) ){
				$uniqueoption4_arr[]	=	 $op4content.' '.create_string($chunk,'first');
			}
			if(strtolower($firstword) == strtolower($chunklastword)){
				$uniqueoption4_arr[]	=	 create_string($chunk,'last').' '.$op4content;
			}

		}
	}

/*	echo "OVERLAPPING COMBINATIONS<pre>";
	print_r($unique_arr);
	echo "-------------------</pre>";*/


	if(is_array($uniqueoption4_arr) && count($uniqueoption4_arr)>0){

			// Sorting overlapping combination by length
			usort($uniqueoption4_arr,'sortByLength');

			foreach($uniqueoption4_arr as $op4arr){
				$pattern_o4 = "/".$op4arr."/i";
				if(preg_match($pattern_o4, $option4)){
					$replaceop4_arr[] = trim($op4arr," ");
				}
			}

			foreach($option4_content as $op4arr){
				$replaceop4_arr[] = $op4arr;
			}

			$replaceop4_arr						= 	array_unique($replaceop4_arr);
			$replaceop4_arr						=	array_values($replaceop4_arr);
			$rewrite_txt						=	'1x1x';
			$rewriteop4_arr[]					= 	"/\b".$rewrite_txt."\b/i";
			$replacenewop4_arr[]				= 	$replaceop4_arr[0];

			for($j=0;$j<count($replaceop4_arr);$j++){
				if($j == 0){
					$option4_array	 =	array();
					//print_r($option1_content);
					foreach($option4_content as $key1=> $value1) {
							$pattern1 = "/\b".$value1."\b/i";
							if(preg_match($pattern1, $replaceop4_arr[0])){
								$option4_array[] = $value1;
							}
						}

						if(count($option4_array) >0)
						{
							foreach ($option4_array as $op1key){
								$head_key_arr	= explode(' ',$op1key);
								for($i=0;$i<count($head_key_arr);$i++){
									$head_key_arr[$i] = substr($head_key_arr[$i],0,1).'#@$$@#'.substr($head_key_arr[$i],1);
								}
								$head_key	= implode(' ',$head_key_arr);
								$option4_key.= '<br><a>'.$op1key.' : </a>'."<span>".$arr_dictionary_words[$op1key].'</span><br>' ;
							}
						}

					$arr_replace_option4[] = "<span title='".$option4_key."' class='help' >".$rewrite_txt."</span>";
					$arr_pattern_option4[] =  "/\b".$replaceop4_arr[0]."\b/i";
					$replaced_sentence['option4'] 	= preg_replace (array_unique($arr_pattern_option4),array_unique($arr_replace_option4), $option4);
		}else{

			$count_string = 0;
			$not_affected	=	array();

			if(in_array($replaceop4_arr[$j],$option4_content)){
				$count_string = substr_count($option4,$replaceop4_arr[$j]);
				if($count_string >0 && 0 != strcmp ($replaceop4_arr[$j],$replaceop4_arr[0])  ){

					$affected_str	= 	'<span title="'.$option4_key.'" class="help" >'.$rewrite_txt.'</span>';
					$not_affected	=	explode($affected_str,$replaced_sentence['option4']);

					if(count($not_affected) >0){
						for($k=0;$k<count($not_affected);$k++){
							$npattern = "/\b".$replaceop4_arr[$j]."\b/i";

							if(preg_match($npattern, $not_affected[$k])){
								$option4_nkey			= '<br><label>'.$replaceop4_arr[$j].' : </label>'."<span>".$arr_dictionary_words[$replaceop4_arr[$j]].'</span><br>' ;

								if( 0 == strcmp ($replaceop4_arr[$j],'title')){
									$replace_op4_array[]	=	'title';
									$rewrite_op4_array[]	=	"/\b".$j.$k.'xtx'.$j.$k."\b/i";
									$n_r_txt				=	"<span ".$j.$k."xtx".$j.$k."='".$j.$k."xx".$j.$k."' class='help' >".$replaceop4_arr[$j]."</span>";

								}else{
									$rewrite_op4_array[]	=	'/\b'.$j.$k."xx".$j.$k.'\b/i';
									$replace_op4_array[]	=	$option4_nkey;
									$n_r_txt				=	"<span title='".$j.$k."xx".$j.$k."' class='help' >".$replaceop4_arr[$j]."</span>";
									$n_p_txt				=	"/\b".$replaceop4_arr[$j]."\b/i";
									$not_affected[$k] 		= 	preg_replace ($n_p_txt,$n_r_txt,$not_affected[$k]);
								}


							}
						}

						$replaced_sentence['option4']	=	implode($affected_str,$not_affected);

					}


				}

			}
		}
	}
}else{

		$option4_content	= 	array_unique($option4_content);
		$option4_content	=	array_values($option4_content);
		foreach($option4_content as $key1=> $value1) {
			$head_key = substr($value1,0,1).'#@$$@#'.substr($value1,1);
			$option4_key = '<br><a>'.$value1.' : </a>'."<span>".$arr_dictionary_words[$value1].'</span><br>' ;
			$arr_replace_option4[] = "<span title='".$option4_key."' class='help' >".$value1."</span>";
			$arr_pattern_option4[] =  "/\b".$value1 ."\b/i";

			$arr_rewrite_option4[] = $key1.'xxxopt4';
			$arr_rewrite_option4_replace[] = "/\b".$key1."xxxopt4\b/i";
			$option4 = preg_replace (array_unique($arr_pattern_option4),array_unique($arr_rewrite_option4), $option4);
		}
		$flag_option4 = 1;
}

/*************************End - Find Option3 Matches **********************************/

	if($flag_question == 1){
		$replaced_sentence['questions'] = preg_replace (array_unique($arr_rewrite_content_replace),array_unique($arr_replace_contents), $question );
	}

	if($flag_option1 == 1){
		$replaced_sentence['option1'] = preg_replace (array_unique($arr_rewrite_option1_replace),array_unique($arr_replace_option1), $option1 );
	}

	if($flag_option2 == 1){
		$replaced_sentence['option2'] = preg_replace (array_unique($arr_rewrite_option2_replace),array_unique($arr_replace_option2), $option2 );
	}

	if($flag_option3 == 1){
		$replaced_sentence['option3'] = preg_replace (array_unique($arr_rewrite_option3_replace),array_unique($arr_replace_option3), $option3 );
	}

	if($flag_option4 == 1){
		$replaced_sentence['option4'] = preg_replace (array_unique($arr_rewrite_option4_replace),array_unique($arr_replace_option4), $option4 );
	}


	if(is_array($replacenew_arr) && count($replacenew_arr)>0){
		$replaced_sentence['questions'] = preg_replace ($rewrite_arr,$replacenew_arr, $replaced_sentence['questions']);
	}

	if(is_array($replace_q_array) && count($replace_q_array)>0){
		$replaced_sentence['questions'] = preg_replace ($rewrite_q_array,$replace_q_array, $replaced_sentence['questions']);
	}

	//$replaced_sentence['option1'] 	= preg_replace (array_unique($arr_pattern_option1),array_unique($arr_replace_option1), $option1);
	if(is_array($replacenewop1_arr) && count($replacenewop1_arr)>0){
		$replaced_sentence['option1'] = preg_replace ($rewriteop1_arr,$replacenewop1_arr, $replaced_sentence['option1']);
	}

	if(is_array($replace_op1_array) && count($replace_op1_array)>0){
		$replaced_sentence['option1'] = preg_replace ($rewrite_op1_array,$replace_op1_array, $replaced_sentence['option1']);
	}

	//$replaced_sentence['option2'] 	= preg_replace (array_unique($arr_pattern_option2),array_unique($arr_replace_option2), $option2);
	if(is_array($replacenewop2_arr) && count($replacenewop2_arr)>0){
		$replaced_sentence['option2'] = preg_replace ($rewriteop2_arr,$replacenewop2_arr, $replaced_sentence['option2']);
	}
	if(is_array($replace_op2_array) && count($replace_op2_array)>0){
		$replaced_sentence['option2'] = preg_replace ($rewrite_op2_array,$replace_op2_array, $replaced_sentence['option2']);
	}
	//$replaced_sentence['option3'] 	= preg_replace (array_unique($arr_pattern_option3),array_unique($arr_replace_option3), $option3);
	if(is_array($replacenewop3_arr) && count($replacenewop3_arr)>0){
		$replaced_sentence['option3'] = preg_replace ($rewriteop3_arr,$replacenewop3_arr, $replaced_sentence['option3']);
	}

	if(is_array($replace_op3_array) && count($replace_op3_array)>0){
		$replaced_sentence['option3'] = preg_replace ($rewrite_op3_array,$replace_op3_array, $replaced_sentence['option3']);
	}
	//$replaced_sentence['option4'] 	= preg_replace (array_unique($arr_pattern_option4),array_unique($arr_replace_option4), $option4);
	if(is_array($replacenewop4_arr) && count($replacenewop4_arr)>0){
		$replaced_sentence['option4'] = preg_replace ($rewriteop4_arr,$replacenewop4_arr, $replaced_sentence['option4']);
	}


	if(is_array($replace_op4_array) && count($replace_op4_array)>0){
		$replaced_sentence['option4'] = preg_replace ($rewrite_op4_array,$replace_op4_array, $replaced_sentence['option4']);
	}
	return $replaced_sentence;

}
	function create_string($arr = array(),$pos= 'first'){
		//print_r($arr);
		$ret_str ='';
		$start 	=	($pos==	'first') ? 1 : 0;
		$end	=	($pos==	'first') ? count($arr) : count($arr)-1;
			for($i	=	$start; $i < $end;$i++){
				 $ret_str	.=	$arr[$i].' ';
			}
		return trim($ret_str);
	}
        function strposOffset($search, $string, $offset)
{
    /*** explode the string ***/
    $arr = explode($search, $string);
    /*** check the search is not out of bounds ***/
    switch( $offset )
    {
        case $offset == 0:
        return false;
        break;

        case $offset > max(array_keys($arr)):
        return false;
        break;

        default:
        return strlen(implode($search, array_slice($arr, 0, $offset)));
    }
}
function sortByLength($qarr,$b){
	  if($qarr == $b) return 0;
	  return (strlen($qarr) > strlen($b) ? -1 : 1);
}

function cutText($string, $length=100) {
    if($length<strlen($string)) {
        while ($string{$length} != ""){
           $length--;
        }
        return substr($string, 0, $length)."...";
    } else {
        return $string;
    }
}

function popup_box_top($id=''){
	$CI = &get_instance();
	
	$box_top = '<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
				<tr>
					<td align="left" valign="top" width="50" height="50" style="background:url('.$CI->config->item('images').'popup/popup_top_left.png) no-repeat left bottom;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" height="50" style="background:url('.$CI->config->item('images').'popup/popup_top_repeat.png) repeat-x bottom;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" width="50" height="50" style="background:url('.$CI->config->item('images').'popup/popup_top_right.png) no-repeat right bottom;">
						<a href="javascript:void(0);" id="popup_close" onclick="javascript:popup_close('.$id.'); return false;"><img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer" width="50" height="50"/></a>
					</td>
				</tr>
				<tr>
					<td align="left" width="50" style="background:url('.$CI->config->item('images').'popup/popup_left_repeat.png) repeat-y;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" style="background-color:#000">';

	return $box_top;
}

function popup_box_bottom(){
	$CI = &get_instance();
	$box_bottom = '	</td>
					<td align="left" width="50"  style="background:url('.$CI->config->item('images').'popup/popup_right_repeat.png) repeat-y;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" width="50" height="50" style="background:url('.$CI->config->item('images').'popup/popup_bottom_left.png) no-repeat left top;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" height="50" style="background:url('.$CI->config->item('images').'popup/popup_bottom_repeat.png) repeat-x top;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" width="50" height="50" style="background:url('.$CI->config->item('images').'popup/popup_bottom_right.png) no-repeat right top;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
				</tr>
			</table>';
	return $box_bottom;
}
function cal_popup_box_top($id=''){
	$CI = &get_instance();
        //Fix to show current day box 
        $datetime = date('Y-m-d H:i:s');
        $convertdatetime = date('d',strtotime($datetime.'-8 hour'));
        if($id == $convertdatetime) {
            $width = 100;
           
        } else {
            $width = 87;
        }
        
	$box_top = '<div style="float:left;width:'.$width.'%;border:2px solid #8C8C8C;background-color:#000 !important;">';


	return $box_top;
}
function cal_popup_box_bottom($cnt=0,$day=""){
	$CI = &get_instance();
        $ht=2;
        if($cnt >1){
           
                $ht +=($cnt-1)*14;
            
        }
        //Fix to show current day box 
        $datetime = date('Y-m-d H:i:s');
        $convertdatetime = date('d',strtotime($datetime.'-8 hour'));
        if($day == $convertdatetime) {
            $width = 0;
            /*if($day < 10) {
                $padding_left = 237;
            } else {
                $padding_left = 246;
            }*/   
            $padding_left = 237;
        } else {
            $width = 11;
            $padding_left = 217;
        }
        
	$box_bottom = '</div><div style="width:'.$width.'%;height:100%;position:absolute;top:'.$ht.'px;left:'.$padding_left.'px;"><img src="'.$CI->config->item('images').'Schedules-&-Locations_15.png'.'" border="0" alt="" align="right"/></div>';
	return $box_bottom;
}
function twtr_popup_box_top($id=''){
	$CI = &get_instance();

	$box_top = '<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left" >
				<tr>
					<td align="left" valign="bottom" width="50" height="50">
						<div style="width:45px;height:30px;border-left:solid 5px #6C6D6D;border-top:solid 5px #6C6D6D;background-color:#000000"></div>
					</td>
					<td align="left" valign="bottom" height="50">
						<div style="width:100%;height:30px;border-top:solid 5px #6C6D6D;background-color:#000000">&nbsp;</div>
					</td>
					<td align="left" valign="bottom" width="50" height="50" style="background-color:#000000">
						<a href="javascript:void(0);" id="popup_close" onclick="javascript:twtr_popup_close('.$id.'); return false;"><img src="'.$CI->config->item('images').'popup/popup_top_right.png'.'" border="0" alt="" width="50" height="50"/></a>
					</td>
				</tr>
				<tr>
					<td align="left" width="50" style="background:url('.$CI->config->item('images').'popup/popup_left_repeat.png) repeat-y;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt=""/>
					</td>
					<td align="left">';

	return $box_top;
}
function twtr_popup_box_bottom(){
	$CI = &get_instance();
	$box_bottom = '</td>
					<td align="left" width="50"  style="background:url('.$CI->config->item('images').'popup/popup_right_repeat.png) repeat-y;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt=""/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" width="50" height="50">
						<div style="width:45px;height:50px;border-left:solid 5px #6C6D6D;border-bottom:solid 5px #6C6D6D;background-color:#000000"></div>
					</td>
					<td align="left" valign="top" height="50">
						<div style="width:100%;height:50px;border-bottom:solid 5px #6C6D6D;background-color:#000000">&nbsp;</div>
					</td>
					<td align="left" valign="top" width="50" height="50">
						<div style="width:29px;height:50px;border-right:solid 5px #6C6D6D;border-bottom:solid 5px #6C6D6D;background-color:#000000"></div>
					</td>
				</tr>
			</table>';
	return $box_bottom;
}
function get_statename($id){
	$ci = &get_instance(); 
	$sql	=	"SELECT state from adhi_states where state_code ='".$id."'  ";
	$query	= 	$ci->db->query($sql);
				
			if($query->result())
				foreach ($query->result() as $row)
				{
				    return $row->state;
				}
			else 	
				return FALSE;
}
if( !function_exists('ago'))
{
	function ago($timestamp){  
		//$time = strtotime(gmdate("Y-m-d H:i:s"));
                $time = strtotime(gmdate("Y-m-d H:i:s").'+5 hour');
		$difference = $time - $timestamp;
		if($difference < 60) {
			$s = ($difference > 1 ) ? 's' : '';
			if($difference<=0){
				return "5 second$s ago";
			}else{
				return $difference." second$s ago";
			} 
		} else {
			$difference = round($difference / 60);
			if($difference < 60){
				$s = ($difference > 1 ) ? 's' : '';
				return $difference." minute$s ago";
			}else{
				$difference = round($difference / 60);
				if($difference < 24){
					$s = ($difference > 1 ) ? 's' : '';
					return $difference." hour$s ago";
				}else{
					$difference = round($difference / 24);
					if($difference < 7){
						$s = ($difference > 1 ) ? 's' : '';
						return $difference." day$s ago";
					}else{
						$difference = round($difference / 7);
						$s = ($difference > 1 ) ? 's' : '';
						return $difference." week$s ago";
					}
				}
			}
		}
	}
}



function disp_loggedin_username(){
	$ci = &get_instance();
	$userid = $ci->session->userdata('USERID');
	if($userid){
		$ci->db->select('firstname,lastname');
		$ci->db->from('adhi_user');
		$ci->db->where('id',$userid);
		$result = $ci->db->get();
		$res = $result->result_array();
		$username =  $res[0]['firstname']." ".$res[0]['lastname'];
		
		echo substr($username, 0, 50);;
		//echo substr($username,0,14);
	}else {
		echo '';
	}
}

function get_loggedin_username(){
	$ci = &get_instance();
	$userid = $ci->session->userdata('USERID');
	if($userid){
		$ci->db->select('firstname,lastname');
		$ci->db->from('adhi_user');
		$ci->db->where('id',$userid);
		$result = $ci->db->get();
		$res = $result->result_array();
		$username =  $res[0]['firstname']." ".$res[0]['lastname'];
		
		return $username;
		//echo substr($username,0,14);
	}else {
		echo '';
	}
}
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
// End of Helper
?>
