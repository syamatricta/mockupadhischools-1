<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin exam functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author		Sreeraj S
 */

// ------------------------------------------------------------------------

class Dictionary_model extends Model{
	
	function Dictionary_model (){
		parent::Model ();
	}  
	/**
	 * function to save the exam details
	 *
	 * @return id
	 */
	function act_save_dictionary_details ($xls_url) {
		
		if (isset ($xls_url) && '' != $xls_url){
		
			$array = array('dl_xls_path' => $xls_url,'dl_uploaded_date'=>convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
			$this->db->set($array);
			
			$this->db->insert('cc_dictionary_log'); 
			
			$dict_id = $this->db->insert_id ();//getting the inserted id
			
			if($dict_id)
				return $dict_id;
			else 	
				return FALSE;
		}else 	
			return FALSE;
		
	}
	/**
	 * inserts the dictionary data
	 *
	 * @param unknown_type $query
	 * @return unknown
	 */
	function qry_i_saveXls_dictionary($query){
		
		if(isset ($query) && '' != $query){		
			$this->db->query($query);
    		$success    = $this->db->insert_id ();
    		return $success;
		}else 
			return FALSE;
		
	}
	/**
	 * function used to get all the dictionary words
	 *
	 * @return unknown
	 */
	function qry_s_get_dictionary_contents() {
		$this->db->select("dct_keyword");
		$this->db->from('cc_dictionary');
		$query = $this->db->get();
		$result = array();
		if($query->result()) {
			foreach ($query->result_array() as $row)
			{
			   $result[] = $row['dct_keyword'];
			}			
		}			
		return $result;
	}
	
	/**
	 * Function for selecting dictionary details
	 * @param no param
	 * @return array of contents
	 */
	function qry_s_dictionary_details($search_keyword = '',$num,$offset) {
		$this->db->select(array('dct_id','dct_keyword','dct_definition'));
		$this->db->from ('cc_dictionary');
		if('' != $search_keyword) {
			$this->db->like('dct_keyword', $search_keyword); 
		}
		$this->db->limit($num,$offset);
		$this->db->order_by ('dct_keyword');
		$query = $this->db->get();
		$result = array();
		if($query->result()) {
			$result = $query->result_array();
		} 
		return $result;
	}
	/**
	 * Function for deleting dictionary details
	 * @param $dct_id reference dictionary id
	 * @return teue or false
	 */
	function qry_d_delete_dictionary_details ($dct_id) {
		if(isset ($dct_id) && '' != $dct_id) {
			$this->db->where ('dct_id',$dct_id);
			if ($this->db->delete('cc_dictionary'))
			{
				return TRUE;			
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Function for truncating dictionary details
	 * @param $dct_id reference dictionary id
	 * @return true or false
	 */
	function qry_e_empty_dictionary_details () {		
		 
		if ($this->db->truncate('cc_dictionary'))
		{
			return TRUE;			
		} else {
			return FALSE;
		}
		
	}
	
	/**
	 * Function for selecting dictionary details for a particular dct_id
	 * @param $dct_id reference dictionary id
	 * @return array of contents
	 */
	function qry_s_get_single_dictionary_detail ($dct_id) {	
		$result = array();
		if(isset ($dct_id) && '' != $dct_id) {	
			$this->db->select(array('dct_id','dct_keyword','dct_definition'));
			$this->db->from ('cc_dictionary');
			$this->db->where('dct_id',$dct_id);
			$query = $this->db->get();			
			if($query->result()) {
				$result = $query->result_array();
			} 
		}	
		return $result;		
	}
	
	/**
	 * Function for updating dictionary details for a particular dct_id
	 * @param $dct_id reference dictionary id
	 * @return true/false
	 */
	function qry_u_dictionary_detail ($dct_details,$dct_id) {	
		if(isset ($dct_id) && '' != $dct_id) {	
			$this->db->where ('dct_id', $dct_id);
			return $this->db->update ('cc_dictionary', $dct_details);
		} else {
			return false;
		}
	}
	
	/**
	 * Function for checking keyword exist or not
	 * @param $keyword, $dct_id
	 * @return true/ false
	 */
	function qry_s_check_keyword_exist ($keyword,$dct_id = '') {
		$this->db->select("dct_keyword",false);
		$this->db->from ('cc_dictionary');
		if('' != $dct_id) {
			$this->db->where('dct_id != ',$dct_id);
		}
		$this->db->where('dct_keyword',$keyword);
		//$this->db->where("MATCH (dct_keyword) AGAINST ('".$keyword."')");
		$query = $this->db->get();			
		if(0 < $query->num_rows ()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Function for inserting dictionary details
	 * @param dictionary details array
	 * @return inserted id or false
	 */
	function qry_i_dictionary_detail ($dictonary_details) {
		if (isset ($dictonary_details) && is_array($dictonary_details)) {
    	    $this->db->set ($dictonary_details);
            $this->db->insert ('cc_dictionary');
    		$success = $this->db->insert_id ();
    		if($success)
    			return $success;
    		else 
    			return FALSE;
	    }
	    else
	    {
	       return FALSE;
	    }
	}
	/**
	 * used to get dictionary count for pagination
	 *
	 * @param unknown_type $search_keyword
	 * @return unknown
	 */
	function qry_s_get_count_dictionary_details ($search_keyword) {
		$this->db->select(array('dct_id'));
		$this->db->from ('cc_dictionary');
		if('' != $search_keyword) {
			$this->db->like('dct_keyword', $search_keyword); 
		}
		$query = $this->db->get();
		$result = 0;
		if($query->result()) {
			$result = $query->num_rows();
		} 
		return $result;
	}
	
	/**
	 * Function For getting dictionary words and definitions
	 * @return  returns the array of contents 
	 * @param no parameters
	 */
	function getDiictionaryWordsAndDef () {
		$this->db->select(array("dct_keyword","dct_definition"));
		$this->db->from('cc_dictionary');
		$query = $this->db->get();
		$result = array();
		if($query->result()) {
			foreach ($query->result_array() as $row)
			{
			   $result[$row['dct_keyword']] = $row['dct_definition'];
			}			
		}			
		return $result;
	}
}
?>