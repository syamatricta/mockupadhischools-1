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

class Admin_meet_staff_model extends Model{
	function Admin_meet_staff_model ()
	{
		parent::Model ();
	}  
	/**
	 * function to select the staff
	 *
	 * @return array
	 */
	function select_staff ($num,$offset = 0,$srchStaff = '') {
		$this->db->select ("*");
		$this->db->from('adhi_meet_staff');
	    $this->db->limit($num,$offset);
	    if('' != $srchStaff)
	    $this->db->like('name',$srchStaff,'both');
	    $this->db->orderby('id','DESC');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of staff
	 *
	 * @return int
	 */
	function qry_count_staff ($srchStaff = ''){
		 if('' != $srchStaff)
	    $this->db->like('name',$srchStaff,'both');
	    	
		$this->db->from('adhi_meet_staff');
		$TOTAL = $this->db->count_all_results();
		return $TOTAL;
		
	}
	function save_staff($data){
		$this->db->set($data);		
		if ($this->db->insert('adhi_meet_staff')){
			return $this->db->insert_id();		
		}		
		return false;
	}
	/**
	 * function to get the details of a staff
	 *
	 * @param int $staff_id
	 * @return row
	 */
	function select_single_staff($staff_id){
		$this->db->where('id',$staff_id);
		
		$this->db->select ("ms.*, (SELECT SUM(hour) FROM adhi_meet_staff_weekly_hour WHERE staff_id= $staff_id) AS totalhour",false);
		$query	=	$this->db->get('adhi_meet_staff as ms');
		return($query->row());
	}
	function update_staff($details){
		$this->db->where('id', $details['id']);
		$updates	=	$this->db->update('adhi_meet_staff', $details,FALSE);
                 
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	
	function delete_staff($id){
		$this->db->where('id',$id);
		$delete = $this->db->delete('adhi_meet_staff');
		if($delete)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	function select_staffs(){
		// $this->db->select("ms.id,ms.name,ms.photo,ms.description, IF(`ms`.`from` >0 ,DATE_FORMAT(NOW(), '%Y') - `ms`.`from`,0) AS fromyear,ms.basehour",false);
		 //
		 $this->db->select("ms.id AS msid,ms.name,ms.photo,ms.description, IF(`ms`.`since` >0 ,DATE_FORMAT(NOW(), '%Y') - `ms`.`since`,0) AS fromyear,ms.basehour,(SELECT SUM(hour) FROM adhi_meet_staff_weekly_hour WHERE staff_id= msid) AS totalhour",false);
		   
		 $this->db->from('adhi_meet_staff ms');

		 $this->db->order_by('ms.name','DSC');
		 $query	=	$this->db->get();
		return($query->result());
	}
	
}