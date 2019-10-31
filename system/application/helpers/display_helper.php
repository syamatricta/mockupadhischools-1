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
   unlink($filename);
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
function load_admin_js_files ($js_files){
	$ci 			= &get_instance();    
	array_unshift($js_files,"prototype.js","validation.js","common.js", "email.js");
	$js_files		=	array_unique($js_files);
	
	$con_name		= $ci->uri->segment (1);
	$fun_name		= $ci->uri->segment (2);
	
	$js_file_path		= $ci->config->item ('js_path');  
	$js_dest_file_path  = $ci->config->item ('js_path_parsed');          
	
	$act_filename	= 'adhi_'.$con_name.'_'.$fun_name.'.js';
	$filename		= $js_dest_file_path.$act_filename;
  @unlink($filename);
	if (file_exists($filename) ){
		return $act_filename;
	}else{
		@unlink($filename);
		foreach ($js_files as $files ){
			$file_to_open	= $js_file_path.$files;			  
			$file_contents	= file_get_contents($file_to_open,true);				 
			file_put_contents($filename,$file_contents,FILE_APPEND);
		}
		
		$yui_minifier_path	= $ci->config->item('yuicompressor_path');
		$java_path			= $ci->config->item('java_path');
		exec($java_path.' -jar '.$yui_minifier_path.' '.$filename.' -o '.$filename);
		return $act_filename;
	}
	
} 
/**
	* Function to Compress Style Sheet Files	
*/
function load_css_files ($css_files){
	//array_unshift($css_files,"");
	$css_files	=	array_unique($css_files);
	
	$ci = &get_instance();	     
	$con_name = $ci->uri->segment (1);
	$fun_name = $ci->uri->segment (2);
	$css_file_path= $ci->config->item ('css_path');  
	$css_dest_file_path= $ci->config->item ('css_path_parsed');          
	$filename = $css_dest_file_path.'adhi_'.$con_name.'_'.$fun_name.'.php';
	
	@unlink($filename);
	if (file_exists($filename)){
		return 'adhi_'.$con_name.'_'.$fun_name.'.php';
	}else{
		 
		@unlink($filename);
		$file_header = '<?php $image_url	=	\''.ssl_url_img().'\'?>';	
		file_put_contents($filename,$file_header,FILE_APPEND);

		$file_header = '<?php if(!ob_start("ob_gzhandler")) ob_start();?>';
	 	file_put_contents($filename,$file_header,FILE_APPEND );
		
		$file_header = '<?php header("Content-type: text/css"); ?>';
		file_put_contents($filename,$file_header,FILE_APPEND);
		
		foreach ($css_files as $files ){
			$file_to_open = $css_file_path.$files;	
			$file_contents = file_get_contents($file_to_open,true);	
			
			// Remove comments
			$file_contents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $file_contents);
			 
			// Remove space after colons
			$file_contents = str_replace(': ', ':', $file_contents);
			 
			// Remove whitespace
			$file_contents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $file_contents);
			
				 
			file_put_contents($filename,$file_contents,FILE_APPEND);
		}
		file_put_contents($filename,"<?php ob_end_flush(); ",FILE_APPEND); 
		return 'adhi_'.$con_name.'_'.$fun_name.'.php';
	}
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
		   	@file_put_contents($log_file,$history,FILE_APPEND);
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
function todaycls_box_top($id=''){
	$CI = &get_instance();
	
	$box_top = '<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
				<tr>
					<td align="left" valign="top" width="50" height="50" class="popuptd1">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" height="50" class="popuptd2">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" width="50" height="50" class="popuptd3">
						<a href="javascript:void(0);" id="popup_close" onclick="javascript:popup_close('.$id.'); return false;"><img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer" width="50" height="50"/></a>
					</td>
				</tr>
				<tr>
					<td align="left" width="50" class="popuptd4">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" class="popuptd5">';

	return $box_top;
}
function todaycls_box_bottom(){
	$CI = &get_instance();
	$box_bottom = '	</td>
					<td align="left" width="50"  style="background:url('.$CI->config->item('images').'popup/popup_right_repeat.png) repeat-y;" class="popuptd6">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" width="50" height="50" class="popuptd7">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" height="50" class="popuptd8">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" width="50" height="50" class="popuptd9">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
				</tr>
			</table>';
	return $box_bottom;
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
function suppl_box_top($id=''){
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
						<a href="javascript:void(0);" id="popup_close" onclick="javascript:supple_close('.$id.'); return false;"><img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer" width="50" height="50"/></a>
					</td>
				</tr>
				<tr>
					<td align="left" width="50" style="background:url('.$CI->config->item('images').'popup/popup_left_repeat.png) repeat-y;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" style="background-color:#000">';

	return $box_top;
}
function red_popup_box_top($id=''){
	$CI = &get_instance();
	
	$box_top = '<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
				<tr>
					<td align="left" valign="top" width="50" height="50" style="background:url('.$CI->config->item('images').'popup/popup_top_left.png) no-repeat left bottom;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" height="50" style="background:url('.$CI->config->item('images').'popup/popup_top_repeat.png) repeat-x bottom;">
						<img src="'.$CI->config->item('images').'spacer.gif'.'" border="0" alt="spacer"/>
					</td>
					<td align="left" valign="top" width="50" height="50" style="background:url('.$CI->config->item('images').'popup/red_popup_top_right.png) no-repeat right bottom;">
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
function get_editions($course_id){
	$ci = &get_instance();
	$ci->load->model('common_model');
	$editions = array();
	$editions = $ci->common_model->select ('adhi_edition_summary','id,edition_no',array('course_id'=>$course_id));
	return $editions;
}
function getDefaultEdition($course_id){
	$ci = &get_instance();
	$ci->load->model('common_model');
	$editions = array();
	$editions = $ci->common_model->getDefaultEdition ($course_id);
	return $editions;
}
function get_user_edition($course_id,$user_id){
	$ci = &get_instance();
	$ci->load->model('common_model');
	$edition = array();
	$edition = $ci->common_model->select ('adhi_user_course','edition',array('courseid'=>$course_id,'userid'=>$user_id));
	return $edition[0]['edition'];
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
function getBrowser($u_agent='')
{
	if('' == $u_agent){
    	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	}
    
    $browser = getBrowserDetails($u_agent);
    return $browser;
}

function getBrowserDetails($u_agent ='')
{
    $browser = '';
    $platform = '';
    $version= "";
    $ub = ""; 
    $platform_version = 'unknown';

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }
  
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $browser = 'Internet Explorer';
        $ub = "MSIE"; 
    }
    elseif((preg_match('/Firefox/i',$u_agent)) )
    {
        $browser = 'Mozilla Firefox';
        $ub = "Firefox"; 
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $browser = 'Google Chrome';
        $ub = "Chrome"; 
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $browser = 'Apple Safari';
        $ub = "Safari"; 
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $browser = 'Opera';
        $ub = "Opera"; 
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $browser = 'Netscape';
        $ub = "Netscape"; 
    }
    elseif((preg_match('/Mozilla/i',$u_agent)))
    {
        $browser = 'Mozilla Firefox';
        $ub = "Mozilla"; 
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
    
    //Get platform version
    $oses   = array(
        'Win311' => 'Win16',
        'Win95' => '(Windows 95)|(Win95)|(Windows_95)',
        'WinME' => '(Windows 98)|(Win 9x 4.90)|(Windows ME)',
        'Win98' => '(Windows 98)|(Win98)',
        'Win2000' => '(Windows NT 5.0)|(Windows 2000)',
        'WinXP' => '(Windows NT 5.1)|(Windows XP)',
        'WinServer2003' => '(Windows NT 5.2)',
        'WinVista' => '(Windows NT 6.0)',
        'Windows 7' => '(Windows NT 6.1)',
        'Windows 8' => '(Windows NT 6.2)',
        'WinNT' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'OpenBSD' => 'OpenBSD',
        'SunOS' => 'SunOS',
        'Ubuntu' => 'Ubuntu',
        'Android' => 'Android',
        'Linux' => '(Linux)|(X11)',
        'iPhone' => 'iPhone',
        'iPad' => 'iPad',
        'MacOS' => '(Mac_PowerPC)|(Macintosh)',
        'QNX' => 'QNX',
        'BeOS' => 'BeOS',
        'OS2' => 'OS/2',
        'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
    );
    
    $uagent = strtolower($u_agent);
    $status = 0;
   
    if(!empty($oses)){
     foreach ($oses as $os => $patterns){
         if ((@preg_match('/'.$patterns . '/i', $uagent)) && ($status == 0 )){
         //if (strpos($uagent, $patterns) !== false)
            $platform_version =  $os;
            $status = 1;
         }
     }
    }
   
    $data =  array(
        'userAgent' => $u_agent,
        'browser'   => $browser,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern,
        'platform_version'   => $platform_version
    );
    
    return (object) $data;
}

/**
 * Get time duration as hr:min:sec
 *
 * @param int $seconds seconds
 * @return string
 */
function format_duration($seconds){
	$hours				= 0;
	$minutes			= 0;
	$duration_string	= '';
	if($seconds >= 60){
		$minutes	= floor($seconds / 60);
		if($minutes >= 60){
			$hours		= floor($minutes / 60);
			$minutes	= $minutes % 60;			
		}
		$seconds	= $seconds % 60;
	}
	if($hours > 0){
		$duration_string	.= $hours.' hr ';
	}
	if($minutes > 0){
		$duration_string	.= $minutes.' min ';
	}
	if($seconds > 0){
		$duration_string	.= $seconds.' sec';
	}
	return $duration_string;	
}
function filter_content($content){
	$email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
	return preg_replace_callback($email_pattern, "antispambot", $content);
}
function antispambot($matches){
    //return '<span class="codedirection">'.strrev($matches[0]).'</span>';    
    $tld 	= array("com", "org", "net", "ws", "info", "co.uk", "org.uk", "gov.uk", "ac.uk");
    $email	= split_email($matches[0]);
    $key	=  array_search($email['tale'], $tld);
    return '<script>mail("'.$email['user'].'","'.$email['domain'].'", '.$key.' ,"")</script>';    
}

function split_email($email){
	$split			= explode("@", $email);
	$arr['user']	= $split[0];
	$domain			= explode(".", $split[1]);
	$arr['domain']	= $domain[0];
	$arr['tale']	= $domain[1];
   	return $arr;
}
/**
 * Get config value from key
 *
 * @param string $config_key
 * @return string
 */
if( !function_exists('c')){
	function c($config_key){
		$ci = &get_instance();
		return $ci->config->item($config_key);
	}
}

function getSupplement($course_id,$edition){
	$ci = &get_instance();
	$ci->load->model('common_model');
	$editions = array();
	$editions = $ci->common_model->getSupplement ($course_id,$edition);
	return $editions;
}

function file_upload($types = 'pdf', $file_name, $upload_path) {
	$ci = &get_instance();
	$config ['upload_path']		= $upload_path;
	$config ['allowed_types']	= $types;
	//$config ['encrypt_name']	= TRUE;
	
	$name_array = explode ( ".", $_FILES[$file_name]['name']);
	$ext 		= $name_array [count ( $name_array ) - 1];
	$config ['file_name']		= uniqid().'.'.strtolower($ext);
	
	//$config ['max_size']		= '2048';
	
	/*$name_array = explode ( ".", $file_name);
		$ext = $name_array [count ( $name_array ) - 1];
		return strtolower ( $ext );*/
		
	//$ci->load->library('upload', $config);
	$ci->upload->initialize($config);
	if (! $ci->upload->do_upload ($file_name)) {
		return array ('error' => $ci->upload->display_errors ());
	} else {
		return	$ci->upload->data();
	}
}


function supplementFileName($course_name, $edition_no, $title, $ext = '.pdf'){
	$string	= $course_name.' '.$edition_no.' '.$title;
	return preg_replace('/[^a-z0-9]+/i', '_', $string).$ext;
}

function icon_class($string){
    return str_replace( ' ', '_', strtolower($string));
}

function google_tracking_code(){    
    $ci = &get_instance();
    return $ci->load->view('_google_tracking_code', array(), TRUE);
}

function is_users_first_visit(){
    $ci = &get_instance();
    $ip = $ci->input->ip_address();
    $ci->load->model('common_model');
    $result = $ci->common_model->valueExists('adhi_ip_visit','ip_id',array('ip' => $ip),array());
    $date = convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));

    if(!$result){
        $data = array('ip' => $ip,'ip_created_date' => $date);
        $ci->common_model->save('adhi_ip_visit',$data);
        return true;
    } else{
        $data = array('ip_updated_date' => $date);
        $data_where = array('ip_id' => $result);
        $ci->common_model->update('adhi_ip_visit',$data,$data_where);
        return false;
    }
   
}

function num_captcha_generate($index = ''){
    $number1 = rand(1, 10);
    $number2 = rand(1, 10);
    $ci = &get_instance();
    $session_data 	= array ( 'ad_catcha_answer'.$index => ($number1 + $number2));
    $ci->session->set_userdata ($session_data);
    return $number1 . ' + '. $number2;
}
function num_captcha_validate($answer, $index = ''){
    if(empty($answer)){ return false;}
    $ci = &get_instance();
    return ( $ci->session->userdata('ad_catcha_answer'.$index) == $answer ) ? true : false; 
}
if (!function_exists('find_date_diff')) {
    function find_date_diff ($date1, $date2) {
      $date1 = date('Y-m-d', strtotime($date1));
      $date2 = date('Y-m-d', strtotime($date2));
      $checkdate1 = strtotime($date1);
      $checkdate2 = strtotime($date2);
      $dateDiff = $checkdate1 - $checkdate2;
      $fullDays = floor($dateDiff / (60 * 60 * 24));
      return $fullDays;
    }

  }
  
  /* Reskin inner page heading */
  function page_heading($title = '', $page_head_class = '', $showname = true, $show_section = true){
      $name = '';
      $mobile_username_part = '';
      if($showname){
        $ci = &get_instance();
        if($ci->session->userdata('USER_NAME')){
            $name = '<i class="fa fa-user"> </i> '.$ci->session->userdata('USER_NAME').' '.$ci->session->userdata('LAST_NAME');
            $mobile_username_part   = '<div class="mob_username hidden-sm visible-xs part2">'. $name.'</div>';
        }
      }
      $content  = ($show_section) ? '<section class="page_head '.$page_head_class.'">' : '';
      $content  .= '<div class="row title">
                        <div class="container">'.$mobile_username_part.'<h1 class="float_title">'.$title.'</h1></div>
                        <div class="col-sm-5 part1">&nbsp;</div>
                        <div class="col-sm-6 hidden-xs part2">'. $name.'</div>
                        <div class="col-sm-1 hidden-xs"></div>	 
                    </div>';
      $content  .= ($show_section) ? '</section>' : '';
      echo $content;
  }
  
if( !function_exists('s')){
    function s($key){
        $ci = &get_instance();
        return $ci->session->userdata($key);
    }
}

if ( ! function_exists('set_checkbox_ext'))
{
	function set_checkbox_ext($field, $value = '', $check_value)
	{		
            if((!isset($_POST[$field]) && $value == $check_value)
                    ||
                (isset($_POST[$field]) && $_POST[$field] == $check_value)    
                    ){
                return ' checked="checked"';
            }

	}
}


if ( ! function_exists('select_selected_ext'))
{
	function select_selected_ext($field, $value = '', $check_value)
	{		
            if((!isset($_POST[$field]) && $value == $check_value)
                    ||
                (isset($_POST[$field]) && $_POST[$field] == $check_value)    
                    ){
                return ' selected="selected"';
            }

	}
}

if (!function_exists('loginto_continue_msg')) {
    function loginto_continue_msg($msg = 'Please login to continue', $page = '/'){
        $ci = &get_instance();
        $ci->session->set_flashdata('login_continue_message', $msg);
        redirect($page);
    }
}
if (!function_exists('generate_unique_key')) {

    function generate_unique_key($str = null, $limit = 10) {
        return substr(md5(time() . $str), 1, $limit);
    }
}


if(!function_exists('showMessage')){
	function showMessage (){
		$CI 			= &get_instance();
		$error_message		= (isset($CI->message['error']) && '' != $CI->message['error']) ? $CI->message['error'] : $CI->session->flashdata ('error');
		$success_message	= (isset($CI->message['success']) && '' != $CI->message['success']) ? $CI->message['success'] : $CI->session->flashdata ('success');
		$validation_errors      = (function_exists('validation_errors')) ? validation_errors() : '';
		$error_message          = ('' != $error_message) ? $error_message : $validation_errors;
		$info_message		= (isset($CI->message['info']) && '' != $CI->message['info']) ? $CI->message['info'] : $CI->session->flashdata ('info');
                $data                   = array('message' => '');
		if ('' != trim ($error_message)){
			$data['message']	=	'<div class="alert alert-block  alert-danger fade in"><button class="close" type="button" data-dismiss="alert">×</button>'.$error_message.'</div>';
		}else if ('' != trim($success_message)){
			$data['message']	=	'<div class="alert  alert-block alert-success fade in"><button class="close" type="button" data-dismiss="alert">×</button>'.$success_message.'</div>';
		}else if ('' != trim($info_message)){
			$data['message']	=	'<div class="alert  alert-block alert-info fade in"><button class="close" type="button" data-dismiss="alert">×</button>'.$info_message.'</div>';
		}
                /*else if ('' != trim ($validation_errors)){
			$data['message']	=	'<div class="alert alert-block alert-danger fade in"><button class="close" type="button" data-dismiss="alert">×</button>'.$validation_errors.'</div>';
		}*/
		$CI->load->view ('reskin/common/messages', $data);
	}
}
function blog_post_date_compare($a, $b){
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t2 - $t1;
}

function expires_within($validity, $from){
    $today  = strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
    $check  = strtotime($from.' +'. $validity .' days');
    if($today <= $check){
        $diff   = $check - $today;
        
        $days   = floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
        $hours  = round(($diff-$days*60*60*24)/(60*60));
        if($days > 0){
            return $days.' days';
        }else if($hours){
            return $hours.' hour';
        }
    }else{
        return FALSE;
    }
}

if(!function_exists('trial_period_checking')){
    function trial_period_checking(){
        $ci = &get_instance();
        if($ci->authentication->logged_in("trial")){
            $ci->load->model('trial_account_model');
            /*$settings                   = $ci->admin_trial_account_model->getSettings();
            $today  = strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
            $check  = strtotime($ci->session->userdata('ACTIVATED_AT').' +'. $settings->validity_days .' days');
            if($today > $check){*/
            $user           = $ci->trial_account_model->getUser($ci->session->userdata('TRIAL_USERID'));
            if(2 == $user->status && $user->reg_user_id > 0){// if admin created a adhi user , that is logged in as Guest user now
                $result = $ci->authentication->userAutoLogin($user->reg_user_id);
                if('success' == $result['status']){
                    redirect('profile');
                }else{
                    $ci->session->logout();
                    $ci->session->set_flashdata('msg', $result['msg']);
                    redirect('/');
                }
            }else if(3 == $user->status){// if guest period expired
                //$ci->authentication->logout();
                $ci->session->set_userdata(array('EXPIRED_TRIAL_ID' => $user->id, 'TRIAL_EXPIRED' => TRUE));
                redirect('/trial_account/expired');
            }
        }
    }
}
if(!function_exists('generate_hash')){
    function generate_hash($text){        
        return crypt($text, '$1$adhi.LLC$');
    }
}
if(!function_exists('validate_crypt')){
    function validate_crypt($text, $hash){
        return crypt($text, $hash)==$hash;
    }
}

/* Reskin inner page heading */
  function page_heading_location($title = '', $page_head_class = '', $showname = true, $show_section = true){
      $name = '';
      $mobile_username_part = '';
      if($showname){
        $ci = &get_instance();
        if($ci->session->userdata('USER_NAME')){
            $name = '<i class="fa fa-user"> </i> '.$ci->session->userdata('USER_NAME').' '.$ci->session->userdata('LAST_NAME');
            $mobile_username_part   = '<div class="mob_username hidden-sm visible-xs part2">'. $name.'</div>';
        }
      }
      $content  = ($show_section) ? '<section class="page_head banner-career-event '.$page_head_class.'">' : '';
      $content  .= ($show_section) ? '</section>' : '';
      echo $content;
  }

  function is_BRE_test_user(){
      $ci = &get_instance();
      if(count(c('BRE_user_ids')) > 0
          &&
          array_search($ci->session->userdata('USERID'), c('BRE_user_ids')) !== false)
      {
          return true;
      }else{
          return false;
      }
  }


function load_client_js_files ($type){
    $ci 			= &get_instance();
    if('header' == $type){
        $js_files		=	array(
            'jquery.1.11.3.min.js',
            'email.js'
        );
        $url_part = '-header';
    }else {
        $js_files		=	array(
            'bootstrap.min.js',
            'jquery.validate.min.js',
            'moment.min.js',
            'fullcalendar.min.js',
            'modernizr.js',
            'owl.carousel.min.js',
            'jquery.countTo.js',
            'wow.min.js',
            'user.js',
            'masonry.pkgd.min.js',
            'bootbox.min.js',
            'rubick_pres.js'
        );
        $url_part = '-footer';
    }
    $con_name		= $ci->uri->segment (1);
    $fun_name		= $ci->uri->segment (2);

    $js_file_path		= $ci->config->item ('script_path');
    $js_dest_file_path  = $ci->config->item ('js_path_parsed');

    $act_filename	= 'adhi_'.$con_name.'_'.$fun_name.$url_part.'.js';
    $filename		= $js_dest_file_path.$act_filename;
    @unlink($filename);
    if (file_exists($filename) ){
        return $act_filename;
    }else{
        @unlink($filename);
        foreach ($js_files as $files ){
            $file_to_open	= $js_file_path.$files;
            $file_contents	= file_get_contents($file_to_open, true);
            file_put_contents($filename,$file_contents,FILE_APPEND);
        }

        $yui_minifier_path	= $ci->config->item('yuicompressor_path');
        $java_path			= $ci->config->item('java_path');
        exec($java_path.' -jar '.$yui_minifier_path.' '.$filename.' -o '.$filename);
        return $act_filename;
    }

}


if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}
// End of Helper
?>