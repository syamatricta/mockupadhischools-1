<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_subadmin_model extends Model{
    function Common_model ()
    {
            parent::Model ();
    }
    
    function select_subadmin($subadmin_id="") 
    {
        $this->db->select('*');
        $this->db->where('id',$subadmin_id);
        $query	= $this->db->get('adhi_admin');
        return($query->row());
    }
    
    function checkemail($email, $subadmin_id) 
    { 
        $this->db->select('emailid');
        $this->db->where('emailid',$email);
        if($subadmin_id != "") 
        {
            $this->db->where('id !=', $subadmin_id); 
        }
        $query	= $this->db->get('adhi_admin');
        $result= $query->num_rows();
        return $result;
    }

    function checkusername($username, $subadmin_id) 
    { 
        $this->db->select('username');
        $this->db->where('username',$username);
        $this->db->where('user_type',2);
        if($subadmin_id != "") 
        {
            $this->db->where('id !=', $subadmin_id); 
        }
        $query	=	$this->db->get('adhi_admin');
        $result= $query->num_rows();
        return $result;
    }

    function select_subadmindetails ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srchPermission = '') 
     {
        $this->db->select ("*");
        $this->db->from('adhi_admin');
        $this->db->where('user_type',2);
        $this->db->limit($num,$offset);
        if('' != $srchFname)
            $this->db->like('firstname',$srchFname,'both');
        if('' != $srchLname)
            $this->db->like('lastname',$srchLname,'both');
        if('' != $srchEmail)
            $this->db->like('emailid',$srchEmail,'both');
        if('' != $srchPermission && $srchPermission > 0)
            $this->db->where('sub_admin_permission', $srchPermission);
        
        $this->db->orderby('id','DESC');
        $query	=	$this->db->get();
        return($query->result());
    }

    function qry_count_subadmindetails ($srchFname = '',$srchLname = '',$srchEmail = '', $srchPermission = '')
     {

        if('' != $srchFname)
        $this->db->like('firstname',$srchFname,'both');
        if('' != $srchLname)
            $this->db->like('lastname',$srchLname,'both');
        if('' != $srchEmail)
            $this->db->like('emailid',$srchEmail,'both');
        if('' != $srchPermission && $srchPermission > 0)
            $this->db->where('sub_admin_permission', $srchPermission);
        
        $this->db->from('adhi_admin');
        $this->db->where('user_type',2);
        $TOTAL = $this->db->count_all_results();
        return $TOTAL;

    }
    
    function delete_subadmin($subadmin_id)
    {
        return $this->db->delete('adhi_admin', array('id' => $subadmin_id)); 
    }
    
    /**
	 * function to select the user details
	 *
	 * @return userdetails
	 */
	function select_userdetails ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '',$src_phone = '',$split = true) {
            $this->db->select ("u.*");
            $this->db->from('adhi_user u');
            if($split){
                $this->db->limit($num,$offset);
            }
	    if('' != $srchFname)
	    	$this->db->like('u.firstname',$srchFname,'both');
	    if('' != $srchLname)
	    	$this->db->like('u.lastname',$srchLname,'both');
	    if('' != $srchEmail)
	    	$this->db->like('u.emailid',$srchEmail,'both');
            if('' != $src_phone)
                $this->db->where('u.phone',$src_phone);
        
            $this->db->where("DATE_FORMAT(u.created_at, '%Y/%m/%d') >=","2018/07/01");
	    $this->db->orderby('u.id','DESC');
            $query	=	$this->db->get();
            return($query->result());
	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function qry_count_userdetails ($srchFname = '',$srchLname = '',$srchEmail = '', $src_phone = ''){
            if('' != $srchFname)
	    	$this->db->like('u.firstname',$srchFname,'both');
	    if('' != $srchLname)
	    	$this->db->like('u.lastname',$srchLname,'both');
	    if('' != $srchEmail)
	    	$this->db->like('u.emailid',$srchEmail,'both');
            if('' != $src_phone)
                $this->db->where('u.phone',$src_phone);
        
            $this->db->where("DATE_FORMAT(u.created_at, '%Y/%m/%d') >=","2018/07/01");

            $this->db->from('adhi_user u');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;
	}
	/**
	 * function to get the details of a single user
	 *
	 * @param int $userid
	 * @return user details
	 */
	function select_single_userdetails($userid){
            $this->db->where('id',$userid);
            $this->db->select ("*");
            $query	=	$this->db->get('adhi_user');
            return($query->row());
	}
        
        /**
	 * function to select the course details of a selected user
	 *
	 * @param int $userid
	 * @return course details
	 */
	function select_single_user_course_details($userid){
		$this->db->where('AUC.userid', $userid);
		$this->db->select("AUC.*,AC.parent_course_name,AC.course_name,AUC.status,AUC.last_attemptdate");
		$this->db->from('adhi_user_course AUC');
		$this->db->join('adhi_courses AC','AUC.courseid = AC.id');
		$this->db->orderby('AUC.courseid');
		$query	=	$this->db->get();
		return($query->result());
	}
        
        function checkCCO($email,$fname,$lname){
            $otherdb = $this->load->database('cco', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

            $otherdb->select ("*");
            $otherdb->from('cc_user_details');
            $otherdb->where('ud_emailid',$email);
            $val = $otherdb->get();
            
            if($val->num_rows() > 0){
                $otherdb->close();
                return true;
            }else{
                $otherdb->select ("*");
                $otherdb->from('cc_user_details');
                $otherdb->where(array('ud_first_name' => $fname,'ud_last_name' => $lname));
                $val1 = $otherdb->get();
                
                if($val1->num_rows() > 0){
                    return true;
                }
            }
            $otherdb->close();
            return false;
        }
    
}