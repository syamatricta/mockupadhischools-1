<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Adhischools
 *
 * Adhischools.com
 *
 * @package		CodeIgniter
 * @author		Rainconcert Technologies
 * @copyright	Copyright (c) 2012, Rainconcert Technologies.
 * @license		http://adhischools/license.html
 * @link		http://cadhischools.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rainconcert Technologies Dev Team
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * File upload handler
 *
 * This helper can handle all the excel upload in the system
 * *
 * @access	public
 * @param	$_FILE $file
 * @return	Boolean 
 */	
function do_excel_upload($file )
{
	// Get current ci instance
	$ci = &get_instance();
	
	// set config values
	// If file upload location is not set then throw an exception
	if(!$ci->config->item('upload_file')) {
		show_error('config value for excel upload location is missing.');
	}
	
	$config ['upload_path'] = $ci->config->item('upload_file');
	$config ['allowed_types'] = 'xls';
	$config ['max_size'] = '2048';
	$config ['max_width'] = '1024';
	$config ['max_height'] = '768';
	
	// Get file extension
	$extension = get_file_extension($file);
	
	// Validate extension, if fails throw an exception
	if($extension == FALSE){
		show_error('File extension is missing.');
	}
	
	// New file name
	$new_filename = time() . '.' . $extension;
	
	$config['file_name'] = $new_filename;
	
	$ci->gen_contents['file_path'] =  $ci->config->item('upload_file') . '/' . $new_filename;
	// Load library upload
	$ci->load->library ( 'upload', $config );
	
	//Upload file 
	if(!$ci->upload->do_upload()) {
		$ci->gen_contents['error_xls'] = array('error' => $ci->upload->display_errors());
		return FALSE;
	}
	
	return TRUE;
}

/**
 * get file extension
 * @access public
 * @param $_FILE $file
 * @return string $extension, if fails return FALSE
 */
function get_file_extension($file = null)
{
	
	// Throw an exceprion is file not set
	if($file == null) {
		show_error('get_extension():File name is missing');
	}
	
	$extension =  file_extension($file['name']);
	
	if($extension){
		return strtolower($extension);
	}
	
	return FALSE;
}

/**
 * Validate classromm video excel
 */
function validate_classroom_video_excel($file_path = null)
{
	// get front controller instance
	$ci = &get_instance();
	$ci->load->plugin('exel_reader');
	$ci->load->helper('remote_file_exists');
	
	// throw exception if file is missing
	if($file_path == null || file_exists($file_path) == FALSE) {
		show_error('validate_classroom_video_excel(): File missing!');
	}
	
	//Read excel
	$data = new Spreadsheet_Excel_Reader();
	//$data->setOutputEncoding('CP1251');
	$data->setOutputEncoding('UTF8');
	$data->read($file_path);
	
	error_reporting(E_ALL ^ E_NOTICE);
	
	
	// get sheet one
	// Navigate through the cells
	// if the first cell in any row seems empty means video is missing
	// we can omit second cell of each row from validation
	
	// If number of colums not less than or equal to 2, then return error
	if($data->sheets[0]['numCols'] > 2){
		return ' Inappropriate Format: found more than two columns.';
	}
	
	// if no cells data, then return error
	if(!isset($data->sheets[0]['cells']) || count($data->sheets[0]['cells']) == 0 ){
		return ' Inappropriate Format: There is no data found in the sheet.';
	}
	
	// Get the sheet data
	$sheet_data = $data->sheets[0]['cells'];
	$row = 0;
	$column = 0;
	$error_str = '';
	
	foreach($sheet_data as $row_data) {
		$row++;
		$column++;
		
		// Check first cell, that is video filename, if it is empty return error
		if(empty($row_data[1]) || $row_data[1] == ''){
			$error_str .= '<br>Row : ' . $row . ' Video is not specified'; 
			continue;
		}
		
		// Check the file format
		if(check_allowed_extensions($row_data[1]) == FALSE){
			$error_str .= '<br>Row : ' . $row . ' This Video format is not supported.';
			continue;
		}
		
		// check remote existance of video
		if(remote_file_exists($row_data[1]) == FALSE){
			$error_str .= '<br>Row : ' . $row . ' Video does not exists in the location';
			continue;
		}
	}
		
	if($error_str != '') {
		return $error_str;
	}
	
	// if everythig is ok then return true
	return TRUE;
}

/**
 * process_classroom_video_excel
 * process the excel file upload for classroom vides,
 * 
 * @param string $file_path
 * @param string $course_id
 * @param string $chapter_id
 * @return mixed $return, true if everything is fine, else error message
 * 
 */
function process_classroom_video_excel($file_path = null, $course_id = null, $chapter_id = null, $edition = null)
{
	$ci = &get_instance();
	$ci->load->model('classroom_model');
	$ci->load->model('classroom_excel_model');
	
	// throw exception if file is missing
	if($file_path == null || file_exists($file_path) == FALSE) {
		show_error('validate_classroom_video_excel(): File missing!');
	}
	
	// Throw an exception if course_id or chapter_id is missing
	if($course_id === null || $chapter_id === null){
		show_error('validate_classroom_video_excel(): Missing argumets.');
	}
	
	//validate excel
	$validate = validate_classroom_video_excel($file_path);
	
	// if validate is not TRUE then return error
	if($validate !== TRUE){
		return 'Error in excel:' . $validate;
	}
	
	// if validation is tue, then save data
	if($validate === TRUE){
		//Read excel
		$data = new Spreadsheet_Excel_Reader();
		//$data->setOutputEncoding('CP1251');
		$data->setOutputEncoding('UTF8');
		$data->read($file_path);
		
		//TODO log excel file details
		$ci->classroom_excel_model->insert_excel_info(
			$course_id,
			$chapter_id,
			$file_path,
			convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"))
		);
		
		//Save videos
		$sheet_data = $data->sheets[0]['cells'];
		foreach($sheet_data as $row_data){
			$ci->classroom_model->insert_video(
				$course_id, 
				$edition,
				$chapter_id, 
				$row_data[1],
				$row_data[2]
			);
		}
		
		return TRUE;
	}
	
	return FALSE;
}