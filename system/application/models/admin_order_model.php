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

class Admin_order_model extends Model{
	function Admin_order_model ()
	{
		parent::Model ();
	}  
	/**
	 * function to select the order details
	 *
	 * @return orderdetails
	 */
	function select_orders ($num,$offset = 0,$details) {
		
		$where ="";
		if('' != $details['datefrom'] && '' == $details['dateto'] )
		{
			$where .= "orderdate >='".$details['datefrom']."' ";
		}
		if('' != $details['dateto'] && '' == $details['datefrom'])
		{
			$where .= "orderdate <='".$details['dateto']."' ";
		}
		if('' != $details['datefrom'] && '' != $details['dateto'])
		{
			$where .= "orderdate BETWEEN '".$details['datefrom']."' AND '".$details['dateto']."' ";
		}
		if($where !='')
		{
		$this->db->where($where);
		}
		$this->db->select ("*");
		$this->db->from('adhi_orderdetails');
	    $this->db->limit($num,$offset);
	    $this->db->orderby('id','DESC');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function qry_count_orderdetails ($details){
		$where ="";
		if('' != $details['datefrom'] && '' == $details['dateto'])
		{
			$where .= "orderdate >='".$details['datefrom']."' ";
		}
		if('' != $details['dateto'] && '' == $details['datefrom'])
		{
			$where .= "orderdate <='".$details['dateto']."' ";
		}
		if('' != $details['datefrom'] && '' != $details['dateto'])
		{
			$where .= "orderdate BETWEEN '".$details['datefrom']."' AND '".$details['dateto']."' ";
		}
		if($where !='')
		{
			$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_orderdetails WHERE ". $where);
		}
		else 
		{
			$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_orderdetails ");
		}
		
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
	/**
	 * function to get the details of a single user
	 *
	 * @param int $userid
	 * @return user details
	 */
	function select_single_order_det($orderid){
		$this->db->where('id',$orderid);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_orderdetails');
		return($query->row());
	}
	function select_user_name($userid){
		$this->db->where('id',$userid);
		$this->db->select ("firstname,lastname");
		$query	=	$this->db->get('adhi_user');
		return($query->row());
	}
	function select_single_order_course_details($orderid){
		$this->db->where('AUC.orderid', $orderid);
		$this->db->select ("AUC.*,AC.parent_course_name,AC.course_name");
		$this->db->from('adhi_user_course AUC');
		$this->db->join('adhi_courses AC','AUC.courseid = AC.id');
		$this->db->orderby('AUC.courseid');
		$query	=	$this->db->get();
		return($query->result());
	}
}