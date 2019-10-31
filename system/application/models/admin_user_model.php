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

class Admin_user_model extends Model{
	function Admin_user_model ()
	{
		parent::Model ();
		//$this->output->enable_profiler();
	}  
	/**
	 * function to select the user details
	 *
	 * @return userdetails
	 */
	function select_userdetails ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '', $src_zip = '', $src_city = '', $course_type = '',$split = true) {
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
        if('' != $src_city)
            $this->db->where("u.city LIKE '%{$src_city}%'", NULL, FALSE);
        if('' != $src_zip)
            $this->db->where('u.zipcode',$src_zip);
        
        if('S' == $srcLicense || 'B' == $srcLicense)
            $this->db->where('u.licensetype', $srcLicense);

        if('' != $course_type){
            $this->db->where('LOWER(uct.course_type) = LOWER(\''.$course_type.'\')', NULL, FALSE);
        }
        $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');

	    $this->db->orderby('u.id','DESC');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function qry_count_userdetails ($srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '', $src_zip = '', $src_city = '', $course_type = ''){
            //$count	=	$this->db->query("SELECT COUNT(*) as tot FROM adhi_user");
            if('' != $srchFname)
                $this->db->like('u.firstname',$srchFname,'both');
	    if('' != $srchLname)
	    	$this->db->like('u.lastname',$srchLname,'both');
	    if('' != $srchEmail)
    		$this->db->like('u.emailid',$srchEmail,'both');
            
        if('' != $src_phone)
            $this->db->where('u.phone',$src_phone);
        if('' != $src_city)
            $this->db->where("u.city LIKE '%{$src_city}%'", NULL, FALSE);
        if('' != $src_zip)
            $this->db->where('u.zipcode',$src_zip);
        
        if('S' == $srcLicense || 'B' == $srcLicense)
            $this->db->where('u.licensetype', $srcLicense);

        if('' != $course_type){
        	$this->db->where('LOWER(uct.course_type) = LOWER(\''.$course_type.'\')', NULL, FALSE);
        }
        $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');  

        $this->db->from('adhi_user u');
        $TOTAL = $this->db->count_all_results();
        //$TOTAL	=	$count->row();
        //return($TOTAL->tot);
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
	 * function to get the state name 
	 *
	 * @param char $statecode
	 * @return state name
	 */
	function select_state_name($statecode) {
		$this->db->where('state_code',$statecode);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_states');
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
		$this->db->select("AUC.*,AC.parent_course_name,AC.course_name,O.ship_status, ET.id as tracking_id, ET.exam_ended, ET.will_end_at, ET.ended_at, ET.updated_at as tracking_updated_at, ET.status as tracking_status, AC.course_code, AC.amount");
		$this->db->from('adhi_user_course AUC');
		$this->db->join('adhi_courses AC','AUC.courseid = AC.id');
		$this->db->join('adhi_orderdetails O','AUC.orderid = O.id');
		$this->db->join('adhi_exam_tracking ET','ET.user_id= AUC.userid AND ET.course_id=AUC.courseid AND ET.is_latest=1', 'left');
		$this->db->orderby('AUC.courseid');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to select the course details of a selected user based on order 
	 *
	 * @param int $userid
	 * @return course details
	 */
	function select_single_user_course_order_details($userid,$orderid){
		$this->db->where('AUC.userid', $userid);
		$this->db->where('AUC.orderid', $orderid);
		$this->db->select ("AUC.*,AC.parent_course_name,AC.course_name,O.ship_status");
		$this->db->from('adhi_user_course AUC');
		$this->db->join('adhi_courses AC','AUC.courseid = AC.id');
			$this->db->join('adhi_orderdetails O','AUC.orderid = O.id');
		$this->db->orderby('AUC.courseid');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to select all states
	 *
	 * @return states
	 */
	function select_states(){
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_states');
		return($query->result());
	}
	/**
	 * function to freeze the user
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function freeze_user($details){
		
		$this->db->where('id', $details['userid']);
		$details	=	array('status' 		=>	'F',
								'reason'	=>	$details['reason']);
		$updates	=	$this->db->update('adhi_user', $details);
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	/**
	 * function to update the course effective date
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function update_course_effective_date($details){
		$status ='';
                
		if($details['effectivedate']!=''){
                    $status ='C';
                    $effectivedate =  formatDate_search($details['effectivedate']);
		}else{
                    $effectivedate =  '';
                }
                
		$enrolleddate =  formatDate_search($details['enrolleddate']);
                
		/*/if($details['delivereddate'] !='')
		$delivereddate =  formatDate_search($details['delivereddate']);
		else
		$delivereddate =  '';*/
                
		$this->db->where('userid', $details['userid']);
		$this->db->where('courseid', $details['courseid']);

		if($enrolleddate !='' and $details['ship_status'] == 'N'){
                    $details	= array(
                                            'effective_date'        => $effectivedate,
                                            'enrolled_date'         => $enrolleddate,
                                            'delivered_date'        => $enrolleddate,
                                            'edition'               => $details['edition'],
                                            'admin_set_flag'        => 1,
                                            'effective_date_status' => $status
                                    );

                }else{
                    $details	=	array(
                                                'effective_date'	=> $effectivedate,
                                                'enrolled_date'		=> $enrolleddate,
						'edition'               => $details['edition'],
						'admin_set_flag'        => 1,
						'effective_date_status' => $status
                                    );
                }
                
		$updates	= $this->db->update('adhi_user_course', $details);
                return ($updates > 0 ) ? TRUE : FALSE;
	}
	/**
	 * function to update the user details
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function update_user_details($details){
		
		$this->db->where('id', $details['userid']);
		$save_details	=	  array('firstname' =>	$details['firstname'],
								'lastname'              => $details['lastname'],
								'name_on_certificate'   => $details['name_on_certificate'],
								'forum_alias'           => $details['forum_alias'],
                                                                'unit_number'           => $details['unit_number'],
                                                                'licensetype'           => $details['licensetype'],
                                                                'course_user_type'      => $details['course_user_type'],
								'emailid'	=>	$details['email'],
								'address'	=>	$details['address'],
								'state'		=>	$details['state'],
								'city'		=>	$details['city'],
								'zipcode'	=>	$details['zipcode'],
								'country'	=>	$details['country'],
								'phone'		=>	$details['phone'],
                                                                'note'          =>      $details['note'],
								'b_address'	=>	$details['b_address'],
								'b_city'	=>	$details['b_city'],
								'b_state'	=>	$details['b_state'],
								'b_country'	=>	$details['b_country'],
								'b_zipcode'	=>	$details['b_zipcode'],
								's_address'	=>	$details['s_address'],
								's_city'	=>	$details['s_city'],
								's_state'	=>	$details['s_state'],
								's_country'	=>	$details['s_country'],
								's_zipcode'	=>	$details['s_zipcode']
								);
                if(isset($details['driving_license']) && '' != $details['driving_license']){                            
                    $save_details['driving_license'] = $details['driving_license'];
                }
		$updates	=	$this->db->update('adhi_user', $save_details);
                 
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	/**
	 * function to select the order details of a single user
	 *
	 * @param int $userid
	 * @return unknown
	 */
	function select_single_user_order_details($userid){
		$this->db->where('userid',$userid);
		$this->db->select ("id,userid,transactionid,total_amount,orderdate,delivered_date,trackingno,label_path,"
                        . "last_trackdate,current_location,status,ship_method,ship_rate,course_price,b_country,b_state,b_city,b_address,b_zipcode,"
                        . "s_state,s_city,s_address,s_zipcode, s_country, is_promocode_applied, promocode_details, packaging_type");
		$query	=	$this->db->get('adhi_orderdetails');
		return($query->result());
	}
	/**
	 * function to select the details of single order of a user
	 *
	 * @param int $userid
	 * @param int $orderid
	 * @return unknown
	 */
	function select_single_user_single_order($userid,$orderid){
		$this->db->where('userid',$userid);
		$this->db->where('id',$orderid);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_orderdetails');
		return($query->row());
	}
	/**
	 * function to select the details of single course of an order
	 *
	 * @param int $userid
	 * @param int $orderid
	 * @return unknown
	 */
	function select_single_user_single_order_course($userid,$orderid){
		$this->db->where('userid',$userid);
		$this->db->where('orderid',$orderid);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_user_course');
		return($query->result());
	}
	function insert_freezed_order_details($orderarray){
		
		$details		=	array('order_id'		=>	$orderarray['order_id'],
								'userid' 			=>	$orderarray['userid'],
								'b_address'			=>	$orderarray['b_address'],
								'b_city'			=>	$orderarray['b_city'],
								'b_state' 			=>	$orderarray['b_state'],
								'b_zipcode'			=>	$orderarray['b_zipcode'],
								'b_country'			=>	$orderarray['b_country'],
								's_address'			=>	$orderarray['s_address'],
								's_city'			=>	$orderarray['s_city'],
								's_state'			=>	$orderarray['s_state'],
								's_zipcode'			=>	$orderarray['s_zipcode'],
								's_country'			=>	$orderarray['s_country'],
								'transactionid'		=>	$orderarray['transactionid'],
								'orderdate'			=>	$orderarray['orderdate'],
								'ship_method'		=>	$orderarray['ship_method'],
								'payment_method'	=>	$orderarray['payment_method'],
								'ship_rate'			=>	$orderarray['ship_rate'],
								'course_price'		=>	$orderarray['course_price'],
								'total_amount'		=>	$orderarray['total_amount'],
								'delivered_date'	=>	$orderarray['delivered_date'],
								'trackingno'		=>	$orderarray['trackingno'],
								'last_trackdate'	=>	$orderarray['last_trackdate'],
								'current_location'	=>	$orderarray['current_location'],
								'status'			=>	$orderarray['status'],
								'reason'			=>	$orderarray['reason']
									);
        $this->db->insert('adhi_freezed_orderdetails', $details);
		return $this->db->insert_id();
	}
	function insert_freezed_order_course_details($orderarray){
		
		$details		=	array('userid'						=>	$orderarray['userid'],
								'courseid' 						=>	$orderarray['courseid'],
								'orderid'						=>	$orderarray['orderid'],
								'enrolled_date'					=>	$orderarray['enrolled_date'],
								'delivered_date' 				=>	$orderarray['delivered_date'],
								'effective_date'				=>	$orderarray['effective_date'],
								'reason_changing_effective_date'=>	$orderarray['reason_changing_effective_date'],
								'final_score'					=>	$orderarray['final_score'],
								'last_attemptdate'				=>	$orderarray['last_attemptdate'],
								'renewal_status'				=>	$orderarray['renewal_status'],
								'status'						=>	$orderarray['status'],
								'effective_date_status'			=>	$orderarray['effective_date_status']
									);
        $this->db->insert('adhi_user_freezed_order_course', $details);
		return $this->db->insert_id();
	}
	function delete_freezed_order($orderid){
		$this->db->where('id', $orderid);	
		$delete_order	=	$this->db->delete('adhi_orderdetails');
		if($delete_order)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	function delete_freezed_order_course($ordercourseid){
		$this->db->where('id', $ordercourseid);	
		$delete_order	=	$this->db->delete('adhi_user_course');
		if($delete_order)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	function select_single_user_freezed_order_details($userid){
		$this->db->where('userid',$userid);
		$this->db->select ("order_id");
		$query	=	$this->db->get('adhi_freezed_orderdetails');
		return($query->result());
	}
	function servicemethodno($id){
	
		 switch ($id) {
		
			
		case  "Express Priority Overnight":
			return '01';
			break;
		
		case  "Express Economy Two Day":
			return '03';
			break;
		case  "Express Standard Overnight":
			return '05';
			break;
		case  "Express First Overnight":	
			return '06';			
			break;
		case  "Express Saver":	
			return '20';			
			break;
		case  "Freight Overnight":	
			return '70';			
			break;
		case  "Freight Two Day":	
			return '80';			
			break;
		case  "Freight Express Saver":	
			return '83';			
			break;
		case  "Freight International Priority":	
			return '86';			
			break;
		case  "Ground Home Delivery":	
			return '90';			
			break;
		case  "Ground Business Delivery":	
			return '92';			
			break;
			
		}
	}
	function shiporder($arr,$weight,$admin)
    {

		$this->load->plugin ('fedex');
			$arr['b_method']=$this->servicemethodno($arr['ship_method']);
		
		 $this->vals = 	  array(
			'weight_units' 	=> 		'LBS'
			,16				=>   	$arr['b_state']
			,13				=>   	$arr['b_address']
			,5				=>   	$admin[0]['company_address']
			,1273			=>		'01'
			,1274			=> 		$arr['b_method']
			,18				=>   	$arr['phone']
			,15				=>   	$arr['b_city']
			,23				=>   	'1'
			,9				=>    	$admin[0]['zpcode']
			,183			=>  	$admin[0]['phone']
			,8				=>    	$admin[0]['state']
			,117			=>  	$admin[0]['country']
			,17				=>   	$arr['b_zipcode']
			,50				=>   	$arr['b_country']
			,4				=>    	$admin[0]['company_name']
			,7				=>    	$admin[0]['city']
			,12				=>   	$arr['firstname']." ".$arr['lastname']
			,1333			=> 		'1'
			,1401			=> 		$weight
			,116 			=> 		1
			,68 			=>  	'USD'
			,1368			=> 		2
			,1369 			=> 		1
			,1370 			=> 		5
			,3025 			=> 		''
		);

		  $result = ship($this->vals);

		  return $result;
    }
	
	function select_single_order_details($id){
			$query	=$this->db->query(" select a.b_state,a.b_city,a.b_address,a.b_zipcode,a.b_country,a.trackingno,a.ship_method,
			                            u.unit_number,
			                        "
                                   
                                . "a.s_state, a.s_city, a.s_address, a.s_zipcode, a.s_country, u.phone,u.firstname,u.lastname,u.id from adhi_orderdetails as a join adhi_user as u on u.id = a.userid where a.id ='$id'  ");
			$result= $query->result_array();
			return $result[0];
	}
	
	function get_admin_details(){
		$query= $this->db->query("select firstname,lastname,emailid,company_name,company_address,state,city,zpcode,country,phone   from adhi_admin");
		return $query->result_array();
	}
	
	function update_orderdetails($id,$trackno,$label){
	
		$query= $this->db->query("update adhi_orderdetails set trackingno ='$trackno',status ='S',label_path='$label' where id='$id'  ");

	}

	/**
         * Added function get course details
         * Created on 15th May 2013
         * Developer : sam@rainconcert.in
         * 
         * @param type $id
         * @return type 
         */
        function get_course_details($id){
            $retDetails = array();
            
            $course_weight = 0.0;
            $course_amount = 0.0;
            
            $course_cnt = 0;
            $arrCourseDetails = array();
            
            $query= $this->db->query("select  courseid from adhi_user_course where orderid='$id'");
            $result= $query->result_array();
            for($i=0;$i< count($result[0]);$i++){
                $query1= $this->db->query("select * from adhi_courses where id='".$result[0]['courseid']."' ");
                $result1=$query1->result_array();
                
                $arrCourseDetails[$course_cnt] = $result1[0];
                
                $course_weight += $result1[0]['wieght'];
                $course_amount += $result1[0]['amount'];
                
                $course_cnt++;

            }

            $retDetails['course_weight'] = $course_weight;
            $retDetails['course_amount'] = $course_amount;
            $retDetails['arrCourseDetails'] = $arrCourseDetails;
            
            
            return $retDetails;
        }

	function get_courseweight($id){
	$course_weight=0.0;
		$query= $this->db->query("select  courseid from adhi_user_course where orderid='$id'");
		$result= $query->result_array();
		for($i=0;$i< count($result[0]);$i++){
				$query1= $this->db->query("select wieght from adhi_courses where id='".$result[0]['courseid']."' ");
				$result1=$query1->result_array();
				$course_weight = $course_weight + $result1[0]['wieght'];
		
		}
		return $course_weight;
	}
	function mail_touser($userdet,$orderdet){
		
		
		$from ='';
		$toemail= $userdet->emailid;
		$subject='Tracking Information';
		$contents		= '';
			$contents		.= 
			'<table cellpadding="0" cellspacing="0" border="0" width="500">
							<tr>
								<td colspan="2" width="500"><b> Tracking Information </b></td>
							</tr>
							<tr>
								<td align="left"  width="250" >Tracking No</td>
								<td align="left"  width="150" >'.$orderdet['trackingno'].' </td>
							</tr>
						</table>';
						
		$this->send_mail($toemail,$from,$subject,$contents);
	}
	/**
	 * function to send mail
	 *
	 * @param unknown_type $to_email
	 * @param unknown_type $from
	 * @param unknown_type $subject
	 * @param unknown_type $body_content
	 * @param unknown_type $attachment
	 * @return unknown
	 */
	function send_mail ($to_email,$from='', $subject, $body_content,$attachment = array())
	{
	    $this->load->library ('email');
		$this->email->_smtp_auth     = TRUE; 	    
        $this->email->protocol       = "smtp";//$this->config->item ('protocol');
        $this->email->smtp_host      = $this->config->item ('smtp_host');
        $this->email->smtp_user      = $this->config->item ('smtp_from');
        $this->email->smtp_pass      = $this->config->item ('smtp_password');
        $this->email->mailtype       = $this->config->item ('mailtype');
        $this->email->smtp_port      = $this->config->item('smtp_port') ? $this->config->item('smtp_port') : '25';
		$from_name					 = ($from=='')?$this->config->item ('smtp_from_name'):$from;
        $this->email->from ($this->config->item ('smtp_from'), $from_name);
        $this->email->to ($to_email);
		$this->email->reply_to ($this->config->item ('smtp_from'),$from_name);        
		//$this->email->set_mailtype('html');
        $this->email->subject ($subject);
        $this->email->message ($body_content);
        $this->email->bcc ($this->config->item ('main_bcc_to'));
        foreach($attachment as $attach )
        {
        	$this->email->attach($attach);
        }
                
        if ($this->email->send ())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}
	/**
	 * function to check whether the email is already exists or not
	 *
	 * @param int $userid
	 * @param varchar $email
	 * @return email address
	 */
	function check_user_email($userid,$email)
	{
		$this->db->where('id !=',$userid);
		$this->db->where('emailid',$email);
		$this->db->select ("emailid");
		$this->db->from('adhi_user');
	  	$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to update the user profile
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function update_user_profile($details){

            //2 db used . so not done in local. done in dev.
//            $sql="select emailid from adhi_user where id='$details[userid]'";
//            $exe=mysql_query($sql);
//            $res=mysql_fetch_assoc($exe);
//           // echo "ajay".$res['emailid'];
//           $f_uid="select userid from user where email='$res[emailid]'";
//            $f_exe=mysql_query($f_uid);
//            $f_res=mysql_fetch_assoc($f_exe);
           // echo"<br/>dfgd".$f_res['userid'];
//            $DB2= $this->load->database('blog', TRUE);
//            $qu=$DB2->query("select userid from user where email='$res[emailid]'");
//            $ru=$DB2->$qu->row();
//            print_r($ru);
//           echo "sdf".$DB2->row['userid'];
//            die('sdf');

		$this->db->where('id', $details['userid']);
		$details	=	  array('firstname' =>	$details['firstname'],
								'lastname'	=>	$details['lastname'],
								'forum_alias'=>	$details['forum_alias'],
                                                                'unit_number'=>	$details['unit_number'],
								'address'	=>	$details['address'],
								'state'		=>	$details['state'],
								'city'		=>	$details['city'],
								'zipcode'	=>	$details['zipcode'],
								'phone'		=>	$details['phone'],
								'b_address'	=>	$details['b_address'],
								'b_city'	=>	$details['b_city'],
								'b_state'	=>	$details['b_state'],
								'b_zipcode'	=>	$details['b_zipcode'],
								's_address'	=>	$details['s_address'],
								's_city'	=>	$details['s_city'],
								's_state'	=>	$details['s_state'],
								's_zipcode'	=>	$details['s_zipcode']
								);
           
		$updates	=	$this->db->update('adhi_user', $details);
               
//                $u_sql="update userfield set field5='$details[firstname]',field6='$details[lastname]' where userid='$f_res[userid]'";
//
//                 $u_exe=mysql_query($u_sql);
//                 $u_res=mysql_fetch_array($exe);

		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	
	/**
	* function for user registration by admin
	*/	
	function usercourse_admin($arr){
	if($arr['course'] !=''){
		for($i=0;$i<count($arr['course']);$i++){
			$d_edition = getDefaultEdition($arr['course'][$i]);
			$course=array(
			"userid" => $arr['userid'],
			"courseid" => $arr['course'][$i],
			"orderid 	" => $arr['orderid'],
			"enrolled_date" => $arr['enrolled_date'],
			"effective_date" => $arr['effective_date'],
			"delivered_date" => $arr['delivered_date'],
			"edition" => $d_edition
			);
			//if($arr['course'][$i] !=5)
			$this->db->insert('adhi_user_course', $course);
		}
		}
		if($arr['subcourse'] !=''){
			$d_edition = getDefaultEdition($arr['subcourse']);
			$course=array(
				"userid" => $arr['userid'],
				"courseid" => $arr['subcourse'],
				"orderid 	" => $arr['orderid'],
				"enrolled_date" => $arr['enrolled_date'],
				"effective_date" => $arr['effective_date'],
				"delivered_date" => $arr['delivered_date'],
				"edition" => $d_edition
				);				
				$this->db->insert('adhi_user_course', $course);
		}
		if($arr['course_o'] !=''){
			$d_edition = getDefaultEdition($arr['course_o']);
			$course=array(
				"userid" => $arr['userid'],
				"courseid" => $arr['course_o'],
				"orderid 	" => $arr['orderid'],
				"enrolled_date" => $arr['enrolled_date'],
				"effective_date" => $arr['effective_date'],
				"delivered_date" => $arr['delivered_date'],
				"edition" => $d_edition
				);				
				$this->db->insert('adhi_user_course', $course);
		}
	}
	function get_ship_status($courseid,$uid){
			$query	=	$this->db->query("select o.ship_status from adhi_user_course as u 
			join adhi_orderdetails as o on o.id= u.orderid
			 where u.courseid ='$courseid'
			 and u.userid ='$uid'");
					if($query->row()){
						$row =$query->row();
						return $row->ship_status;
					}
					else
					return FALSE;
								
	}
	/**
	 * function used to get the quiz count for a user
	 */
	function getQuizCountForUser($user_id){
		
		$this->db->select ("QL.course_id");
		$this->db->where ('QU.user_id', $user_id);
		$this->db->from ('adhi_quiz_list QL');
		$this->db->join ('adhi_user_quiz QU','QU.quiz_id = QL.id');
		$query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the quiz details of a course, user wise
	 *
	 */
	function getQuizListForCourse ($course_id,$user_id) {
		
		if(isset($course_id) && '' != $course_id){

			$sql	=	"SELECT 
							c.course_name,
							l.id,l.quiz_name,
							l.quiz_status,
							l.topic,
							DATE_FORMAT((COALESCE(MAX(qu.quiz_start),0)),'%m/%d/%Y %H:%i:%s') AS last_date
						FROM 
							adhi_courses AS c 
						JOIN 
							adhi_quiz_list AS l 
						ON
							l.course_id 	= c.id
						LEFT JOIN 
							adhi_user_quiz AS qu
						ON 
							qu.quiz_id = l.id
						WHERE 
							l.course_id 	= '".$course_id."' AND
							qu.user_id		= '".$user_id."'
						GROUP BY l.id
						ORDER BY 
							qu.quiz_start DESC";
			
			$query	= 	$this->db->query($sql);
				
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
		}else 	
			return FALSE;
	}
	
	/*sree 20101222*/
	/**
	 * insert conversation details
	 * */
	function qry_i_conversation($arr){
	
		$this->db->insert('adhi_conversation_details', $arr);
		return $this->db->insert_id();
	}
	
	/**
	 * function to select the sitepage details
	 *
	 * @return sitedetails
	 */
	function select_conversations ($user_id,$num,$offset = 0) {
		
		$this->db->select ("*,DATE_FORMAT(cd_created_date ,'%m-%d-%Y %H:%i') as created_date",FALSE);
		$this->db->from('adhi_conversation_details');
		$this->db->where('user_id',$user_id);
		$this->db->order_by('cd_id','DESC');
		//$this->db->order_by('cd_created_date','DESC');
	    $this->db->limit($num,$offset);
	    $query	=	$this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of sitepage details
	 *
	 * @return count of sitepages
	 */
	function qry_count_conversations ($user_id){
		$count	=	$this->db->query("SELECT COUNT(cd_id) as tot FROM adhi_conversation_details WHERE user_id='$user_id'");
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
	
	function select_single_conversations ($cd_id) {
		
		$this->db->select ("cd.*,DATE_FORMAT(cd.cd_created_date ,'%m-%d-%Y %H:%i') as created_date,ud.firstname  as ud_first_name,ud.lastname as ud_last_name,ud.emailid as ud_emailid",FALSE);
		$this->db->from('adhi_conversation_details cd');
		$this->db->join('adhi_user ud','ud.id=cd.user_id');
		$this->db->where('cd_id',$cd_id);
	    $query	=	$this->db->get();
		return($query->row());
	}
	
	function delete_conversations ($cd_id) {
		$this->db->where('cd_id', $cd_id);
		if($this->db->delete('adhi_conversation_details'))
			return TRUE;
		else 	
			return FALSE;	
		
	}
	/**
	 * To activate the user from the admin section
	 * 
	 * @param NULL
	 * @return NULL
	 */
	function qry_u_conversation($data,$cd_id) {
	    $this->db->where("cd_id",$cd_id);
	    return $this->db->update("adhi_conversation_details",$data);
	}
	/*sree 20101222*/ 
	
	
		/**
	 * function to select the user details
	 *
	 * @return userdetails
	 */
	function select_userdetails_completed ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '', $src_zip = '',  $src_city = '',  $course_type = '', $completed = true, $split = true) {
		$where_cond = ('S' == $srcLicense || 'B' == $srcLicense ) ? " AND licensetype = '{$srcLicense}' " : '';
		$data	=	array();
		$sql	=	"SELECT userid FROM (
				SELECT * ,
		                	IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
					IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
				FROM 
					adhi_user_course ac 
				GROUP BY 
					userid
		
				) AS temp 
		WHERE t2 =t1 AND t2 > 0 ";
		
		$res	=	$this->db->query ($sql);
		
		if($res->num_rows()>0){
			
			$data	=	$res->result_array ();

			foreach ($data as $res){
				
				$user_ID[]	=	$res['userid'];
			}
			
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
                        if('' != $src_city)
                            $this->db->where("u.city LIKE '%{$src_city}%'", NULL, FALSE);
                        if('' != $src_zip)
                            $this->db->where('u.zipcode',$src_zip);
                        if('' != $course_type){
                            $this->db->where('LOWER(uct.course_type) = LOWER(\''.$course_type.'\')', NULL, FALSE);
                        }
                        if('' != $srcLicense)
                                $this->db->where('u.licensetype',$srcLicense);
                        $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');

                        if($completed){
                            $this->db->where_in('u.id',$user_ID);
                        }else{
                            $this->db->where_not_in('u.id',$user_ID);
                        }
                        $this->db->orderby('u.id','DESC');
			$query	=	$this->db->get();
			return($query->result());

                }

	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function qry_count_userdetails_completed ($srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '', $src_zip = '', $src_city = '',  $course_type = '', $completed = true){
		
		
		$where_cond = ('S' == $srcLicense || 'B' == $srcLicense ) ? " AND licensetype = '{$srcLicense}' " : '';
		$data	=	array();
		$sql	=	"SELECT userid FROM (
				SELECT * ,
		                	IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
					IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
				FROM 
					adhi_user_course ac 
				GROUP BY 
					userid
		
				) AS temp 
		WHERE t2 =t1 AND t2 > 0 ";
		
		$res	=	$this->db->query ($sql);
		
		
		if($res->num_rows()>0){
			
			$data	=	$res->result_array ();

			foreach ($data as $res){
				
				$user_ID[]	=	$res['userid'];
			}

		    if('' != $srchFname)
		    	$this->db->like('u.firstname',$srchFname,'both');
		    if('' != $srchLname)
		    	$this->db->like('u.lastname',$srchLname,'both');
		    if('' != $srchEmail)
		    	$this->db->like('u.emailid',$srchEmail,'both');
		    if('' != $src_phone)
	    	$this->db->where('u.phone',$src_phone);
                if('' != $src_city)
	    	$this->db->where("u.city LIKE '%{$src_city}%'", NULL, FALSE);
                if('' != $src_zip)
	    	$this->db->where('u.zipcode',$src_zip);
            
            if('' != $course_type){
                $this->db->where('LOWER(uct.course_type) = LOWER(\''.$course_type.'\')', NULL, FALSE);
            }
            if('' != $srcLicense)
	    	$this->db->where('u.licensetype',$srcLicense);
            $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');
            if($completed){
                $this->db->where_in('u.id',$user_ID);
            }else{
                $this->db->where_not_in('u.id',$user_ID);
            }
			$this->db->from('adhi_user u');
			$TOTAL = $this->db->count_all_results();
			//$TOTAL	=	$count->row();
			//return($TOTAL->tot);
			return $TOTAL;

		}
		

    	
		$this->db->from('adhi_user');
		$TOTAL = $this->db->count_all_results();
		//$TOTAL	=	$count->row();
		//return($TOTAL->tot);
		return $TOTAL;
		
	}
	function check_user_forumalias($userid,$forumalias)
	{
	if('' != $userid){
		$query= $this->db->query("select * from adhi_user where forum_alias = ".$this->db->escape($forumalias)." and id!=".$userid);
	}else {
		$query= $this->db->query("select * from adhi_user where forum_alias = ".$this->db->escape($forumalias));
	}
	$result= $query->num_rows();
	return $result;
	}	
        /**
	 * function to get the Course User Type
	 *
	 * @param char $course_user_type
	 * @return state name
	 */
	function select_user_course_types($course_user_type) {
		$this->db->where('id',$course_user_type);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_user_course_types');
		return($query->row());
	}
	function select_course_user_type($userid){
		$this->db->select('course_user_type,licensetype');
		$this->db->where('id',$userid);
		$query	=	$this->db->get('adhi_user');
		return($query->row());
	}
        
        function select_user_exam($user_id, $course_id) {
                $this->db->select('exam_status');
		$this->db->where('course_id',$course_id);
                $this->db->where('user_id',$user_id);
		$query	=	$this->db->get('adhi_user_exam');
                return $query->num_rows();
        }
        
        function delete_course_user($user_id, $course_id) {
                
		$this->db->where('courseid',$course_id);
                $this->db->where('userid',$user_id);
		$this->db->delete('adhi_user_course');
                
        }
        /**
         * Get user course details
         * 
         * @param int $user_id
         * @param int $course_id
         * @return obj
         */
        function get_user_course($user_id, $course_id){
            $this->db->where('courseid',$course_id);
            $this->db->where('userid',$user_id);
            $result = $this->db->get('adhi_user_course');
            return $result->row();
        }
        
        /**
         * Get count of courses(exam attempted course) that have same delivered date
         * 
         * @param int $user_id
         * @param string $delivered_date
         * @return int
         */
        function delivered_course_count($user_id, $delivered_date){
            $this->db->where('userid', $user_id);
            $this->db->where('delivered_date', $delivered_date);
            $this->db->where("last_attemptdate <> '0000-00-00'", NULL, FALSE);
            $result = $this->db->get('adhi_user_course');
            return $result->num_rows();
        }
        
        /**
	 * function to get users from adhischools with specified conditions for a report
	 *
	 * @param 
	 * @return 
	 */
        
        function to_adhi(){
           $this->db->select ("*");
           $this->db->distinct('AU.emailid');
           $this->db->from('adhi_user as AU');
           $this->db->join('adhi_user_course AUC','AUC.userid = AU.id');
           $this->db->join('adhi_orderdetails O','AU.id = O.userid');
           $this->db->join('adhi_user_course_types ACUT','ACUT.id = AU.course_user_type');
           $this->db->join('adhi_courses AC','AC.id = AUC.courseid');
           $this->db->where_in('AU.course_user_type',array(3,4,7,8,10));
           $this->db->where('AUC.enrolled_date >=','2014-01-01');
           $this->db->where('AU.created_by',0);
           $this->db->where_not_in('AU.reason',array('Groupon','Amazon','Living Social','Amazon Local'));
           $this->db->orderby('AUC.enrolled_date','ASC');
           $query = $this->db->get();
           $query = $query->result_array();
           
           
            if(!empty($query)){
                $p = 0;
                $email_arr = $tot_arr = array();
                foreach($query as $r){
                    if(!in_array($r['emailid'],$email_arr)){
                        $email_arr[$p] = $r['emailid'];
                        $tot_arr[$p] = $r;
                        $p++;
                    }
                }
            }
           $this->to_crash($tot_arr,$email_arr);
           exit;

        }
        
        /**
	 * function to get users from crash course that match with adhischools users
	 *
	 * @param $query - adhi_users_details $email_arr - adhi_users_mail_ids
	 * @return 
	 */
        
        function to_crash($query,$email_arr = array()){
            $otherdb = $this->load->database('cco', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

            $otherdb->select ("*");
            $otherdb->from('cc_user_details');
            //$otherdb->where_not_in('ud_emailid',$email_arr);
            $val = $otherdb->get();
            $val = $val->result_array();
            $otherdb->close();
             if(!empty($val)){
                 $k = 0;
                 $v_email = array();
                 foreach($val as $v){
                     $v_email [$k] = $v['ud_emailid'];
                     $k++;
                 }
             }
             
             if(!empty($query)){
                $p = 0;
                $s = 0;
                $tot_arr = array();
                foreach($query as $r){
                    if(!in_array($r['emailid'],$v_email)){
                        $tot_arr[$p] = $r;
                        $p++;
                    } else{
                        $tot[$s] = $r['emailid'];
                        $s++;
                    }
                }
             }
//             print '<pre>';
//             print_r(count($email_arr));
//             print_r(count($tot));
             //exit;
             
            echo 'There are '.count($tot_arr).' user(s) signed for <b> Online </b> courses, created by <b>  Self </b>
                    and not are not <b> Groupon/Amazon/Living Social/ Amazon Local </b>  related from the voucher site and enrolled date above 01/01/2014 .<br/> <br/>';
            $i = 1;
            
             if(!empty($tot_arr)){?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name </td>
                    <td colspan="2"> Email</td>
                    <td colspan="2"> Sign </td>
                    <td colspan="2"> Created </td>
                    <td colspan="2"> Reason </td>
                    <td colspan="2"> Enrolled Date </td>
                </tr>
                <?php foreach($tot_arr as $r){
                    if($r['created_by'] == 0){
                        $created_by = 'Self';
                    }else if($r['created_by'] == 1){
                        $created_by = 'Admin';
                    } else{
                        $created_by = 'Sub Admin';
                    }
                ?>
                <tr> 
                    <td colspan="2"> <?php echo $i; ?> </td>
                    <td colspan="2"> <?php echo $r['firstname'].' '.$r['lastname']; ?> </td>
                    <td colspan="2"> <?php echo $r['emailid']; ?> </td>
                    <td colspan="2"> <?php echo $r['course_type']; ?> </td>
                    <td colspan="2" align="center"> <?php echo $created_by; ?> </td>
                    <td colspan="2"> <?php echo $r['reason']; ?> </td>
                    <td colspan="2"> <?php echo $r['enrolled_date']; ?> </td>
                </tr>   
                <?php $i++; }?>
                </table> <?php
                    
             }
        }
        
        /**
	 * function to select the course details of a selected user
	 *
	 * @param int $userid
	 * @return course details
	 */
	function select_single_user_course_id_details($user_course_id = ''){
		$this->db->where('AUC.id', $user_course_id);
		$this->db->select("AUC.*,AC.parent_course_name,AC.course_name");
		$this->db->from('adhi_user_course AUC');
		$this->db->join('adhi_courses AC','AUC.courseid = AC.id');
		$query	=	$this->db->get();
		return($query->result());
	}
        /**
	 * function to reinstate a user's course
	 *
	 * @param int $userid
	 * @return course details
	 */
	function reinstate_user_course($user_course_id= FALSE, $expiry_date = FALSE,$reason = ''){
               
                if($user_course_id && $expiry_date){
                    $details = array(
                            'user_course_id' => $user_course_id,
                            'reinstate_to' => date('Y-m-d',strtotime(str_replace('-','/',$expiry_date))),
                            'reason' => $reason,
                            'updated_on' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                            'status' => 1
                    );
                    $this->db->insert('adhi_reinstate_details', $details);
                    if($this->db->insert_id()){
                        $this->db->where(array('id' => $user_course_id));
                        $this->db->set(array('reinstate_status' => 1));
                        $this->db->update('adhi_user_course');
                        return TRUE;
                    }
                }
                return FALSE;
        }
        
        /**
	 * function to select the otp user details
	 *
	 * @return userdetails
	 */
	function select_otpusers ($num,$offset = 0,$srchFname = '', $srchEmail = '',$src_phone = '') {
            $this->db->select ("*, adhi_otp_emails_id as id");
            $this->db->from('adhi_otp_emails');
	    $this->db->limit($num,$offset);
            
	    if('' != $srchFname)
	    	$this->db->like('name',$srchFname,'both');
	    if('' != $srchEmail)
	    	$this->db->like('email_id',$srchEmail,'both');
            if('' != $src_phone)
                $this->db->like('phone',$src_phone);
            
	    $this->db->orderby('adhi_otp_emails_id','ASC');
            $query	=	$this->db->get();
            
            return($query->result());
	}
	/**
	 * function to get the count of otp user details
	 *
	 * @return count of otp  users
	 */
	function qry_count_otpusers ($srchFname = '',$srchEmail = '',  $src_phone = ''){
            if('' != $srchFname)
                $this->db->like('name',$srchFname,'both');
	    if('' != $srchEmail)
    		$this->db->like('email_id',$srchEmail,'both');
            if('' != $src_phone)
                $this->db->where('phone',$src_phone);
            
            $this->db->from('adhi_otp_emails');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;
	
	}
        
        /**
	 * function to add/update the otp user
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function add_otp_user($id= "", $details = array()){
            
             if($id != ""){
                    $this->db->where('adhi_otp_emails_id', $id);
                    $this->db->set($details);
                    $updates	=	$this->db->update('adhi_otp_emails');   
             } else {       
		$updates	=	$this->db->insert('adhi_otp_emails', $details);
             }
                
		if($updates > 0 ){
                    return TRUE;
		}else {
                    return FALSE;
			
		}
	}
        
        
        /**
	 * function to check otp user email exists or not
	 *
	 * @return userdetails
	 */
	function otp_mail_check ($id = "",$email = "") {
            
            if($id != ""){
                $this->db->where('adhi_otp_emails_id != ', $id);
            }
            $this->db->where('email_id',$email);
            $query	=	$this->db->get('adhi_otp_emails');
            
            if($query ->num_rows() > 0){
                return FALSE;
            }
            
            return TRUE;
	}
        
        /**
	 * function to freeze the otp user
	 *
	 * @param unknown_type $details, $active_status
	 * @return unknown
	 */
	function freeze_otp_user($details, $active_status = 0){
		
		$this->db->where('adhi_otp_emails_id', $details['userid']);
		$details	=	array('active_status' =>	$active_status,
                                              'reason'        =>	$details['reason'], 
                                              'updated_date'  =>        convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                             );
		$updates	=	$this->db->update('adhi_otp_emails', $details);
                
		if($updates > 0 ){
                    return TRUE;
		}else {
                    return FALSE;
			
		}
	}
        
        
        /**
	 * function to select the otp user details
	 *
	 * @return userdetails
	 */
	function select_trial_users ($num,$offset = 0,$srchFname = '', $srchLname = '', $srchEmail = '',$src_phone = '', $srch_adhi_user = '', $srch_from = '', $srch_to = '') {
            $this->db->select ("*");
            $this->db->from('adhi_trial_users');
	    $this->db->limit($num,$offset);
            
            if('' != $srch_from){
                $srch_from= date('Y-m-d H:i:s', strtotime($srch_from));
            }
            if('' != $srch_to){
                $srch_to= date('Y-m-d H:i:s', strtotime($srch_to));    
            }
            
	    if('' != $srchFname)
	    	$this->db->like('first_name', $srchFname,'both');
            if('' != $srchLname)
                $this->db->like('last_name', $srchLname,'both');
	    if('' != $srchEmail)
	    	$this->db->like('email', $srchEmail,'both');
            if('' != $src_phone)
                $this->db->like('phone', $src_phone);
            if('yes' == $srch_adhi_user){
                $this->db->where('reg_user_id > ', 0, FALSE);            
                if('' != $srch_from)
                    $this->db->where("updated_at>='{$srch_from}'", NULL, FALSE);
                if('' != $srch_to)
                    $this->db->where("updated_at<='{$srch_to}'", NULL, FALSE);
            }else{
                if('' != $srch_from)
                    $this->db->where("activated_at>='{$srch_from}'", NULL , FALSE);
                if('' != $srch_to)
                    $this->db->where("activated_at<='{$srch_to}'", NULL , FALSE);
                
            }
            
	    $this->db->orderby('created_at','DESC');
            $query	=	$this->db->get();
            
            return($query->result());
	}
	/**
	 * function to get the count of otp user details
	 *
	 * @return count of otp  users
	 */
	function qry_count_trial_users ($srchFname = '', $srchLname = '', $srchEmail = '',  $src_phone = '', $srch_adhi_user = '', $srch_from = '', $srch_to = ''){
            if('' != $srchFname)
                $this->db->like('first_name', $srchFname,'both');
            if('' != $srchLname)
                $this->db->like('last_name', $srchLname,'both');
	    if('' != $srchEmail)
    		$this->db->like('email', $srchEmail,'both');
            if('' != $src_phone)
                $this->db->where('phone', $src_phone);
            if('yes' == $srch_adhi_user){
                $this->db->where('reg_user_id > ', 0, FALSE);            
                if('' != $srch_from)
                    $this->db->where("updated_at>='{$srch_from}'", NULL, FALSE);
                if('' != $srch_to)
                    $this->db->where("updated_at<='{$srch_to}'", NULL, FALSE);
            }else{
                if('' != $srch_from)
                    $this->db->where("activated_at>='{$srch_from}'", NULL , FALSE);
                if('' != $srch_to)
                    $this->db->where("activated_at<='{$srch_to}'", NULL , FALSE);
                
            }
            
            $this->db->from('adhi_trial_users');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;
	
	}
        
        function getUnsubscribeRemvData(){
            $this->db->select('new_user_name, new_user_email_id, cron_status');
            $this->db->where(array('cron_status' => 3));   
            $this->db->or_where(array('cron_status' => 2));   
            $this->db->from('adhi_new_user');
            $unsub_list = $this->db->get();
            
            if($unsub_list ->num_rows() > 0){
                $unsub_list = $unsub_list->result_array();
                
                if(!empty($unsub_list)){
                    $email_arr = $name_arr = $cron_arr = array();
                    $s = 0;
                    
                    foreach($unsub_list as $unsub){
                        $email_arr[$s] = $unsub['new_user_email_id'];
                        $name_arr[$s]  = $unsub['new_user_name'];
                        $cron_arr[$s]  = $unsub['cron_status'];
                        $s++;
                    }
                }
            }
            
            $this->db->select('emailid');
            $this->db->from('adhi_user');
            $user_list = $this->db->get();
            
            if($user_list ->num_rows() > 0){
                $user_list =$user_list->result_array();
                
                if(!empty($user_list)){
                    $user_email = array();
                    
                    foreach($user_list as $key => $us){
                        $user_email[$key] = $us['emailid'];
                    }
                }
            }
            
            $mem_list = $this->db->get('adhi_memorial_list');
            
            if($mem_list->num_rows() > 0){
                $mem_list = $mem_list->result_array();
                $p = 0; $k = 0;
                $final_email_list = $final_name_list = array();
                $final_unsub_email_list = $final_unsub_name_list = $final_unsub_reason_list = array();
                
                if(!empty($mem_list)){
                    foreach($mem_list as $mem){
                        if(!in_array($mem['email'], $email_arr)){
                            
                            if(!in_array($mem['email'],$user_email)){
                                if($mem['email'] != "" && $mem['name'] != ""){
                                    $final_email_list[$p]           = $mem['email'];
                                    $final_name_list[$p]            = $mem['name'];
                                    $p++;
                                }
                            } else{
                                $final_unsub_email_list[$k]     = $mem['email'];
                                $final_unsub_name_list[$k]      = $mem['name'];
                                $final_unsub_reason_list[$k]    = 'Registered';
                                $k++;
                            }
                        } else{
                            $final_unsub_email_list[$k]         = $mem['email'];
                            $final_unsub_name_list[$k]          = $mem['name'];
                            
                            $d_key                              = array_search($mem['email'],$email_arr);
                            $final_unsub_reason_list[$k]        = ($cron_arr[$d_key] == 2) ? 'Registered' : 'Unsubscribed';
                            $k++;
                        }
                    }
                }
            }
            
            echo 'There are '.count($final_unsub_email_list).' user(s) in the memorial list who have unsubscribed/registered<br/> <br/>';
            $i = 1;
            ?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name</td>
                    <td colspan="2"> Email</td>
                    <td colspan="2"> Reason</td>
                </tr>
                <?php if(!empty($final_unsub_email_list)){ 
                    foreach($final_unsub_email_list as $key => $r){ ?>
                 <tr> 
                        <td colspan="2"> <?php echo $i; ?> </td>
                        <td colspan="2"> <?php echo $final_unsub_name_list[$key]; ?> </td>
                        <td colspan="2"> <?php echo $r; ?> </td>
                        <td colspan="2"> <?php echo $final_unsub_reason_list[$key]; ?> </td>
                 </tr>     
                <?php $i++;
                } 
                }else { ?>
                       <tr> 
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                        </tr>   
                <?php } ?>
                </table> <br/> <br/> <br/><?php
            
            echo 'There are '.count($final_email_list).' user(s) in the memorial list but not unsubscribed/registered<br/> <br/>';
            $i = 1;
            ?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name</td>
                    <td colspan="2"> Email</td>
                </tr>
                <?php if(!empty($final_email_list)){ 
                    foreach($final_email_list as $key => $r){   ?>
                 <tr> 
                        <td colspan="2"> <?php echo $i; ?> </td>
                        <td colspan="2"> <?php echo $final_name_list[$key]; ?> </td>
                        <td colspan="2"> <?php echo $r; ?> </td>
                </tr>     
                <?php $i++;
                   } 
                }else { ?>
                       <tr> 
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                        </tr>   
                <?php } ?>
                </table> <br/> <br/> <br/><?php
        }
        
        function getAllUsers($search_params, $type = 'all_users') {
                $user_ids   = array();
                if('course_completed' == $type || 'course_not_completed' == $type){
                    $where_cond = ('S' == $search_params['license_type'] || 'B' == $search_params['license_type']) ? " AND licensetype = '{$search_params['license_type']}' " : '';
                    $data	=	array();
                    $sql	=	"SELECT userid FROM (
                                    SELECT * ,
                                            IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
                                            IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
                                    FROM 
                                            adhi_user_course ac 
                                    GROUP BY 
                                            userid

                                    ) AS temp 
                    WHERE t2 =t1 AND t2 > 0 ";

                    $res	=	$this->db->query ($sql);
                    
                    if($res->num_rows()>0){		
                        $data	= $res->result_array ();                        
                        foreach ($data as $res){				
                            $user_ids[] = $res['userid'];
                        }
                    }else{
                        return false;
                    }
                
                }
                $this->db->select ("u.*");
                $this->db->from('adhi_user u');

                if('' != $search_params['first_name']){
                    $this->db->like('u.firstname', $search_params['first_name'],'both');
                }
                if('' != $search_params['last_name']){
                    $this->db->like('u.lastname', $search_params['last_name'],'both');
                }
                if('' != $search_params['email']){
                    $this->db->like('u.emailid', $search_params['email'],'both');
                }
                if('' != $search_params['phone']){
                    $this->db->where('u.phone', $search_params['phone']);
                }
                if('' != $search_params['city']){
                    $this->db->like('u.city', $search_params['city'], 'both');
                }
                if('' != $search_params['zipcode']){
                    $this->db->where('u.zipcode', $search_params['zipcode']);
                }
                if('' != $search_params['license_type']){
                    $this->db->where('u.licensetype', $search_params['license_type']);
                }
                if(count($user_ids) > 0){
                    if('course_completed' == $type){
                        $this->db->where_in('u.id', $user_ids);
                    }else if('course_not_completed' == $type){
                        $this->db->where_not_in('u.id', $user_ids);
                    }
                }

                if('' != $search_params['course_type']){
                    $this->db->where('LOWER(uct.course_type) = LOWER(\''.$search_params['course_type'].'\')', NULL, FALSE);
                }
                $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');

                $this->db->orderby('u.firstname', 'ASC');
                $query	=	$this->db->get();
                return($query->result());

	}
        
        function isTrialUserExists($user_id){
            $this->db->where('id', $user_id);
            $query = $this->db->get('adhi_trial_users');            
            if($query){
                return $query->row();
            }
            return TRUE;
        }
        /**
	 * function to freeze, unfreeze the guest user
	 *
	 * @param unknown_type $details, $status
	 * @return unknown
	 */
	function changeTrialUserStatus($id, $data){
            $this->db->where('id', $id);
            $updates	= $this->db->update('adhi_trial_users', $data);
            if($updates > 0 ){
                return TRUE;
            }else {
                return FALSE;

            }
	}

        /**
         * @param string $date_onwards
         *
         * 1. Pull registration in process email list
         * 2. Pull guest pass request email list
         * 3. Pull trial account email list
         * 4. Run these lists against our current students who have enrolled and are in our system and remove them, as we don't want to email them this.
         * 5. Run the remaining emails against our unsubscribed list from our site.
         *
         */
        function getAdhiSaleList($date_onwards = '2016/11/01'){
            //veinflower ||inclus.stars-and-glory.stars-and-glor
            $exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|veinflower|inclus.stars-and-glory|.xzzy.info$|.pw$|dispostable.com$|rainconcert.in$|qq.com$';
            //$exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|.$';
            $enable_debuging = false;
            $this->db->select('reg_first_name,reg_last_name, reg_email,reg_date');
            $this->db->where(array('status' => 1,"DATE_FORMAT(reg_date, '%Y/%m/%d') >=" => $date_onwards));
            $this->db->where("reg_email NOT REGEXP '$exclude_email_format'", NULL, FALSE);
            $this->db->order_by('reg_date','ASC');
            $this->db->from('adhi_reg_in_process');
            $reg_in_process_list = $this->db->get();
            //echo '<pre>';print_r($reg_in_process_list);exit;
            
            
            $this->db->select('first_name,last_name, email,created_at');
            $this->db->from('adhi_trial_users');
            $this->db->where("DATE_FORMAT(created_at, '%Y/%m/%d') >=" , $date_onwards);
            $this->db->where("email NOT REGEXP '$exclude_email_format'", NULL, FALSE);
            $this->db->order_by('created_at','ASC');
            $guest_list = $this->db->get();
            //echo '<pre>';print_r($guest_list);exit;

            $this->db->select('new_user_name, new_user_email_id,created_date');
            $this->db->where(array('cron_status =' => 3,"DATE_FORMAT(created_date, '%Y/%m/%d') >=" => $date_onwards));
            $this->db->order_by('created_date','ASC');
            $this->db->from('adhi_new_user');
            $sub_list = $this->db->get();
            $exclude_emails = array();
            if($sub_list_array = $sub_list->result_array()){
                foreach ($sub_list_array as $sub_user){
                    array_push($exclude_emails, $sub_user['new_user_email_id']);
                }
                $exclude_email_string = "'".implode($exclude_emails, "','")."'";
            }
            //echo '<pre>';print_r($exclude_email_string);exit;

            $this->db->select('new_user_name, new_user_email_id,created_date');
            $this->db->where(array('cron_status <=' => 1,"DATE_FORMAT(created_date, '%Y/%m/%d') >=" => $date_onwards));
            if(isset($exclude_email_string)){
                $this->db->where('new_user_email_id NOT IN ('.$exclude_email_string.')', NULL, FALSE);
            }
            $this->db->where("new_user_email_id NOT REGEXP '$exclude_email_format'", NULL, FALSE);
            $this->db->order_by('created_date','ASC');
            $this->db->from('adhi_new_user');
            $unsub_list = $this->db->get();
            //echo '<pre>';print_r($unsub_list);exit;

            
            $s = 0;
            $email_arr = $name_arr = $date_arr = array();
            
            if($reg_in_process_list ->num_rows() > 0){
                $reg_in_process_list = $reg_in_process_list->result_array();
                
                if(!empty($reg_in_process_list)){
                    $email_arr = $name_arr = array();
                    $s = 0;
                    
                    foreach($reg_in_process_list as $unsub){
                        
                        if(!in_array($unsub['reg_email'],$email_arr)){
                            $email_arr[$s] = strtolower($unsub['reg_email']);
                            $name_arr[$s]  = $unsub['reg_first_name'].' '.$unsub['reg_last_name'];
                            $date_arr[$s]  = date('Y-m-d',strtotime($unsub['reg_date']));
                            $s++;
                        }
                    }
                }
            }
            if($enable_debuging){
                echo '<div style="overflow-y:scroll;width:23%;height:1000px;float:left;border-right:5px black solid;padding-right;15px;margin-right:15px;"><h4>Reg in process</h4></h4><pre>';print_r($email_arr);echo '</pre></pre></div>';
            }

            
            if($guest_list ->num_rows() > 0){
                $guest_list = $guest_list->result_array();
                
                if(!empty($guest_list)){
                    $email_arr = $name_arr = array();
                    $s = 0;
                    
                    foreach($guest_list as $unsub){
                        if(!in_array($unsub['email'],$email_arr)){
                            $email_arr[$s] = strtolower($unsub['email']);
                            $name_arr[$s]  = $unsub['first_name'].' '.$unsub['last_name'];
                            $date_arr[$s]  = date('Y-m-d',strtotime($unsub['created_at']));
                            $s++;
                        }
                    }
                }
            }
            if($enable_debuging) {
                echo '<div style="overflow-y:scroll;width:23%;height:1000px;float:left;border-right:5px black solid;padding-right;15px;margin-right:15px;"><h4>Guest List</h4><pre>';
                print_r($email_arr);
                echo '</pre></div>';
            }
            if($unsub_list ->num_rows() > 0){
                $unsub_list = $unsub_list->result_array();
                
                if(!empty($unsub_list)){
                    foreach($unsub_list as $unsub){
                        if(!in_array($unsub['new_user_email_id'],$email_arr)){
                            $email_arr[$s] = strtolower($unsub['new_user_email_id']);
                            $name_arr[$s]  = $unsub['new_user_name'];
                            $date_arr[$s]  = date('Y-m-d',strtotime($unsub['created_date']));
                            $s++;
                        }
                    }
                }
            }
            if($enable_debuging) {
                echo '<div style="overflow-y:scroll;width:23%;height:1000px;float:left;border-right:5px black solid;padding-right;15px;margin-right:15px;"><h4> Unsubscribed List</h4><pre>';
                print_r($email_arr);
                echo '</pre></div>';
            }
            asort($date_arr);
               
            $this->db->select('emailid');
            $this->db->from('adhi_user');
            $user_list = $this->db->get();
            
            if($user_list ->num_rows() > 0){
                $user_list =$user_list->result_array();
                
                if(!empty($user_list)){
                    $user_email = array();
                    
                    foreach($user_list as $key => $us){
                        $user_email[$key] = strtolower($us['emailid']);
                    }
                }
            }
            if($enable_debuging) {
                echo '<div style="overflow-y:scroll;width:23%;height:1000px;float:left;border-right:5px black solid;padding-right;15px;margin-right:15px;"><h4> Registerd Users</h4><pre>';
                print_r($user_email);
                echo '</pre></div>';
            }
            if(!empty($email_arr)){
                foreach($email_arr as $key => $emails){
                    if(in_array($emails,$user_email)){
                        unset($email_arr[$key]);
                        unset($name_arr[$key]);
                        unset($date_arr[$key]);
                    }
                }
            }
            
            echo 'There are '.count($email_arr).' user(s) in the list<br/> <br/>';
            $i = 1;
            ?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name</td>
                    <td colspan="2"> Email</td>
                    <td colspan="2"> Created date</td>
                </tr>
                <?php if(!empty($date_arr)){ 
                    foreach($date_arr as $key => $r){ ?>
                 <tr> 
                        <td colspan="2"> <?php echo $i; ?> </td>
                        <td colspan="2"> <?php echo $name_arr[$key]; ?> </td>
                        <td colspan="2"> <?php echo strtolower($email_arr[$key]); ?> </td>
                        <td colspan="2"> <?php echo date('m-d-Y',strtotime($date_arr[$key])); ?> </td>
                 </tr>     
                <?php $i++;
                } 
                }else { ?>
                       <tr> 
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                        </tr>   
                <?php } ?>
                </table> <br/> <br/> <br/>
                <?php
        }
        
        
        function getAdhiNewSaleList(){
            $this->db->select('AU.firstname,AU.lastname,AU.emailid,AU.phone,AU.status,AU.licensetype,AUCT.course_type,AUC.status as pass_status,
                     AUC.reinstate_status,AUC.enrolled_date, AUC.renewal_status, AUC.id as course_prim_id,ARD.reinstate_to');
            $this->db->join('adhi_user_course_types AUCT','AUCT.id = AU.course_user_type');
            $this->db->join('adhi_user_course AUC','AUC.userid = AU.id');
            $this->db->join('adhi_reinstate_details ARD','ARD.user_course_id = AUC.id','LEFT');
            
            $this->db->where(array('course_type' => 'Online'));
            $this->db->order_by('ARD.reinstate_id','DESC');
            $this->db->from('adhi_user as AU');
            $user_process_list = $this->db->get();
            $user_process_list = $user_process_list->result_array();
            
            if(!empty($user_process_list)){
                $email_array = array();
                $u = 0;
                
                foreach($user_process_list as $key => $us){
                    if($us['pass_status'] == 'P'){
                        $email_array[$u++] = $us['emailid'];
                    }
                }
                
                foreach($user_process_list as $key => $us){
                    if(in_array($us['emailid'],$email_array)){
                        unset($user_process_list[$key]);
                    }
                }
                
                $total_emails = array();
                $p = 0;
                
                foreach($user_process_list as $key => $us){
                    if(in_array($us['emailid'],$total_emails)){
                        unset($user_process_list[$key]);
                    }else{
                        $total_emails[$p++] = $us['emailid'];
                    }
                }
                $s= 0;
                $date_arr = array();
                
                foreach($user_process_list as $key => $us){
                    if(find_date_diff($this->config->item("cut_off_date"),$us['enrolled_date']) > 0){
                        $span = "+2 years";
                    }else{
                        $span = "+1 years";
                    }
                    
                    $date_diff = find_date_diff(date('Y-m-d', strtotime($us['enrolled_date'].$span)),convert_UTC_to_PST_date(date('Y-m-d')));

                    if($date_diff < 0 ){
                        if($us['reinstate_status'] == 0) {
                            if($us['renewal_status'] == 'Y'){
                                if($this->isRenewExpired($us['course_prim_id']) == 'Y'){
                                    $user_process_list[$key]['status'] = 'Expired';
                                }else{
                                    $user_process_list[$key]['status'] = 'Renewed';
                                }
                            }else{
                                $user_process_list[$key]['status'] = 'Expired';
                            }
                        }else{
                            
                        }
                    }else{
                        if($user_process_list[$key]['status'] == 'A'){
                            $user_process_list[$key]['status'] = 'Active';
                        }else{
                            $user_process_list[$key]['status'] = 'Freezed';
                        }
                    }
                    
                    if($us['reinstate_to'] != "" && (strtotime(date('Y-m-d')) < strtotime($us['reinstate_to']))){
                        $user_process_list[$key]['status'] = 'Reinstated';
                    }
                    
                    $date_arr[$key]  = date('Y-m-d',strtotime($us['enrolled_date']));
                }
            }
            
            asort($date_arr);
            echo 'There are '.count($user_process_list).' user(s) in the list<br/> <br/>';
            $i = 1;
            ?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name</td>
                    <td colspan="2"> Email</td>
                    <td colspan="2"> Phone</td>
                    <td colspan="2"> License Type</td>
                    <td colspan="2"> Course Type</td>
                    <td colspan="2"> Created date</td>
                    <td colspan="2"> Status </td>
                    <td colspan="2"> Reinstated until </td>
                </tr>
                <?php if(!empty($date_arr)){ 
                    foreach($date_arr as $key => $k){ ?>
                 <tr> 
                        <td colspan="2"> <?php echo $i; ?> </td>
                        <td colspan="2"> <?php echo ucfirst($user_process_list[$key]['firstname']).' '.ucfirst($user_process_list[$key]['lastname']); ?> </td>
                        <td colspan="2"> <?php echo $user_process_list[$key]['emailid']; ?> </td>
                        <td colspan="2"> <?php echo $user_process_list[$key]['phone']; ?> </td>
                        <td colspan="2"> <?php echo ($user_process_list[$key]['licensetype'] == 'S') ? 'Sales' : 'Broker'; ?> </td>
                        <td colspan="2"> <?php echo $user_process_list[$key]['course_type']; ?> </td>
                        <td colspan="2"> <?php echo $user_process_list[$key]['enrolled_date']; ?> </td>
                        <td colspan="2"> <?php echo $user_process_list[$key]['status'] == 'A' ? 'Active' : $user_process_list[$key]['status'];  ?>  </td>
                        <td colspan ="32"> <?php echo $user_process_list[$key]['reinstate_to']; ?> </td>
                 </tr>     
                <?php $i++;
                } 
                }else { ?>
                       <tr> 
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                            <td colspan="2">  </td>
                        </tr>   
                <?php } ?>
                </table> <br/> <br/> <br/>
                <?php
        }
        
        function isRenewExpired ($user_course_id = '') {
		
		if(isset ($user_course_id) && '' != $user_course_id){
                    $this->db->order_by("id", "desc");
                    $query = $this->db->get_where('adhi_user_renewdetails', array('reg_courseid' => $user_course_id));
                    
                    if($query ->num_rows() > 0){
                        $result = $query->result_array();
                        foreach($result as $res){
                           $date_diff = find_date_diff(date('Y-m-d', strtotime($res['renew_date'])),convert_UTC_to_PST_date(date('Y-m-d')));
                           if($date_diff < 0){
                               return 'Y';
                           }
                        }
                    }
		}
                
		return 'N';
	}
        
        function getCrossRefUsers(){
            
            /* Trial Users with status pending, active, expired and are not upgraded to normal user */            
            $this->db->select("email, concat_ws(' ', first_name, last_name) as name, phone, status", FALSE);
            $this->db->from('adhi_trial_users');
            $this->db->where('status<>2', NULL, FALSE);
            $this->db->where('email NOT IN (SELECT emailid FROM adhi_user)', NULL, FALSE);
            $trial_user_list = $this->db->get();
            
            $trial_user_arr = array();
            if($trial_user_list->num_rows() > 0){
                $trial_user_arr = $trial_user_list->result_array();
            }
           
            /* Users that are not completed the registration */            
            $this->db->select("reg_email as email, concat_ws(' ', reg_first_name, reg_last_name) as name, reg_phone as phone, status");
            $this->db->from('adhi_reg_in_process');
            $this->db->where('reg_email NOT IN (SELECT emailid FROM adhi_user)', NULL, FALSE);
            $this->db->where('status', 1);
            $attempted_user_list = $this->db->get();
            
            $attempted_user_arr = array();
            if($attempted_user_list->num_rows() > 0){
                $attempted_user_arr =$attempted_user_list->result_array();                
            }
            
            
            /* Cross Ref User whoose email not in adhi user */            
            $this->db->select("email, name, phone");
            $this->db->from('CrossRefFInal');
            $this->db->where('email NOT IN (SELECT emailid FROM adhi_user)', NULL, FALSE);
            $check_user_list = $this->db->get();
            
            $check_user_arr = array();
            if($check_user_list->num_rows() > 0){
                $check_user_arr =$check_user_list->result_array();                
            }
            
            
            /* Guest pass not in adhi user */    
            $this->db->select('new_user_name as name, new_user_email_id as email, new_user_phone_number as phone, cron_status as status');
            $this->db->where('cron_status NOT IN (3,2) AND new_user_email_id NOT IN (SELECT emailid FROM adhi_user)', NULL, FALSE);
            $this->db->from('adhi_new_user');
            $guestpass_list = $this->db->get();
            
            $guestpass_arr = array();
            if($guestpass_list->num_rows() > 0){
                $guestpass_arr =$guestpass_list->result_array();                
            }
            
            echo '<pre>';
            echo 'Trial User  = '. count($trial_user_arr);
            echo '<br/>Attempted User = ' . count($attempted_user_arr);
            echo '<br/>Cross Ref User = ' . count($check_user_arr);
            echo '<br/>Guest Pass  = ' . count($guestpass_arr);
            
            echo '<br/><b>Total</b> ='. (count($guestpass_arr)+count($guestpass_arr)+count($attempted_user_arr)+count($trial_user_arr));
            
            $out = array_merge($trial_user_arr, $attempted_user_arr, $check_user_arr, $guestpass_arr);
            
            $result = $this->unique_multidim_array($out, 'email');
            
            $final_email_list = $result;
            
            echo '<br/There are '.count($result).' user(s) in the list but not unsubscribed/registered<br/> <br/>';
            $i = 1;
            ?>
                <table border="1">
                <tr>
                    <td colspan="2"> S.No </td>
                    <td colspan="2"> Name</td>
                    <td colspan="2"> Email</td>
                    <td colspan="2"> Phone</td>
                </tr>
                <?php if(!empty($final_email_list)){ 
                    $inc = 0;
                    foreach($final_email_list as $key => $val){   ?>
                 <tr> 
                        <td colspan="2"> <?php echo ++$inc; ?> </td>
                        <td colspan="2"> <?php echo ('' != $val['name']) ? $val['name'] : '&nbsp;'; ?> </td>
                        <td colspan="2"> <?php echo ('' != $val['email']) ? $val['email']: '&nbsp;'; ?> </td>
                        <td colspan="2"> <?php echo ('' != $val['phone']) ? $val['phone']: '&nbsp;'; ?> </td>
                </tr>     
                <?php $i++;
                   } 
                }
                ?>
                </table> <br/> <br/> <br/><?php
        }
        
        
        function unique_multidim_array($array, $key) { 
            $temp_array = array(); 
            $i = 0; 
            $key_array = array(); 

            foreach($array as $val) { 
                if (!in_array($val[$key], $key_array)) { 
                    $key_array[$i] = $val[$key]; 
                    $temp_array[$i] = $val; 
                } 
                $i++; 
            } 
            return $temp_array; 
        }

        function get_course_ordered_book_count($order_id){
            $this->db->select('count(courseid) as count');
            $this->db->from('adhi_user_course');
            $this->db->where('orderid', $order_id);
            $result = $this->db->get();

            if($result->num_rows() > 0){
                return $result->row()->count;
            }
            return FALSE;
        }

        function getStudentList($date_onwards){
            //veinflower ||inclus.stars-and-glory.stars-and-glor
            $exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|veinflower|inclus.stars-and-glory|.xzzy.info$|.pw$|dispostable.com$|rainconcert.in$|qq.com$';
            //$exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|.$';
            $enable_debuging = false;
            $this->db->select('u.id, u.firstname,u.lastname, u.emailid,u.phone,u.address,u.city,u.state,u.zipcode, u.country, uc.enrolled_date');
            $this->db->where(array('u.status' => 'A', "DATE_FORMAT(uc.enrolled_date, '%Y/%m/%d') >=" => $date_onwards));
            $this->db->order_by('uc.enrolled_date','ASC');
            $this->db->join('adhi_user_course uc','uc.userid = u.id');
            $this->db->from('adhi_user u');
            $result 		= $this->db->get();
            $students_list	= $result->result();

            /* completed students ids */
            $completed_student_ids = array();
			$sql	=	"SELECT userid FROM (
								SELECT * ,
						                	IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
									IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
								FROM 
									adhi_user_course ac 
								GROUP BY 
									userid
						
								) AS temp 
						WHERE t2 =t1 AND t2 > 0 {$where_cond}";
		
			$res	=	$this->db->query ($sql);
			
		
			if($res->num_rows()>0){
				
				$data	=	$res->result_array();

				foreach ($data as $res){					
					array_push($completed_student_ids, $res['userid']);
				}
			}
            
            $students= array();
            if($students_list){
        		foreach ($students_list as $key => $student) {
        			if(array_key_exists($student->id, $students) 
        				&& strtotime($students[$student->id]['date']) > strtotime($student->enrolled_date)
    				){
						unset($students[$student->id]);
        			}
        			$students[$student->id] = array(
        				'name' 		=> $student->firstname. ' '. $student->lastname, 
        				'email' 	=> $student->emailid, 
        				'phone' 	=> $student->phone, 
        				'address' 	=> $student->address.', '.$student->city.', '.$student->state.' '.$student->zipcode.', '.$student->country, 
        				'date'		=> date('m-d-Y', strtotime($student->enrolled_date)),
        				'has_course_completed' => (FALSE === array_search($student->id, $completed_student_ids)) ? FALSE: TRUE 
        			);	
        		}
            }
		
            
            
            
            echo 'There are '.count($students).' user(s) in the list<br/> <br/>';
            $i = 1;
            ?>
                <table border="1">
                <tr>
                    <td > S.No </td>
                    <td > Name</td>
                    <td > Email</td>
		    <td > Phone</td>
                    <td > Address</td>
                    <td > Date</td>
                    <td > Course Completed</td>
                </tr>
                <?php if(!empty($students)){ 
                    foreach($students as $key => $student){ ?>
                 <tr> 
                        <td > <?php echo $i; ?> </td>
                        <td > <?php echo $student['name']; ?> </td>
                        <td > <?php echo strtolower($student['email']); ?> </td>
						<td > <?php echo $student['phone']; ?> </td>
						<td > <?php echo $student['address']; ?> </td>
                        <td > <?php echo $student['date']; ?> </td>
                        <td > <?php echo $student['has_course_completed'] ? 'Yes' : 'No'; ?> </td>
                 </tr>     
                <?php $i++;
                } 
                }else { ?>
                       <tr> 
                            <td colspan="7"> No data found </td>
                        </tr>   
                <?php } ?>
                </table> <br/> <br/> <br/>
                <?php
        }

        function updateStudentRegDate(){
            $enable_debuging = false;
            $this->db->select('u.id, u.firstname,u.lastname, u.emailid,u.phone,u.address,u.city,u.state,u.zipcode, u.country, uc.enrolled_date');
            $this->db->order_by('uc.enrolled_date','ASC');
            $this->db->join('adhi_user_course uc','uc.userid = u.id');
            $this->db->from('adhi_user u');
            $result 		= $this->db->get();
            $students_list	= $result->result();
            
            $students= array();
            if($students_list){
        		foreach ($students_list as $key => $student) {
        			if(array_key_exists($student->id, $students) 
        				&& strtotime($students[$student->id]) > strtotime($student->enrolled_date)
    				){
						unset($students[$student->id]);
        			}
        			$students[$student->id] = date('m-d-Y', strtotime($student->enrolled_date));
        		}
            }
            $updated_count = 0;
            if($students){
				foreach ($students as $user_id => $date){
					$this->db->where('id', $user_id);
					$details	=	array('created_at' => date('Y-m-d H:i:s', strtotime($date)));
					$this->db->update('adhi_user', $details);
					$updated_count++;
				}
            }
            

            echo $updated_count.' students registration date updated!';exit;
        }

    function getExpiredStudentListWhoNotCompletedAnyCourse(){
        //veinflower ||inclus.stars-and-glory.stars-and-glor
        $exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|veinflower|inclus.stars-and-glory|.xzzy.info$|.pw$|dispostable.com$|rainconcert.in$|qq.com$';
        //$exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|.$';
        $enable_debuging = false;
        $date_after   = date('Y-m-d', strtotime('-1 year'));
        $this->db->select('u.id, u.firstname,u.lastname, u.emailid,u.phone,u.address,u.city,u.state,u.zipcode, u.country, uc.enrolled_date, c.course_name, uc.status pass_status');
        $this->db->where(array('u.status' => 'A', "DATE_FORMAT(uc.enrolled_date, '%Y/%m/%d') <=" => $date_after));
        $this->db->order_by('uc.enrolled_date','ASC');
        $this->db->join('adhi_user_course uc','uc.userid = u.id');
        $this->db->join('adhi_courses c','uc.courseid = c.id');
        $this->db->from('adhi_user u');
        $result 		= $this->db->get();
        $students_list	= $result->result();

        /* completed students ids */
        $completed_student_ids = array();
        $sql	=	"SELECT userid FROM (
								SELECT * ,
						                	IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
									IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
								FROM 
									adhi_user_course ac 
								GROUP BY 
									userid
						
								) AS temp 
						WHERE t2 =t1 AND t2 > 0 ";

        $res	=	$this->db->query ($sql);


        if($res->num_rows()>0){

            $data	=	$res->result_array();

            foreach ($data as $res){
                array_push($completed_student_ids, $res['userid']);
            }
        }
        $students= array();
        if($students_list){
            $incomplete_courses = array();
            foreach ($students_list as $key => $student) {
                if(array_search($student->id, $completed_student_ids)){ continue;}
                if(!array_key_exists($student->id, $incomplete_courses)){
                    $incomplete_courses[$student->id] = array();
                }
                if('P' != $student->pass_status){
                    array_push($incomplete_courses[$student->id], $student->course_name);
                }

                if(array_key_exists($student->id, $students)
                    && strtotime($students[$student->id]['date']) > strtotime($student->enrolled_date)
                ){
                    unset($students[$student->id]);
                }
                $students[$student->id] = array(
                    'name' 		=> $student->firstname. ' '. $student->lastname,
                    'email' 	=> $student->emailid,
                    'phone' 	=> $student->phone,
                    'address' 	=> $student->address.', '.$student->city.', '.$student->state.' '.$student->zipcode.', '.$student->country,
                    'date'		=> date('m-d-Y', strtotime($student->enrolled_date)),
                    'incomplete_courses'    => implode(', ', $incomplete_courses[$student->id])
                );
            }
        }




        echo 'There are '.count($students).' user(s) in the list<br/> <br/>';
        $i = 1;
        ?>
        <table border="1">
            <tr>
                <td > S.No </td>
                <td > Name</td>
                <td > Email</td>
                <td > Phone</td>
                <td > Address</td>
                <td > Enrolled Date</td>
                <td > Incomplete Courses</td>
            </tr>
            <?php if(!empty($students)){
                foreach($students as $key => $student){ ?>
                    <tr>
                        <td > <?php echo $i; ?> </td>
                        <td > <?php echo $student['name']; ?> </td>
                        <td > <?php echo strtolower($student['email']); ?> </td>
                        <td > <?php echo $student['phone']; ?> </td>
                        <td > <?php echo $student['address']; ?> </td>
                        <td > <?php echo $student['date']; ?> </td>
                        <td > <?php echo $student['incomplete_courses']; ?> </td>
                    </tr>
                    <?php $i++;
                }
            }else { ?>
                <tr>
                    <td colspan="6"> No data found </td>
                </tr>
            <?php } ?>
        </table> <br/> <br/> <br/>
        <?php
    }

    function _get_adhi_courses(){
        $result 	= $this->db->get('adhi_courses');
        $courses	= $result->result();
        $coruse_arr = array();
        foreach ($courses as $course){
            $coruse_arr[$course->id] = $course->course_name;
        }
        return $coruse_arr;
    }
    
    
    function getEditionThreeUsers(){
                ini_set("display_errors",1);
                error_reporting(E_ALL);
                $exclude_email_format = 'yandex.com$|mail.ru$|poczta.pl$|.top$|yandex.tr$|yandex.ru$|yandex.by$|.ru$|.xyz$|.x$|.xy$|.t$|.to$|veinflower|inclus.stars-and-glory|.xzzy.info$|.pw$|dispostable.com$|rainconcert.in$|qq.com$|rainconcert3@$|rainconcert1@$|rainconcert555@$|jomon$|syama$|aarthikaindia.com$';
        
		$this->db->select("au.firstname, au.lastname,au.emailid,au.phone,"
                        . "auc.enrolled_date,auc.final_score,auc.status,ac.course_name,"
                        . "aes.edition_no");
		$this->db->where('aes.edition_no',3);
                $this->db->where("au.emailid NOT REGEXP '$exclude_email_format'", NULL, FALSE);
		$this->db->from('adhi_user au');
		$this->db->join('adhi_user_course auc','auc.userid = au.id','left');
                $this->db->join('adhi_courses ac','ac.id = auc.courseid','left');
                $this->db->join('adhi_edition_summary aes','aes.course_id = ac.id','left');
                $this->db->order_by("au.id","ASC");
		$query = $this->db->get();
		$students =  $query->result_array();
                
                $exclude_student_string = "dd , soumya , Kartik Subramaniam, Geetha Subramaniam, Amal , Student , admin, Chriju , Mark Subramaniam, jomon , Rain Test User, Rahul, Chriju ,  Sophia Safari test  , Crystal Riplie, Sophia Lopez";
                $exclude_student = array_map('trim', explode(',', $exclude_student_string));
                
                //echo 'There are '.count($students).' user(s) in the list<br/> <br/>';
                $i = 1;
                ?>
                <table border="1">
                    <tr>
                        <td > S.No </td>
                        <td > Name</td>
                        <td > Email</td>
                        <td > Phone</td>
                        <td > Enrolled Date</td>
                        <td > Course Name</td>
                        <td > Edition</td>
                        <td > Score</td>
                        <td > Status</td>
                    </tr>
                    <?php if(!empty($students)){
                        foreach($students as $key => $student){
                            if(!in_array($student['firstname'],$exclude_student) && !in_array($student['firstname']." ".$student['lastname'],$exclude_student)) { 
                                
                                $name = strtolower($student['firstname']." ".$student['lastname']);
                                
                                if (strpos($name,'test') === 0 || strpos($name, 'tests') === 0 || strpos($name, 'exam') === 0 ||
                                    $this->endsWith($name,"test") || $this->endsWith($name,"tests") || $this->endsWith($name,"exam") ) {
                                        continue ;          
                                }
                                
                                ?>
                                    <tr>
                                        <td > <?php echo $i; ?> </td>
                                        <td > <?php echo $student['firstname']." ".$student['lastname']; ?> </td>
                                        <td > <?php echo strtolower($student['emailid']); ?> </td>
                                        <td > <?php echo $student['phone']; ?> </td>
                                        <td > <?php echo $student['enrolled_date']; ?> </td>
                                        <td > <?php echo $student['course_name']; ?> </td>
                                        <td > <?php echo $student['edition_no']; ?> </td>
                                        <td > <?php echo $student['final_score']; ?> </td>
                                        <td > <?php echo $student['status']; ?> </td>
                                    </tr>
                                    <?php $i++;
                            }
                        }
                    }else { ?>
                        <tr>
                            <td colspan="6"> No data found </td>
                        </tr>
                    <?php } ?>
                </table> <br/> <br/> <br/>
                <?php
		
	}
        
        function endsWith($currentString, $target)
        {
            $length = strlen($target);
            if ($length == 0) {
                return true;
            }

            return (substr($currentString, -$length) === $target);
        }
        
        //Set all the students enrolled from 11/16/2018 until now to Edition 3. 
    //If they have attended quizzes of edition 1 and 2, reset their scores

    function setEdition3ForUsersOptionA(){
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        $optionALimitDate = $this->config->item("optionALimitDate");
        
        // Get all courses that are not edition 3 and above limit date
        $this->db->select("U.id,U.courseid,U.userid,U.enrolled_date,E.edition_no");
        $this->db->from('adhi_user_course U');
        $this->db->join('adhi_courses C','U.courseid = C.id');
        $this->db->join('adhi_edition_summary E','C.id = E.course_id');
        $this->db->where(array('E.edition_no !=' => 3, 'U.enrolled_date >=' => $optionALimitDate));
        $all_query	=   $this->db->get();
        $all_result     =   $all_query->result_array();
                
        //echo $this->db->last_query();exit;
        //echo "<br/><br/>";
        //echo count($all_result);
        
        if(!empty($all_result)){
            foreach($all_result as $all_res){
                // Reset already attended quizzes
                $this->db->select ("U.id");
                $this->db->from("adhi_user_quiz U");
                $this->db->join('adhi_quiz_list Q','U.quiz_id = Q.id');
                $this->db->join('adhi_edition_summary E','Q.edition = E.id');
                $this->db->where (array('U.user_id' => $all_res['userid'],'E.edition_no !=' => 3));
                $reset_query	=   $this->db->get();
                $all_reset     =   $reset_query->result_array();
                
                if(!empty($all_reset)){
                    foreach($all_reset as $all_rese){
                        $this->db->where('id', $all_rese['id']);
                        $this->db->delete('adhi_user_quiz');
                    }
                }
                
                // Set edition 3 for all courses
                $this->db->select ("id");
		$this->db->where (array('edition_no' => 3,'course_id' => $all_res['courseid']));
		$this->db->from("adhi_edition_summary");
		$edition_query	= $this->db->get();
		$edition    = $edition_query->row_array();
                
                $this->db->where('id', $all_res['id']);
		$this->db->update('adhi_user_course', array('edition'=>$edition['id']));
            }
        }
    }
    
    //Extract deleted quizzes
    function setEdition3ForUsersOptionB1(){
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        $this->load->plugin ( 'exel_reader' );
        
        // Get all deleted  quizzes
        $this->db->select("id,course_id,quiz_status,edition,xls_path");
        $this->db->from('adhi_quiz_list');
        $this->db->where(array('quiz_status' => ''));
        $all_query	=   $this->db->get();
        $all_result     =   $all_query->result_array();
        
        
        if(!empty($all_result)){
            foreach($all_result as $all_res){
                
                //Get edition 2 ID
                $this->db->select ("id");
		$this->db->where (array('edition_no' => 2,'course_id' => $all_res['course_id']));
		$this->db->from("adhi_edition_summary");
		$edition_query	= $this->db->get();
		$edition    = $edition_query->row_array();
                
                
                $xls_array = explode("/",$all_res['xls_path']);
                $check = remote_file_exists("https://mockup.adhischools.com/uploads/".$xls_array[count($xls_array) - 1]);
                
                if($check === FALSE){
                    continue;
                }else{
                    print '<pre>';
                    print_r($all_res);
                    exit;
                    $xls_path = str_replace("adhischool", "mockup-adhischool", $all_res['xls_path']);
                    read_excel( $xls_path, $all_res['id'], $edition['id'], 'quiz' );
                    
                    $this->db->where('id', $all_res['id']);
                    $this->db->update('adhi_quiz_list', array('quiz_status' => 'E','edition_no' => $edition['id']));
                }
            }
        }
    }
    
    //Set old (Edition 1) and disabled quizzes to Edition 2
    function setEdition3ForUsersOptionB2(){
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        
        // Get all quizzes that are not enabled
        $this->db->select("id,course_id,quiz_status");
        $this->db->from('adhi_quiz_list');
        $this->db->where(array('quiz_status' => 'D'));
        $all_query	=   $this->db->get();
        $all_result     =   $all_query->result_array();
        
        //echo $this->db->last_query();
        //echo "<br/><br/>";
        //exit;
        
        if(!empty($all_result)){
            foreach($all_result as $all_res){
                //Get edition 2 ID
                $this->db->select ("id");
		$this->db->where (array('edition_no' => 2,'course_id' => $all_res['course_id']));
		$this->db->from("adhi_edition_summary");
		$edition_query	= $this->db->get();
		$edition    = $edition_query->row_array();
                
                $this->db->where('id', $all_res['id']);
		$this->db->update('adhi_quiz_list', array('quiz_status' => 'E','edition_no' => $edition['id']));
                
            }
        }
    }
    
    //All enrollments from 1/1/2003 - 11/15/2018 shall be set on these quizzes,
    // if the students have attended quizzes of edition 1 or 3 then  reset all these from new so all 
    // appear as never attended for quiz 

    function setEdition3ForUsersOptionC(){
        exit;
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        $optionCFLimitDate = "2003-01-01";
        $optionCSLimitDate = "2018-11-15";
        
        // Get all courses that are not edition 3 and between limit date
        $this->db->select("U.id,U.courseid,U.userid,U.enrolled_date,E.edition_no");
        $this->db->from('adhi_user_course U');
        $this->db->join('adhi_courses C','U.courseid = C.id');
        $this->db->join('adhi_edition_summary E','C.id = E.course_id');
        $this->db->where(array('E.edition_no !=' => 2, 'U.enrolled_date >=' => $optionCFLimitDate,'U.enrolled_date <=' => $optionCSLimitDate));
        $this->db->where_in('C.id', array(5,6,8));
        $all_query	=   $this->db->get();
        $all_result     =   $all_query->result_array();
                
        echo $this->db->last_query();
        echo "<br/><br/>";
        echo count($all_result);exit;
        
        if(!empty($all_result)){
            foreach($all_result as $all_res){
                // Reset already attended quizzes
                $this->db->select ("U.id");
                $this->db->from("adhi_user_quiz U");
                $this->db->join('adhi_quiz_list Q','U.quiz_id = Q.id');
                $this->db->join('adhi_edition_summary E','Q.edition = E.id');
                $this->db->where (array('U.user_id' => $all_res['userid'],'E.edition_no !=' => 2));
                $reset_query	=   $this->db->get();
                $all_reset     =   $reset_query->result_array();
                
                if(!empty($all_reset)){
                    foreach($all_reset as $all_rese){
                        $this->db->where('id', $all_rese['id']);
                        $this->db->delete('adhi_user_quiz');
                    }
                }
                
                // Set edition 2 for all courses
                $this->db->select ("id");
		$this->db->where (array('edition_no' => 2,'course_id' => $all_res['courseid']));
		$this->db->from("adhi_edition_summary");
		$edition_query	= $this->db->get();
		$edition    = $edition_query->row_array();
                
                $this->db->where('id', $all_res['id']);
		$this->db->update('adhi_user_course', array('edition'=>$edition['id']));
            }
        }
    }
        
    
    //All enrollments prior to 1/1/2003 shall be set on these quizzes as edition 1,
    // if the students have attended quizzes of edition 2 or 3 then  reset all these from new so all 
    // appear as never attended for quiz 

    function setEdition3ForUsersOptionD(){
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        $optionCFLimitDate = "2003-01-01";
        
        // Get all courses that are not edition 3 and between limit date
        $this->db->select("U.id,U.courseid,U.userid,U.enrolled_date,E.edition_no");
        $this->db->from('adhi_user_course U');
        $this->db->join('adhi_courses C','U.courseid = C.id');
        $this->db->join('adhi_edition_summary E','C.id = E.course_id');
        $this->db->where(array('E.edition_no !=' => 1, 'U.enrolled_date <' => $optionCFLimitDate));
        $all_query	=   $this->db->get();
        $all_result     =   $all_query->result_array();
                
        echo $this->db->last_query();exit;
        //echo "<br/><br/>";
        //echo count($all_result);
        
        if(!empty($all_result)){
            foreach($all_result as $all_res){
                // Reset already attended quizzes
                $this->db->select ("U.id");
                $this->db->from("adhi_user_quiz U");
                $this->db->join('adhi_quiz_list Q','U.quiz_id = Q.id');
                $this->db->join('adhi_edition_summary E','Q.edition = E.id');
                $this->db->where (array('U.user_id' => $all_res['userid'],'E.edition_no !=' => 1));
                $reset_query	=   $this->db->get();
                $all_reset     =   $reset_query->result_array();
                
                if(!empty($all_reset)){
                    foreach($all_reset as $all_rese){
                        $this->db->where('id', $all_rese['id']);
                        $this->db->delete('adhi_user_quiz');
                    }
                }
                
                // Set edition 1 for all courses
                $this->db->select ("id");
		$this->db->where (array('edition_no' => 1,'course_id' => $all_res['courseid']));
		$this->db->from("adhi_edition_summary");
		$edition_query	= $this->db->get();
		$edition    = $edition_query->row_array();
                
                $this->db->where('id', $all_res['id']);
		$this->db->update('adhi_user_course', array('edition'=>$edition['id']));
            }
        }
    }
        /**
	 * function to select the user details from temp table
	 *
	 * @return temp userdetails
	 */
	function select_temp_userdetails ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '',$split = true) {
            $this->db->select ("u.*");
            $this->db->from('temp_adhi_user u');
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

            if('S' == $srcLicense || 'B' == $srcLicense)
                $this->db->where('u.licensetype', $srcLicense);

            $this->db->where('u.success', 0);
            $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');

	    $this->db->orderby('u.temp_id','DESC');
            $query	=	$this->db->get();
            return($query->result());
	}
	/**
	 * function to get the count of user details from temp table
	 *
	 * @return count of temp users
	 */
	function qry_count_temp_userdetails ($srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = ''){
            if('' != $srchFname)
                $this->db->like('u.firstname',$srchFname,'both');
            if('' != $srchLname)
                $this->db->like('u.lastname',$srchLname,'both');
            if('' != $srchEmail)
                $this->db->like('u.emailid',$srchEmail,'both');

            if('' != $src_phone)
                $this->db->where('u.phone',$src_phone);

            if('S' == $srcLicense || 'B' == $srcLicense)
                $this->db->where('u.licensetype', $srcLicense);

            $this->db->where('u.success', 0);
            $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');  

            $this->db->from('temp_adhi_user u');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;

        }
        
        /**
	 * function to get the details of a single temp user
	 *
	 * @param int $userid
	 * @return user details
	 */
	function select_single_temp_userdetails($userid){
		$this->db->where('temp_id',$userid);
		$this->db->select ("*");
		$query	=	$this->db->get('temp_adhi_user');
		return($query->row());
	}
        
        /**
	 * function to select the course details of a selected temp user
	 *
	 * @param int $userid
	 * @return course details
	 */
	function select_single_temp_user_course_details($userid){
		$this->db->where('AUC.userid', $userid);
		$this->db->select("AUC.*,AC.parent_course_name,AC.course_name,O.ship_status, AC.course_code, AC.amount");
		$this->db->from('temp_adhi_user_course AUC');
		$this->db->join('adhi_courses AC','AUC.courseid = AC.id');
		$this->db->join('temp_adhi_orderdetails O','AUC.orderid = O.temp_id');
		$this->db->orderby('AUC.courseid');
		$query	=	$this->db->get();
		return($query->result());
	}
        
        /**
	 * function to select the order details of a single user
	 *
	 * @param int $userid
	 * @return unknown
	 */
	function select_single_temp_user_order_details($userid){
		$this->db->where('userid',$userid);
		$this->db->select ("temp_id,userid,transactionid,total_amount,orderdate,delivered_date,trackingno,label_path,"
                        . "last_trackdate,current_location,status,ship_method,ship_rate,course_price,b_country,b_state,b_city,b_address,b_zipcode,"
                        . "s_state,s_city,s_address,s_zipcode, s_country, is_promocode_applied, promocode_details, packaging_type");
		$query	=	$this->db->get('temp_adhi_orderdetails');
		return($query->result());
	}
        
        /**
	 * function to select the renew reenroll details from temp table
	 *
	 * @return temp userdetails
	 */
	function select_renew_reenroll_details ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '',$src_type ='', $split = true) {
            $this->db->select ("u.*,rro.id as order_id");
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

            if('S' == $srcLicense || 'B' == $srcLicense)
                $this->db->where('u.licensetype', $srcLicense);
            
            if('' != $src_type){
                if(1 == $src_type){
                    $this->db->where('rro.type',0);       // Apply New Course
                }
                
                if(2 == $src_type){
                    $this->db->where('rro.type',1);       // Renew & Group Renew
                }
                
                if(3 == $src_type){
                    $this->db->where('rro.type',2);       // Re enroll
                }
            }
                

            $this->db->where('rro.success', 0);
            $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');
            $this->db->join('renew_reenroll_orderdetails rro','rro.userid = u.id');

	    $this->db->orderby('rro.id','DESC');
            $query	=	$this->db->get();
            return($query->result());
	}
	/**
	 * function to get the count of user details from temp table
	 *
	 * @return count of temp users
	 */
	function qry_count_renew_reenroll_details ($srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '',$src_type =''){
            if('' != $srchFname)
                $this->db->like('u.firstname',$srchFname,'both');
            if('' != $srchLname)
                $this->db->like('u.lastname',$srchLname,'both');
            if('' != $srchEmail)
                $this->db->like('u.emailid',$srchEmail,'both');

            if('' != $src_phone)
                $this->db->where('u.phone',$src_phone);

            if('S' == $srcLicense || 'B' == $srcLicense)
                $this->db->where('u.licensetype', $srcLicense);
            
            if('' != $src_type){
                if(1 == $src_type){
                    $this->db->where('rro.type',0);       // Apply New Course
                }
                
                if(2 == $src_type){
                    $this->db->where('rro.type',1);       // Renew & Group Renew
                }
                
                if(3 == $src_type){
                    $this->db->where('rro.type',2);       // Re enroll
                }
            }

            $this->db->where('rro.success', 0);
            $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');  
            $this->db->join('renew_reenroll_orderdetails rro','rro.userid = u.id');
            
            $this->db->from('adhi_user u');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;

        }
        
        /**
	 * function to select the course details of a selected temp user
	 *
	 * @param int $userid
	 * @return course details
	 */
	function select_single_renew_course_details($userid,$order_id){
		$this->db->where('AUC.org_user_id', $userid);
                $this->db->where('AUC.order_id', $order_id);
		$this->db->select("AUC.*,AC.parent_course_name,AC.course_name,O.status, AC.course_code, AC.amount,AUC.course_id,AUC.edition");
		$this->db->from('renew_reenroll_course_details AUC');
		$this->db->join('adhi_courses AC','AUC.course_id = AC.id');
		$this->db->join('renew_reenroll_orderdetails O','AUC.order_id = O.id');
		$this->db->orderby('AUC.course_id');
		$query	=	$this->db->get();
		return($query->result());
	}
        
        /**
	 * function to select the order details of a single user
	 *
	 * @param int $userid
	 * @return unknown
	 */
	function select_single_renew_user_order_details($userid,$orderid){
		$this->db->where('userid',$userid);
                $this->db->where('id',$orderid);
		$this->db->select ("*");
                $this->db->orderby('id','DESC');
                $this->db->limit(1);
		$query	=	$this->db->get('renew_reenroll_orderdetails');
		return($query->result());
	}
        
        function getCertificateDownloads(){
            $this->db->select ("ACD.*,AU.firstname,AU.lastname,AU.emailid,AU.phone,AC.course_name");
            $this->db->join('adhi_user AU','ACD.user_id = AU.id');
            $this->db->join('adhi_courses AC','ACD.course_id = AC.id');
            $query	=	$this->db->get('adhi_certificate_downloads ACD');
            $students = $query->result_array();
            $i = 1;
            ?>
            <table border="1">
                    <tr>
                        <td > S.No </td>
                        <td > Name</td>
                        <td > Email</td>
                        <td > Phone</td>
                        <td > Course Name</td>
                        <td > Enrolled Date</td>
                        <td > Passed Date</td>
                        <td > Download Date</td>
                    </tr>
                    <?php if(!empty($students)){
                        foreach($students as $key => $student){
                            ?>
                                    <tr>
                                        <td > <?php echo $i; ?> </td>
                                        <td > <?php echo $student['firstname']." ".$student['lastname']; ?> </td>
                                        <td > <?php echo strtolower($student['emailid']); ?> </td>
                                        <td > <?php echo $student['phone']; ?> </td>
                                        <td > <?php echo $student['course_name']; ?> </td>
                                        <td > <?php echo $student['enrolled_date']; ?> </td>
                                        <td > <?php echo $student['passed_date']; ?> </td>
                                        <td > <?php echo $student['download_date']; ?> </td>
                                    </tr>
                                    <?php $i++;
                            }
                    }else { ?>
                        <tr>
                            <td colspan="6"> No data found </td>
                        </tr>
                    <?php } ?>
                </table> <br/> <br/> <br/>
                <?php

        }
        
        /**
	 * function to select the user details
	 *
	 * @return userdetails
	 */
	function bb_select_userdetails_completed ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '', $src_zip = '',  $src_city = '',  $course_type = '' ,$brokerage = '', $completed = true, $split = true) {
		$where_cond = ('S' == $srcLicense || 'B' == $srcLicense ) ? " AND licensetype = '{$srcLicense}' " : '';
		$data	=	array();
		$sql	=	"SELECT userid FROM (
				SELECT * ,
		                	IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
					IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
				FROM 
					adhi_user_course ac 
				GROUP BY 
					userid
		
				) AS temp 
		WHERE t2 =t1 AND t2 > 0 ";
		
		$res	=	$this->db->query ($sql);
		
		if($res->num_rows()>0){
			
			$data	=	$res->result_array ();

			foreach ($data as $res){
				
				$user_ID[]	=	$res['userid'];
			}
			
			$this->db->select ("u.*,aupp.broker_name");
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
                        if('' != $src_city)
                            $this->db->where("u.city LIKE '%{$src_city}%'", NULL, FALSE);
                        if('' != $src_zip)
                            $this->db->where('u.zipcode',$src_zip);
                        if('' != $course_type){
                            $this->db->where('LOWER(uct.course_type) = LOWER(\''.$course_type.'\')', NULL, FALSE);
                        }
                        if('' != $srcLicense)
                            $this->db->where('u.licensetype',$srcLicense);
                        
                        if('' != $brokerage){
                            $this->db->like('aupp.broker_name',$brokerage,'both');
                        }
                        
                        $this->db->where('aupp.item',"obtained_license");
                        $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');
                        $this->db->join('adhi_user_profile_progress aupp','aupp.user_id = u.id');

                        if($completed){
                            $this->db->where_in('u.id',$user_ID);
                        }else{
                            $this->db->where_not_in('u.id',$user_ID);
                        }
                        $this->db->orderby('u.id','DESC');
			$query	=	$this->db->get();
			return($query->result());

                }

	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function bb_qry_count_userdetails_completed ($srchFname = '',$srchLname = '',$srchEmail = '', $srcLicense = '', $src_phone = '', $src_zip = '', $src_city = '',  $course_type = '', $completed = true,$brokerage = ''){
		
		
		$where_cond = ('S' == $srcLicense || 'B' == $srcLicense ) ? " AND licensetype = '{$srcLicense}' " : '';
		$data	=	array();
		$sql	=	"SELECT userid FROM (
				SELECT * ,
		                	IFNULL((SELECT count(status) AS tt1 FROM adhi_user_course WHERE status='P' AND ac.userid = userid), 0) AS t1, 
					IFNULL((SELECT count(status) AS tt2  FROM adhi_user_course WHERE ac.userid = userid), 0) AS t2 
				FROM 
					adhi_user_course ac 
				GROUP BY 
					userid
		
				) AS temp 
		WHERE t2 =t1 AND t2 > 0 ";
		
		$res	=	$this->db->query ($sql);
		
		
		if($res->num_rows()>0){
			
			$data	=	$res->result_array ();

			foreach ($data as $res){
				
				$user_ID[]	=	$res['userid'];
			}

		    if('' != $srchFname)
		    	$this->db->like('u.firstname',$srchFname,'both');
		    if('' != $srchLname)
		    	$this->db->like('u.lastname',$srchLname,'both');
		    if('' != $srchEmail)
		    	$this->db->like('u.emailid',$srchEmail,'both');
		    if('' != $src_phone)
	    	$this->db->where('u.phone',$src_phone);
                if('' != $src_city)
	    	$this->db->where("u.city LIKE '%{$src_city}%'", NULL, FALSE);
                if('' != $src_zip)
	    	$this->db->where('u.zipcode',$src_zip);
            
            if('' != $course_type){
                $this->db->where('LOWER(uct.course_type) = LOWER(\''.$course_type.'\')', NULL, FALSE);
            }
            if('' != $srcLicense)
	    	$this->db->where('u.licensetype',$srcLicense);
            
            if('' != $brokerage){
                $this->db->like('aupp.broker_name',$brokerage,'both');
            }
            
            $this->db->where('aupp.item',"obtained_license");
            $this->db->join('adhi_user_course_types uct','uct.id = u.course_user_type');
            $this->db->join('adhi_user_profile_progress aupp','aupp.user_id = u.id');
            if($completed){
                $this->db->where_in('u.id',$user_ID);
            }else{
                $this->db->where_not_in('u.id',$user_ID);
            }
            $this->db->from('adhi_user u');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;

            }
            $this->db->from('adhi_user');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;

	}
        
}