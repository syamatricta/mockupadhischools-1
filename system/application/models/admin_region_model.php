<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class Admin_region_model extends Model{
	function Admin_region_model ()
	{
		parent::Model ();
		//$this->output->enable_profiler();
	}  
	
	function dbGetTotalRegion(){
		$this->db->from ('adhi_region');
		return $this->db->count_all_results();
	}
	
	/**
	 * function to select the region details
	 */
	function dbSelectAllRegion ($num,$offset = 0) {
		
		$this->db->select ("*");
		$this->db->from('adhi_region');
	    $this->db->limit($num,$offset);
	    $this->db->orderby('region_name','ASC');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to insert a new region
	 */
	function dbInsertRegion($region_name){
		$this->db->set('region_name', $region_name);
		$this->db->set('created_date', convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
		$this->db->set('updated_date', convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
		$this->db->insert('adhi_region'); 
		$result = $this->db->insert_id();
		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}
	/**
	 * function used to check uniqueness of region name
	 *
	 * @param unknown_type $region - field value
	 * @param unknown_type $type - type of field that is passed
	 * @param unknown_type $optional - any field value
	 * @return unknown
	 */
	function dbUniqueRegion($region,$type,$optional=''){
		if($type=='name')
			$this->db->where ('region_name', $region);
			
		if($type=='id')
			$this->db->where ('id', $region);
			
		if($type=='name/id'){
			$this->db->where ('region_name', $region);
			$this->db->where ('id !=', $optional);
		}
			
		$this->db->from ('adhi_region');
		return $this->db->count_all_results();
	}
	
	function dbSelectSingleRegion($regionId){
		$this->db->select ("*");
		$this->db->where ('id', $regionId);
		$this->db->from('adhi_region');
		$query	=	$this->db->get();
		if($query->result())
			return $query->result();
		else 	
			return FALSE;
	}
	
	function dbSelectAllRegionDetails(){
		$this->db->select ("*");
		$this->db->from('adhi_region');
		$query	=	$this->db->get();
		return($query->result());
	}
	
	function dbUpdateRegion($region_name,$region_id){
		$data = array(
               'region_name' => $region_name,
               'updated_date' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
        );
		$this->db->set($data);
		$this->db->where('id', $region_id);
		if($this->db->update('adhi_region'))
			return TRUE;
		else 	
			return FALSE;
	}
	
	function dbDeleteRegion($region_id){
		$this->db->where('id', $region_id);
		if($this->db->delete('adhi_region')){
				$this->dbDeleteSubregionAndEventDetails($region_id);
				return TRUE;
		}else 	
			return FALSE;
	}
	
	function dbDeleteSubregionAndEventDetails($region_id){
		
		$sql = "DELETE subregion,master,event 
					FROM adhi_subregion AS subregion 
					LEFT JOIN adhi_events_master AS master ON master.subregion_id = subregion.id
					LEFT JOIN adhi_events AS event ON event.events_master_id = master.id
					WHERE subregion.region_id =".$region_id;
		$this->db->query($sql);				
	}
	
	function dbUniqueSubRegion($type,$subregion,$regionid=''){
		if($type=='name'){
			$this->db->where ('region_id', $regionid);
			$this->db->where ('subregion_name', $subregion);
		}
		if($type=='name/id'){
			$this->db->where ('id !=', $regionid);
			$this->db->where ('subregion_name', $subregion);
		}
			
		$this->db->from ('adhi_subregion');
		return $this->db->count_all_results();
	}
	
	function dbInsertSubRegion($subregion,$region_id){
		
		$this->db->set ('subregion_name', $subregion['subregion']);
		$this->db->set ('region_id', $region_id);
		$this->db->set ('subregion_address', $subregion['subregion_address']);
		$this->db->set ('subregion_description', $subregion['subregion_des']);
		if(isset($subregion['file_name']))
			$this->db->set ('image_name', $subregion['file_name']);
                //$this->db->set ('yt_video', $subregion['yt_video']);
               // $this->db->set ('hiring_contact_name', $subregion['hiring_contact_name']);
                //$this->db->set ('company_name', $subregion['company_name']);
		//$this->db->set ('created_date', convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
		$this->db->set ('updated_date', convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
		$this->db->insert ('adhi_subregion'); 
		$result = $this->db->insert_id();
		if($result){
			return $result;
		}else{
			return FALSE;
		}
	}
	
	function dbSelectAllSubRegionByRegion($regionId){
		$this->db->select ("*");
		$this->db->where ('region_id', $regionId);
		$this->db->from ('adhi_subregion');
		$query	=	$this->db->get();
		return($query->result());
	}
}