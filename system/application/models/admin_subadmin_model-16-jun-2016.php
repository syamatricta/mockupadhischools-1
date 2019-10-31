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

    function select_subadmindetails ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '') 
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
        $this->db->orderby('id','DESC');
            $query	=	$this->db->get();
            return($query->result());
    }

    function qry_count_subadmindetails ($srchFname = '',$srchLname = '',$srchEmail = '')
     {

        if('' != $srchFname)
        $this->db->like('firstname',$srchFname,'both');
        if('' != $srchLname)
            $this->db->like('lastname',$srchLname,'both');
        if('' != $srchEmail)
            $this->db->like('emailid',$srchEmail,'both');

            $this->db->from('adhi_admin');
             $this->db->where('user_type',2);
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;

    }
    
    function delete_subadmin($subadmin_id)
    {
        return $this->db->delete('adhi_admin', array('id' => $subadmin_id)); 
    }
    
}