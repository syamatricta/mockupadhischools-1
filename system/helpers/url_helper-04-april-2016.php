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

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */


if ( ! function_exists('site_url'))
{
	function site_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->site_url($uri);

	}
}

// ------------------------------------------------------------------------

/**
 * Base URL
 *
 * Returns the "base_url" item from your config file
 *
 * @access	public
 * @return	string
 */
 if ( ! function_exists('base_url_main'))
{
	function base_url_main()
	{
		$CI =& get_instance();

            return $CI->config->slash_item('base_url');
	}
}

/*
if ( ! function_exists('base_url'))
{
	function base_url()
	{
		$CI =& get_instance();
		$ssl_uris =   array('/user/register','/user/renewal','/user/listremainingcourse','/iframe_user/register/isframe','/iframe_user/register/','/iframe_user/register/isframe/','/iframe_user/register');
		if( in_array($CI->uri->uri_string(),$ssl_uris)) {
            force_ssl();
            return $CI->config->slash_item('base_url');
        } else {
    		return $CI->config->slash_item('base_url');
        }
	}
}*/



if (!function_exists('base_url')) {

    function base_url() {
        $CI = & get_instance();
        if (is_ssl_page_url()) {
            force_ssl();
            return $CI->config->slash_item('base_url');
        } else {
            return $CI->config->slash_item('base_url');
        }
    }

}

if (!function_exists('force_ssl'))
{
    function force_ssl()
    {
        $CI =& get_instance();
        $CI->config->config['base_url'] =
                 str_replace('http://', 'https://',
                 $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 443)
        {
            redirect($CI->uri->uri_string());
        }
    }
}

if (!function_exists('check_force_non_ssl'))
{
    function check_force_non_ssl()
    {
        $CI =& get_instance();

	$is_ssl_url = is_ssl_page_url();
	if(!$is_ssl_url && $_SERVER['SERVER_PORT'] == 443){
		$CI->config->config['base_url'] =    str_replace('https://', 'http://', $CI->config->config['base_url']);
		redirect($CI->uri->uri_string());
	}else if($_SERVER['SERVER_PORT'] == 443 && $is_ssl_url){
		$CI->config->config['base_url'] =    str_replace('http://', 'https://', $CI->config->config['base_url']);
		$CI->config->config['site_baseurl'] =    str_replace('http://', 'https://', $CI->config->config['site_baseurl']);

		$CI->config->config['css_url_path'] =    str_replace('http://', 'https://', $CI->config->config['css_url_path']);
		$CI->config->config['js_url_path'] =    str_replace('http://', 'https://', $CI->config->config['js_url_path']);
		$CI->config->config['images'] =    str_replace('http://', 'https://', $CI->config->config['images']);

	}
    }
}

if(!function_exists('is_ssl_page_url')){
 function is_ssl_page_url (){
	$CI =& get_instance();
	$ssl_uris = array(
		        array('r1' => 'user' , 'r2' => 'register') ,
		        array('r1' => 'user' , 'r2' => 'renewal') ,
		        array('r1' => 'user' , 'r2' => 'listremainingcourse') ,
		        array('r1' => 'user' , 'r2' => 'register_step2') ,
		        array('r1' => 'user' , 'r2' => 'courseadd') ,
		        array('r1' => 'user' , 'r2' => 'reg_result_success') ,
		        array('r1' => 'user' , 'r2' => 'reg_result_success_reship') ,
		        array('r1' => 'iframe_user' , 'r2' => 'register', 'r3' => 'isframe') ,
		        array('r1' => 'iframe_user' , 'r2' => 'register') ,
		        array('r1' => 'iframe_user' , 'r2' => 'register_step2') ,
		        array('r1' => 'iframe_user' , 'r2' => 'courseadd') ,
		        array('r1' => 'iframe_user' , 'r2' => 'reg_result_success') ,
		        array('r1' => 'iframe_user' , 'r2' => 'reg_result_success_reship') ,
		        array('r1' => 'register_ajax' , 'r2' => 'get_courses') ,
		        array('r1' => 'register_ajax' , 'r2' => 'get_ship') ,
		        array('r1' => 'register_ajax' , 'r2' => 'iframe_get_courses') ,
		        array('r1' => 'register_ajax' , 'r2' => 'iframe_get_ship'),                
                array('r1' => 'user', 'r2' => 'setShippingAddrToBillingAddr'),
                array('r1' => 'admin_register', 'r2' => 'register'),
                array('r1' => 'admin_register', 'r2' => 'register_step2'),
                array('r1' => 'register_ajax', 'r2' => 'admin_get_courses'),
                array('r1' => 'register_ajax', 'r2' => 'get_ship'),
                array('r1' => 'admin_register', 'r2' => 'courseadd')
		        );
	$is_ssl_url = false;
	foreach ($ssl_uris as $k => $segments){
	    $r1 = $CI->uri->rsegment(1);
	    $r2 = $CI->uri->rsegment(2);
	    $r3 = $CI->uri->rsegment(3);
	    if ($r1 == $segments['r1'] && $r2 == $segments['r2'] && isset ($segments['r3']) && $r3 == $segments['r3']){
	       $is_ssl_url = true;
	    }else if($r1 == $segments['r1'] && $r2 == $segments['r2']){
		$is_ssl_url = true;
	    }
	}
	return $is_ssl_url;
  }
}

if ( ! function_exists('ssl_url_img'))
{
	function ssl_url_img()
	{
		$CI =& get_instance();
		if( is_ssl_page_url()) {
			 $CI->config->config['base_url'] =	 str_replace('http://', 'https://',
			 $CI->config->config['base_url']);
			$ssl_url_img =  $CI->config->config['base_url']."images/";
			return $ssl_url_img;
        } else {
			$ssl_url_img =  $CI->config->config['base_url']."images/";
            return $ssl_url_img;
        }
	}
}

if ( ! function_exists('ssl_css_url_path'))
{
	function ssl_css_url_path()
	{
		$CI =& get_instance();
		if( is_ssl_page_url()) {
			 $CI->config->config['base_url'] =	 str_replace('http://', 'https://',
			 $CI->config->config['base_url']);
			$ssl_css_url_path =  $CI->config->config['base_url']."style/parsed/";
			return $ssl_css_url_path;
        } else {
			$ssl_css_url_path =  $CI->config->config['base_url']."style/parsed/";
            return $ssl_css_url_path;
        }
	}
}
if ( ! function_exists('ssl_js_url_path'))
{
	function ssl_js_url_path()
	{
		$CI =& get_instance();
		if(is_ssl_page_url()) {
			 $CI->config->config['base_url'] =	 str_replace('http://', 'https://',
			 $CI->config->config['base_url']);
			$ssl_js_url_path =  $CI->config->config['base_url']."js/parsed/";
			return $ssl_js_url_path;
        } else {
			$ssl_js_url_path =  $CI->config->config['base_url']."js/parsed/";
            return $ssl_js_url_path;
        }
	}
}



// ------------------------------------------------------------------------

/**
 * Current URL
 *
 * Returns the full URL (including segments) of the page where this
 * function is placed
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('current_url'))
{
	function current_url()
	{
		$CI =& get_instance();
		return $CI->config->site_url($CI->uri->uri_string());
	}
}

// ------------------------------------------------------------------------
/**
 * URL String
 *
 * Returns the URI segments.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('uri_string'))
{
	function uri_string()
	{
		$CI =& get_instance();
		return $CI->uri->uri_string();
	}
}

// ------------------------------------------------------------------------

/**
 * Index page
 *
 * Returns the "index_page" from your config file
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('index_page'))
{
	function index_page()
	{
		$CI =& get_instance();
		return $CI->config->item('index_page');
	}
}

// ------------------------------------------------------------------------

/**
 * Anchor Link
 *
 * Creates an anchor based on the local URL.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if ( ! function_exists('anchor'))
{
	function anchor($uri = '', $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}

		if ($title == '')
		{
			$title = $site_url;
		}

		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

/**
 * Anchor Link - Pop-up version
 *
 * Creates an anchor based on the local URL. The link
 * opens a new window based on the attributes specified.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if ( ! function_exists('anchor_popup'))
{
	function anchor_popup($uri = '', $title = '', $attributes = FALSE)
	{
		$title = (string) $title;

		$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;

		if ($title == '')
		{
			$title = $site_url;
		}

		if ($attributes === FALSE)
		{
			return "<a href='javascript:void(0);' onclick=\"window.open('".$site_url."', '_blank');\">".$title."</a>";
		}

		if ( ! is_array($attributes))
		{
			$attributes = array();
		}

		foreach (array('width' => '800', 'height' => '600', 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0', ) as $key => $val)
		{
			$atts[$key] = ( ! isset($attributes[$key])) ? $val : $attributes[$key];
			unset($attributes[$key]);
		}

		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}

		return "<a href='javascript:void(0);' onclick=\"window.open('".$site_url."', '_blank', '"._parse_attributes($atts, TRUE)."');\"$attributes>".$title."</a>";
	}
}

// ------------------------------------------------------------------------

/**
 * Mailto Link
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed 	any attributes
 * @return	string
 */
if ( ! function_exists('mailto'))
{
	function mailto($email, $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ($title == "")
		{
			$title = $email;
		}

		$attributes = _parse_attributes($attributes);

		return '<a href="mailto:'.$email.'"'.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

/**
 * Encoded Mailto Link
 *
 * Create a spam-protected mailto link written in Javascript
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed 	any attributes
 * @return	string
 */
if ( ! function_exists('safe_mailto'))
{
	function safe_mailto($email, $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ($title == "")
		{
			$title = $email;
		}

		for ($i = 0; $i < 16; $i++)
		{
			$x[] = substr('<a href="mailto:', $i, 1);
		}

		for ($i = 0; $i < strlen($email); $i++)
		{
			$x[] = "|".ord(substr($email, $i, 1));
		}

		$x[] = '"';

		if ($attributes != '')
		{
			if (is_array($attributes))
			{
				foreach ($attributes as $key => $val)
				{
					$x[] =  ' '.$key.'="';
					for ($i = 0; $i < strlen($val); $i++)
					{
						$x[] = "|".ord(substr($val, $i, 1));
					}
					$x[] = '"';
				}
			}
			else
			{
				for ($i = 0; $i < strlen($attributes); $i++)
				{
					$x[] = substr($attributes, $i, 1);
				}
			}
		}

		$x[] = '>';

		$temp = array();
		for ($i = 0; $i < strlen($title); $i++)
		{
			$ordinal = ord($title[$i]);

			if ($ordinal < 128)
			{
				$x[] = "|".$ordinal;
			}
			else
			{
				if (count($temp) == 0)
				{
					$count = ($ordinal < 224) ? 2 : 3;
				}

				$temp[] = $ordinal;
				if (count($temp) == $count)
				{
					$number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);
					$x[] = "|".$number;
					$count = 1;
					$temp = array();
				}
			}
		}

		$x[] = '<'; $x[] = '/'; $x[] = 'a'; $x[] = '>';

		$x = array_reverse($x);
		ob_start();

	?><script type="text/javascript">
	//<![CDATA[
	var l=new Array();
	<?php
	$i = 0;
	foreach ($x as $val){ ?>l[<?php echo $i++; ?>]='<?php echo $val; ?>';<?php } ?>

	for (var i = l.length-1; i >= 0; i=i-1){
	if (l[i].substring(0, 1) == '|') document.write("&#"+unescape(l[i].substring(1))+";");
	else document.write(unescape(l[i]));}
	//]]>
	</script><?php

		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}

// ------------------------------------------------------------------------

/**
 * Auto-linker
 *
 * Automatically links URL and Email addresses.
 * Note: There's a bit of extra code here to deal with
 * URLs or emails that end in a period.  We'll strip these
 * off and add them after the link.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the type: email, url, or both
 * @param	bool 	whether to create pop-up links
 * @return	string
 */
if ( ! function_exists('auto_link'))
{
	function auto_link($str, $type = 'both', $popup = FALSE)
	{
		if ($type != 'email')
		{
			if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches))
			{
				$pop = ($popup == TRUE) ? " target=\"_blank\" " : "";

				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['6'][$i]))
					{
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i],
										$matches['1'][$i].'<a href="http'.
										$matches['4'][$i].'://'.
										$matches['5'][$i].
										$matches['6'][$i].'"'.$pop.'>http'.
										$matches['4'][$i].'://'.
										$matches['5'][$i].
										$matches['6'][$i].'</a>'.
										$period, $str);
				}
			}
		}

		if ($type != 'url')
		{
			if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches))
			{
				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['3'][$i]))
					{
						$period = '.';
						$matches['3'][$i] = substr($matches['3'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str);
				}
			}
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Prep URL
 *
 * Simply adds the http:// part if missing
 *
 * @access	public
 * @param	string	the URL
 * @return	string
 */
if ( ! function_exists('prep_url'))
{
	function prep_url($str = '')
	{
		if ($str == 'http://' OR $str == '')
		{
			return '';
		}

		if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
		{
			$str = 'http://'.$str;
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = FALSE)
	{
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					  );

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(stripslashes($str));
	}
}

// ------------------------------------------------------------------------

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = site_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}

// ------------------------------------------------------------------------

/**
 * Parse out the attributes
 *
 * Some of the functions use this
 *
 * @access	private
 * @param	array
 * @param	bool
 * @return	string
 */
if ( ! function_exists('_parse_attributes'))
{
	function _parse_attributes($attributes, $javascript = FALSE)
	{
		if (is_string($attributes))
		{
			return ($attributes != '') ? ' '.$attributes : '';
		}

		$att = '';
		foreach ($attributes as $key => $val)
		{
			if ($javascript == TRUE)
			{
				$att .= $key . '=' . $val . ',';
			}
			else
			{
				$att .= ' ' . $key . '="' . $val . '"';
			}
		}

		if ($javascript == TRUE AND $att != '')
		{
			$att = substr($att, 0, -1);
		}

		return $att;
	}
}


/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */
