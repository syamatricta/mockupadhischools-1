<?php
/**
 * Class Admin_meta_data_model model handles meta data
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author		James Dominic
 * @modified by Vibeesh 05/07/2010
 */

// ------------------------------------------------------------------------
class Admin_meta_data_model extends Model
{
	
	function Admin_meta_data_model ()	{
		
		parent::Model ();
	}
	
	/* Get Assigned video category for an admin */
	function getAllMetaData($return_type='list', $num, $offset)
	{		
		if('count' == $return_type){
			$this->db->select ("COUNT(meta_id) AS count", FALSE);
			$query	= $this->db->get('adhi_meta_data');
			$result	= $query->row();
			return $result->count;
		}
		$this->db->order_by("meta_page_name");
	    $this->db->select("meta_id, meta_page_name, meta_page_title, meta_keyword, meta_description");
	    $this->db->from("adhi_meta_data");
		$this->db->limit($offset, $num);
		$result	= $this->db->get();
		return $result->result();
	}
	
	function getMetaData($meta_id)
	{
		$this->db->select("*");
		$this->db->from("adhi_meta_data");		
		$this->db->where('meta_id', $meta_id);
	    $query   = $this->db->get ();
		if (0 < $query->num_rows ())
        {
            return $query->row();
        }
        else
        {
            return false;
        }		
	}
	
	function isMetaPageNameExists($page_title, $id=''){
		$this->db->select("meta_id");
		$this->db->from("adhi_meta_data");		
		$this->db->where('meta_page_name', $page_title);		
		if($id != ''){
			$this->db->where("meta_id <> {$id}", NULL, FALSE);
		}
	    $query   = $this->db->get ();
		if (1 < $query->num_rows ()){
            return TRUE;
        }
        else{
            return FALSE;
        }		
	}
	
	function qry_s_max_meta_data(){
		$this->db->select("max(meta_id) as id");
		$this->db->from("adhi_meta_data");		
	    $query   = $this->db->get ();
		$row = $query->result();
								
		if(0 < $row[0]->id)
			return $row[0]->id+1;
		else 
			return 1;
	}
	
	function qry_s_edit_meta_data($meta_id){
	    $this->db->select("meta_page_name, meta_page_title, meta_keyword, meta_description");
		$this->db->from("adhi_meta_data");
		$this->db->where('meta_id', $meta_id);
	    $names= array();
  		$query   = $this->db->get ();
	    foreach ($query->result() as $row)
	    {
	       $names['meta_page_name'] 	= $row->meta_page_name; 
	       $names['meta_page_title'] 	= $row->meta_page_title; 
	       $names['meta_keyword'] 		= $row->meta_keyword;    
	       $names['meta_description'] 	= $row->meta_description;    
	    }
	    return $names;
	}
	
	function getMetaByTitle($page_name)
	{
		$this->db->select("meta_id, meta_page_name,  meta_page_title, meta_keyword, meta_description");
		$this->db->from("adhi_meta_data");
		$this->db->where('meta_page_name', $page_name);
  		$query   = $this->db->get ();
		if (0 < $query->num_rows ())
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
	}
	
	function insertMeta($data){
		return ($this->db->insert ('adhi_meta_data',$data)) ? TRUE : FALSE;
	}
	
	function updateMeta($id,$data){
	 	$this->db->where('meta_id', $id);
		return ($this->db->update('adhi_meta_data', $data)) ? TRUE : FALSE;
	 }
	
	function deleteMetaData($meta_id){
		$this->db->where('meta_id', $meta_id);			
		if($this->db->delete('adhi_meta_data')) 
			return TRUE;
		return FALSE;
	}
	
}
/* End of file admin_model.php */
/* Location: ./system/application/models/user_model.php */