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

class Admin_testimonial_model extends Model{
	function Admin_testimonial_model ()
	{
		parent::Model ();
	}  
	/**
	 * function to select the testimonials
	 *
	 * @return array
	 */
	function select_testimonials ($num,$offset = 0,$srchTestimonial = '') {
		$this->db->select ("*");
		$this->db->from('adhi_testimonials');
		$this->db->limit($num,$offset);
	    if('' != $srchTestimonial)
	    $this->db->like('testimonial_name',$srchTestimonial,'both');
	    $this->db->orderby('id','DESC');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function qry_count_testimonials ($srchTestimonial = ''){
		 if('' != $srchTestimonial)
	    $this->db->like('testimonial_name',$srchTestimonial,'both');
	    	
		$this->db->from('adhi_testimonials');
		$TOTAL = $this->db->count_all_results();
		//$TOTAL	=	$count->row();
		//return($TOTAL->tot);
		return $TOTAL;
		
	}
	function save_testimonial($testimonials){
		$this->db->set($testimonials);		
		if ($this->db->insert('adhi_testimonials')){
			return $this->db->insert_id();		
		}		
		return false;
	}
	/**
	 * function to get the details of a testimonial
	 *
	 * @param int $testm_id
	 * @return row
	 */
	function select_single_testimonial($testm_id){
		$this->db->where('id',$testm_id);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_testimonials');
		return($query->row());
	}
	function update_testimonial($details){
		$this->db->where('id', $details['id']);
		$updates	=	$this->db->update('adhi_testimonials', $details);
                 
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	
	function delete_testimonial($id){
		$this->db->where('id',$id);
		$delete = $this->db->delete('adhi_testimonials');
		if($delete)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	function select_testimonial($lim, $offset){
		$this->db->select('testimonial_name,testimonial');
		 $this->db->limit($offset,$lim);
		 $this->db->from('adhi_testimonials');
		 $this->db->order_by('id','DESC');
		 $query	=	$this->db->get();
		return($query->result_array());
	}
	
}