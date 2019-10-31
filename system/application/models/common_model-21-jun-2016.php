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

class Common_model extends Model{
	function Common_model ()
	{
		parent::Model ();
	} 
	 
	function safe_html($input_field){
		return htmlspecialchars(trim(strip_tags($input_field)));
	
	}
	function listallcourses(){
	$query= $this->db->query("SELECT course_name,course_code,id,amount from adhi_courses where parent_course_id =0");
			if($query->result_array())
			return $query->result_array();
			else
			return false;
	
	}

        function listallcourses_type($course_user_type){
	$query= $this->db->query("SELECT ac.course_name,ac.course_code,ac.id,acp.amount from adhi_course_price acp
			 join adhi_courses as ac on 
			acp.course_id = ac.id  where acp.course_type_id ='$course_user_type'");
        //echo $this->db->last_query();
			if($query->result_array())
			return $query->result_array();
			else
			return false;

	}

	function checkqe(){
	
	$val = addslashes(' �de� ');
		$sql ="INSERT INTO `adhi_exam_questions` (`questions`, `course_id`) VALUES ('$val ', '6')";
		mysql_query($sql);
	}
	/*function licensecourselist_m($type){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt  from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where l.licensetype ='$type'  and l.course_type ='M'  ");
			if($query->result_array())
			return $query->result_array();
			else
			return false;
	}*/
	function licensecourselist_m($type){
	
			$query= $this->db->query("SELECT acp.id,acp.course_id,acp.amount,ac.course_code,ac.course_name,ac.wieght from adhi_course_price acp
			 join adhi_courses as ac on 
			acp.course_id = ac.id  where acp.course_type_id ='$type'  and acp.course_sel_type ='M'  ");
			if($query->result_array())
			return $query->result_array();
			else
			return false;
	}
	/*function licensecourselist_o($type){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where l.licensetype ='$type'  and l.course_type ='O'  ");
			$result = $query->result_array();
			if($query->num_rows()>1)
			return $result;
			else
			return false;
	}*/
	function licensecourselist_o($type){
	
			$query= $this->db->query("SELECT acp.id,acp.course_id,acp.amount,ac.course_code,ac.course_name,ac.wieght from adhi_course_price acp
			 join adhi_courses as ac on 
			acp.course_id = ac.id  where acp.course_type_id ='$type'  and acp.course_sel_type ='O'  ");
			$result = $query->result_array();
			if($query->num_rows()>1)
			return $result;
			else
			return false;
	}
	function subcourselist(){
		//$query= $this->db->get_where('adhi_courses',array('parent_course_id' => $id));
		$query= $this->db->query("SELECT course_name,course_code,id,amount,wieght,parent_course_id from  adhi_courses  where parent_course_id !=0   ");

		$result = $query->result_array();
		if($query->num_rows()>1)
		return $result;
		else
		return false;
	}
	
		/*function license_remain_courselist_nm($type,$userid){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and  c.wieght !=0 and l.licensetype ='$type'  and l.course_type ='M'    ");
			
			$result = $query->result_array();
			
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
			}*/
                function license_remain_courselist_nm($type,$userid,$course_user_type){

			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,cp.amount,c.wieght,
			0 as child_cnt from  adhi_course_price as cp join adhi_courses as c on
			cp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and  c.wieght !=0 and cp.course_type_id ='$course_user_type' AND cp.course_sel_type='M'    ");

			$result = $query->result_array();

			if($query->num_rows()>=1)
			return $result;
			else
			return false;
			}
		function license_remain_courselist_nmt($type,$userid,$course_user_type){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,cp.amount,c.wieght,
			0 as child_cnt from  adhi_course_price as cp join adhi_courses as c on
			cp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and   c.wieght!=0 and cp.course_type_id ='$course_user_type' AND cp.course_sel_type='M' and cp.list_type ='T'   ");
		
		
			$result = $query->result_array();
			
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
			}
	/*function license_remain_courselist_nmb($type,$userid){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and  c.wieght !=0 and l.licensetype ='$type'  and l.course_type ='M' and l.list_type ='B'   ");
			
			$result = $query->result_array();
			
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
			}*/
           function license_remain_courselist_nmb($type,$userid,$course_user_type){

			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,cp.amount,c.wieght,
			0 as child_cnt from  adhi_course_price as cp join adhi_courses as c on
			cp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and  c.wieght !=0 and cp.course_type_id ='$course_user_type' AND cp.course_sel_type='M' and cp.list_type ='B'   ");

			$result = $query->result_array();

			if($query->num_rows()>=1)
			return $result;
			else
			return false;
			}
         /*
          * function license_remain_courselist_m($type,$userid){

			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and l.licensetype ='$type'  and l.course_type ='M'    ");
			echo  $this->db->last_query();
                        $result = $query->result_array();
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
	}
          */
	function license_remain_courselist_m($type,$userid,$course_user_type){
	               //SELECT c.course_name,c.course_code,c.id,l.amount,c.wieght from adhi_course_price as l join adhi_courses as c on l.course_id = c.id where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '307') and l.course_type_id ='8' AND l.course_sel_type='M'
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,cp.amount,c.wieght,
			0 as child_cnt from  adhi_course_price as cp join adhi_courses as c on
			cp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and cp.course_type_id ='$course_user_type' AND cp.course_sel_type='M'    ");
			//echo  $this->db->last_query();
                        $result = $query->result_array();
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
	}
	/*function license_remain_courselist_mt($type,$userid){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and l.licensetype ='$type'  and l.course_type ='M' and l.list_type ='T'     ");
			$result = $query->result_array();
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
	}*/
        function license_remain_courselist_mt($type,$userid,$course_user_type){

			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,acp.amount,c.wieght,
			0 as child_cnt from  adhi_course_price as acp join adhi_courses as c on
			acp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and acp.course_type_id ='$course_user_type' AND acp.course_sel_type='M' and acp.list_type ='T'     ");
			$result = $query->result_array();
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
	}
		/*function license_remain_courselist_mb($type,$userid){
	
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and l.licensetype ='$type'  and l.course_type ='M' and l.list_type ='B'     ");
			echo "SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and l.licensetype ='$type'  and l.course_type ='M' and l.list_type ='B'     ";*/
			/*$result = $query->result_array();
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
	}*/
        function license_remain_courselist_mb($type,$userid,$course_user_type){

			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,acp.amount,c.wieght,
			0 as child_cnt from  adhi_course_price as acp join adhi_courses as c on
			acp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and acp.course_type_id ='$course_user_type'  and acp.course_sel_type ='M' and acp.list_type ='B'     ");
			/*echo "SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght,
			(select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id = l.course_id) as child_cnt from  adhi_license_course as l join adhi_courses as c on
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and l.licensetype ='$type'  and l.course_type ='M' and l.list_type ='B'     ";*/
			$result = $query->result_array();
			if($query->num_rows()>=1)
			return $result;
			else
			return false;
	}
	/*function license_remain_courselist_o($type,$userid){
			$query= $this->db->query("SELECT u.courseid
			FROM adhi_user_course AS u
			JOIN adhi_license_course AS l ON l.course_id = u.courseid
			
			WHERE u.userid = '$userid' and l.course_type = 'O' and l.licensetype = '$type' ");
			$result = $query->result_array();
			//echo $query->num_rows();
			if($query->num_rows()<1){
			
			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,c.amount,c.wieght from  adhi_license_course as l join adhi_courses as c on 
			l.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and  l.licensetype ='$type'  and l.course_type ='O'    ");
				$result = $query->result_array();
				if($query->num_rows()>1)
				return $result;
				else
				return false;
			}else{
			
			return false;
			}

	}*/
        function license_remain_courselist_o($type,$userid,$course_user_type){
			$query= $this->db->query("SELECT u.courseid
			FROM adhi_user_course AS u
			JOIN adhi_course_price AS cp ON cp.course_id = u.courseid

			WHERE u.userid = '$userid' and cp.course_sel_type = 'O' and cp.course_type_id = '$course_user_type' ");
			$result = $query->result_array();
			//echo $query->num_rows();
			if($query->num_rows()<1){

			$query= $this->db->query("SELECT c.course_name,c.course_code,c.id,cp.amount,c.wieght from  adhi_course_price as cp join adhi_courses as c on
			cp.course_id = c.id  where c.id not in (select u.courseid from adhi_user_course as u where u.userid= '$userid') and  cp.course_type_id ='$course_user_type'  and cp.course_sel_type ='O'    ");
				$result = $query->result_array();
				if($query->num_rows()>1)
				return $result;
				else
				return false;
			}else{

			return false;
			}

	}
	function list_renewcourse($usercourse){
			$query= $this->db->query("SELECT course_name,course_code,id,amount,wieght,parent_course_id,parent_course_name,amount ,u.id	
			 from  adhi_courses join adhi_user_course as u on  u.userid = '$userid' and u.courseid = id
			 where c.id ='$courseid'  ");
                        echo $this->db->last_query();
			return $query->result_array();

	
	}
	function list_renewcourse_user($usercourse,$course_user_type){
		if(1==$course_user_type){
			$course_user_type =2;
		}else if(3==$course_user_type){
			$course_user_type =4;
		}else if(5==$course_user_type){
			$course_user_type =6;
		}else if(7==$course_user_type){
			$course_user_type =8;
		}else {
			$course_user_type =$course_user_type;
		}
                       $query= $this->db->query("SELECT c.course_name,c.course_code,c.id,cp.amount,c.wieght,c.parent_course_id,c.parent_course_name
                       from adhi_course_price as cp join adhi_courses as c on
                       cp.course_id = c.id
                       where cp.course_id ='$usercourse' and  cp.course_type_id ='$course_user_type' ");
                            
                            return $query->result_array();
	}
        function u_course($usercourse){
			$query= $this->db->query("SELECT courseid from  adhi_user_course as u where u.id ='$usercourse'  ");
                        $result=$query->result_array();
			$courseid=$result[0]['courseid'];return 	$courseid;


	}
		function sub_remain_courselist($id){
		//$query= $this->db->get_where('adhi_courses',array('parent_course_id' => $id));
		$query= $this->db->query("SELECT course_name,course_code,id,amount,wieght from  adhi_courses  where parent_course_id !=0 and  id not in (select u.courseid from adhi_user_course as u where u.userid = '$id') ");
		//echo "SELECT course_name,course_code,id,amount,wieght from  adhi_courses  where parent_course_id !=0 and  id not in (select u.courseid from adhi_user_course as u where u.userid = '$id') ";
		$result = $query->result_array();

		if($query->num_rows()>1)
		return $result;
		else
		return false;
	}


	
	/*function send_mail ($to_email,$from='', $subject, $body_content,$admin='',$attachment = array())
	{
	    $this->load->library ('email');
		$this->email->_smtp_auth     = TRUE; 	    
        $this->email->protocol       = "smtp";//$this->config->item ('protocol');
        $this->email->smtp_host      = $this->config->item ('smtp_host');
        $this->email->smtp_user      = $this->config->item ('smtp_from');
        $this->email->smtp_pass      = $this->config->item ('smtp_password');
        $this->email->mailtype       = $this->config->item ('mailtype');
		$from_name					 = ($from=='')?$this->config->item ('smtp_from_name'):$from;
        $this->email->from ($this->config->item ('smtp_from'), $from_name);
        $this->email->to ($to_email);
		$this->email->reply_to ($this->config->item ('smtp_from'),$from_name);       
		if($admin!='')
		 $this->email->cc ($this->config->item ('main_cc_to'));
 
		//$this->email->set_mailtype('html');
        $this->email->subject ($subject);
        $this->email->message ($body_content);
        foreach($attachment as $attach )
        {
        	$this->email->attach($attach);
        }
        
        if ($this->email->send ())
        {//var_dump($this->email->print_debugger()); die();
            return TRUE;
        }
        else
        {var_dump($this->email->print_debugger()); die();
            return FALSE;
        }
	}*/
	
	
	function send_mail_ ($to_email,$from='', $subject, $body_content,$admin='',$attachment = array())
	{ 
		$ci = &get_instance();
	    $ci->load->library ('email');
		$ci->email->_smtp_auth     = TRUE; 	    
        $ci->email->protocol       = "smtp";//$this->config->item ('protocol');
        $ci->email->smtp_host      = $ci->config->item ('smtp_host');
        $ci->email->smtp_user      = $ci->config->item ('smtp_from');
        $ci->email->smtp_pass      = $ci->config->item ('smtp_password');
        $ci->email->mailtype       = $ci->config->item ('mailtype');
        //$ci->email->smtp_port      = $ci->config->item ('smtp_port');
        $ci->email->set_newline("\r\n");
		$from_name					 = ($from=='')?$ci->config->item ('smtp_from_name'):$from;
        $ci->email->from ($ci->config->item ('smtp_from'), $from_name);
        $ci->email->to ($to_email);
		$ci->email->reply_to ($ci->config->item ('smtp_from'),$from_name);       
		if($admin!='')
		 $ci->email->bcc ($ci->config->item ('main_cc_to'));
 
		//$this->email->set_mailtype('html');
        $ci->email->subject ($subject);
        $ci->email->message ($body_content);
        
        foreach($attachment as $attach )
        {
        	$ci->email->attach($attach);
        }
        if ($ci->email->send ())
        {
        	//echo $ci->email->print_debugger();exit;
            return TRUE;
        }
        else
        {
        	//echo $ci->email->print_debugger();exit;
            return FALSE;
        }
      
	}
	
	function old_send_mail ($to_email,$from='', $subject, $body_content,$admin='',$attachment = array())
	{
        $ci = &get_instance();
	$ci->load->library ('email');
	$ci->email->_smtp_auth     = TRUE; 	    
        $ci->email->protocol       = "smtp";//$this->config->item ('protocol');
        $ci->email->smtp_host      = $ci->config->item ('smtp_host');
        $ci->email->smtp_user      = $ci->config->item ('smtp_from');
        $ci->email->smtp_pass      = $ci->config->item ('smtp_password');
        $ci->email->mailtype       = $ci->config->item ('mailtype');
        $ci->email->smtp_port      = $ci->config->item ('smtp_port');
        $ci->email->set_newline("\r\n");
		$from_name					 = ($from=='')?$ci->config->item ('smtp_from_name'):$from;
        $ci->email->from ($ci->config->item ('smtp_from'), $from_name);
        $ci->email->to ($to_email);
		$ci->email->reply_to ($ci->config->item ('smtp_from'),$from_name);       
		if($admin!='')
		 $ci->email->bcc ($ci->config->item ('main_cc_to'));
 
		//$this->email->set_mailtype('html');
        $ci->email->subject ($subject);
        $ci->email->message ($body_content);
        foreach($attachment as $attach )
        {
        	$ci->email->attach($attach);
        }
        if ($ci->email->send ())
        {
		//echo $ci->email->print_debugger();exit;
		/*@file_put_contents("/home/adhischools/public_html/err/email_error".time().".txt",' SUCCESS-------- '.$ci->email->print_debugger(), FILE_APPEND);*/
            return TRUE;
        }
        else
        {
		//echo $ci->email->print_debugger();exit;
		/*@file_put_contents("/home/adhischools/public_html/err/email_error".time().".txt",' ERROR......... '.$ci->email->print_debugger(), FILE_APPEND);*/
            return FALSE;
        }
	}
        
        function send_mail($to_email,$from='', $subject, $body_content,$admin='',$attachment = array())
	{
		$this->load->library ('email');
		$this->email->_smtp_auth	= $this->config->item('smtp_auth');     
		$this->email->protocol		= $this->config->item('protocol');
		$this->email->smtp_host		= $this->config->item('smtp_host');
		$this->email->smtp_user		= $this->config->item('smtp_user');
		$this->email->smtp_port		= $this->config->item('smtp_port') ? $this->config->item('smtp_port') : '25';
		$this->email->smtp_pass		= $this->config->item('smtp_password');
		$this->email->mailtype		= $this->config->item('mailtype');
		$from_name					= ($from=='')?$this->config->item('smtp_from_name'):$from;
		//$reply_mail					= ($from_mail=='')?$this->config->item('smtp_from'):$from_mail;
		$this->email->set_newline("\r\n");
                $this->email->set_crlf( "\r\n" );
		$this->email->from($this->config->item('smtp_from'), $from_name);
		$this->email->to($to_email);
		
		$this->email->reply_to($this->config->item('smtp_from'),$from_name);        
		//$this->email->set_mailtype('html');
		$this->email->subject($subject);
		$this->email->message($body_content);
		
                $bcc_emails = '';
                if($admin!=''){
                    $bcc_emails .= $this->config->item ('main_cc_to').',';
                }
                $bcc_emails .= $this->config->item ('main_bcc_to');
                $this->email->bcc($bcc_emails);
                
		foreach($attachment as $attach ){
				$this->email->attach($attach);
		}
		
		if ($this->email->send ()){
			
			//echo $this->email->print_debugger(); exit;
			return TRUE;
		}
		else{
			
			//echo $this->email->print_debugger();exit;
			return FALSE;
		}
	}
        
        function guest_pass_mail($to_email,$from='',$from_name='', $subject='', $body_content='',$admin='',$attachment = array())
	{
                $this->load->library ('email');
                $this->email->_smtp_auth        = $this->config->item('smtp_auth');     
                $this->email->protocol		= $this->config->item('protocol');
                $this->email->smtp_host		= $this->config->item('smtp_host');
                $this->email->smtp_user		= $this->config->item('smtp_user');
                $this->email->smtp_port		= $this->config->item('smtp_port') ? $this->config->item('smtp_port') : '25';
                $this->email->smtp_pass		= $this->config->item('smtp_password');
                $this->email->mailtype		= $this->config->item('mailtype'); 
                $from_name			= ($from_name == '' ) ? $this->config->item('smtp_from_name') : $from_name;
                $from                           = ($from == '' )      ? $this->config->item('smtp_from') : $from;
                
                $this->email->set_newline("\r\n");
                $this->email->from($from,$from_name);
                $this->email->to($to_email);

                $this->email->reply_to($from,$from_name);        
                //$this->email->set_mailtype('html');
                $this->email->subject($subject);
                $this->email->message($body_content);

                if($admin!='')
                 $this->email->bcc ($this->config->item ('main_cc_to'));

                foreach($attachment as $attach ){
                                $this->email->attach($attach);
                }

                if ($this->email->send ()){
                        return TRUE;
                }
                else{

                        return FALSE;
                }
	}
        
	function courseList($id=''){
			
			$query= $this->db->select('course_name,id');
			if(isset($id) && $id!='')
				$query = $this->db->where('id',$id);
			//else
				//$query = $this->db->where('parent_course_id =',0);
			$query = $this->db->get('adhi_courses');
			
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
	}

 // recursive fn, converts three digits per pass
 function convertTri($num, $tri) {
 $ones = array(
 "",
 " one",
 " two",
 " three",
 " four",
 " five",
 " six",
 " seven",
 " eight",
 " nine",
 " ten",
 " eleven",
 " twelve",
 " thirteen",
 " fourteen",
 " fifteen",
 " sixteen",
 " seventeen",
 " eighteen",
 " nineteen"
);

$tens = array(
 "",
 "",
 " twenty",
 " thirty",
 " forty",
 " fifty",
 " sixty",
 " seventy",
 " eighty",
 " ninety"
);

$triplets = array(
 "",
 " thousand",
 " million",
 " billion",
 " trillion",
 " quadrillion",
 " quintillion",
 " sextillion",
 " septillion",
 " octillion",
 " nonillion"
);



  // chunk the number, ...rxyy
  $r = (int) ($num / 1000);
  $x = ($num / 100) % 10;
  $y = $num % 100;

  // init the output string
  $str = "";

  // do hundreds
  if ($x > 0)
   $str = $ones[$x] . " hundred";

  // do ones and tens
  if ($y < 20)
   $str .= $ones[$y];
  else
   $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];

  // add triplet modifier only if there
  // is some output to be modified...
  if ($str != "")
   $str .= $triplets[$tri];

  // continue recursing?
  if ($r > 0)
   return convertTri($r, $tri+1).$str;
  else
   return $str;
 }

// returns the number as an anglicized string
function convertNum($num) {
 $num = (int) $num;    // make sure it's an integer

 if ($num < 0)
  return "negative".convertTri(-$num, 0);

 if ($num == 0)
  return "zero";

 return $this->convertTri($num, 0);
}
function get_quiz_status ($id,$course_id) {
		
		if(isset($course_id) && '' != $course_id){

			$sql = "SELECT c.course_name, l.id,l.quiz_name, l.quiz_status, l.topic from  adhi_courses as c join adhi_quiz_list as l on 
						l.course_id = c.id  where l.course_id ='".$course_id."'  And l.id ='".$id."'  ";
						//AND l.quiz_status='E'
				
			$query	= 	$this->db->query($sql);
				
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
		}else 	
			return FALSE;
	}
	
	
	
	function prepare_select_box_data( $table, $fields, $where = array(), $insert_null = false,$order_by = '',$other_array = array()){
		
		list($key, $val) 	= explode(',',$fields);
		$key 				= trim($key);
		$val 				= trim($val);
		$order_by			= $order_by ? $order_by : $val;
		$input_array 		= $this->get_data( $table, $fields, $where, $order_by );
		
		$select_box_array 	= array();
		$total_records 		= count($input_array);
		if($insert_null) {
			$select_box_array[''] = $insert_null===true ? '' : $insert_null;
		}
		for($i = 0; $i < $total_records; $i++){
		 	$select_box_array[$input_array[$i][$key]] = $input_array[$i][$val];
		}
		if (is_array($other_array) and count($other_array) > 0){
			foreach ($other_array as $key => $val){
				$select_box_array[$key]				=	$val;
			}
		}
		
		return $select_box_array;
	}
	
	function get_data( $table, $fields = '*', $where = array(),$order_by = '' ){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) $this->db->where($where);
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$query = $this->db->get($table);
		return $query->result_array();
	}
        /**
	 * Function for getting upload status
	 */
	function getUploadStatus () {
		$this->db->select('s_status');
		$this->db->from('cc_settings');
		$this->db->where('s_name','upload_status');
		$select_query       = $this->db->get ();
		$result = 0;
		if (0 < $select_query->num_rows ()) {
			$result = $select_query->result_array();
			return  $result[0]['s_status'];
		}
	}
        /**
	 * Function for getting upload status
	 */
	function getCountOfPersonsInExams ($user_type = '') {

		$past_date		=	convert_UTC_to_PST_datetime(date("Y-m-d H:i:s", time()-(9000)));
		$now_date		=	convert_UTC_to_PST_datetime(date('Y-m-d H:i:s', time()));
		$interval_date	=	convert_UTC_to_PST_datetime(date('Y-m-d H:i:s', time()-5));

		$this->db->from("adhi_user_exam");
		//if($user_type != '')
			//$this->db->where('ut_license_type',$user_type);
		$this->db->where('exam_start >= ',$past_date);
		$this->db->where('exam_end <= ',$now_date);
		$this->db->where('exam_end >= ',$interval_date);
		$this->db->where('exam_status = ',0);

		$count       = $this->db->count_all_results ();

		return $count;
	}
	
	/**
	 * function for file_upload 
	 */  
	function file_upload($field_name = '',$upload_path = '',$allowed_type = '',$max_size = 4096){  
		if(@$_FILES[$field_name]['name']){
			$file  							=	explode('.', $_FILES[$field_name]['name']); 
			$name  							=	$file[0];
			$upload_path					=	$upload_path; 
			if (!@$allowed_type){
				$config['allowed_types'] 	=   'gif|jpg|png|jpeg';
			}else{
				$config['allowed_types'] 	=   $allowed_type;
			}
			$config['upload_path'] 			=	$upload_path;
			$config['max_size'] 			=   $max_size;
			$config['remove_spaces'] 		=   TRUE; 
			$file_name						=	str_replace('(','_',$_FILES[$field_name]['name']);
			$file_name						=	str_replace(')','_',$file_name);
			$config['file_name']	    	=   time().$file_name;
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			$bStatus = false;
			$data = array();
			
			if( $this->upload->do_upload($field_name) ){
				
				$bStatus 	= true;				
				
				$data 		= array('upload_data' => $this->upload->data());
				
			}else{
				$bStatus 	= false;
				$data['error_msg'] = $this->upload->display_errors();
			}
			
			return array($bStatus, $data);
		} 
	}
	function getCourses($usertype){
		$this->db->select('ac.id,acp.id as acpid, acp.course_type_id,acp.course_id,acp.course_sel_type,acp.amount,ac.course_code,ac.course_name,ac.wieght');
		$this->db->where('course_type_id',$usertype);
		$this->db->from('adhi_course_price acp');
		$this->db->join('adhi_courses ac','acp.course_id = ac.id','left');
		$query = $this->db->get();
                
		return $query->result();
		
	}
	function getCourseweight(){
		$this->db->select('id,course_code,course_name,wieght');
		$this->db->where('parent_course_id',0);
		$this->db->from('adhi_courses');
		$query = $this->db->get();
		return $query->result();
	}
	function getCoursesList($usertype){
		$this->db->select('acp.id,acp.course_type_id,acp.course_id,acp.course_sel_type,acp.amount,ac.course_code,ac.course_name,ac.wieght');
		$this->db->where('course_type_id',$usertype);
		$this->db->from('adhi_course_price acp');
		$this->db->join('adhi_courses ac','acp.course_id = ac.id','left');
		$query = $this->db->get();
		return $query->result_array();
		
	}
	function get_person_taking_quiz(){
		$this->db->select ( 'id' );
		$this->db->from ( 'adhi_user_quiz' );		
		$this->db->where ( 'quiz_status', 0 );
		$cnt = $this->db->count_all_results ();
		if ($cnt > 0) {
			return $cnt;
		} else
			return 0;
		
	}
	function getDefaultEdition ($id) {
		$this->db->select ("id");
		$this->db->where ('course_id',$id);
		$this->db->where ('default_edition',1);
		$this->db->from("adhi_edition_summary");
		$query	=	$this->db->get();
		$res	=	$query->row();
		return(($res->id > 0)?$res->id:0);
	}
    function save($table, $data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	function update($table, $data, $where) {
        if (!empty($data)) {
            $this->db->where($where);
            $this->db->set($data);
            if ($this->db->update($table)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
	function valueExists($table, $field, $where=array(),$where_not=array()){
		$this->db->where($where);
		if($where_not){
			$this->db->where(key($where_not)."!=", $where_not[key($where_not)],false);
		}
		$this->db->select($field);
		$query	= $this->db->get($table);
		//echo $this->db->last_query();exit;
		if($query->num_rows()>0){
			$row = $query->row();
			return $row->$field;
		}else{
			return FALSE;
		}
	}
	function select($table, $data, $where=array(),$order='',$wherein=array()){
		$this->db->where($where);
		if($wherein){
			$this->db->where_in(key($wherein),$wherein[key($wherein)]);
		}
		$this->db->select($data);
		if($order)
			$this->db->order_by($order);
		$query	= $this->db->get($table);
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return array();
		}
	}
	function getSupplement($course_id,$edition){
		$this->db->select('id,title,file');
		$this->db->where('course_id',$course_id);
		$this->db->where('edition_id',$edition);
		$this->db->from('adhi_supplements');
		$query = $this->db->get();
		return $query->result_array();
		
	}
}
