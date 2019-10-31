<?php 
class Userreg_model extends Model {

  
    function Userreg_model()
    {
        // Call the Model constructor
        parent::Model();
        
    }
	
	function get_state()
    {
		$query= $this->db->get('adhi_states');
		return $query->result_array();
    }
	// generating captcha
	function generate_captcha ($configVal = array (),$from = "")
    {	
        $this->load->plugin ('captcha');
        if (!empty ($configVal))
        {
    		$this->vals = $configVal;
    	}
        else
        {
        	$this->vals = array (
                                    'word'               => '',
                                    'word_length'  	     => 4,
                                    'img_path'       	 => $this->config->item ('captcha_image_path'),
                                   	'img_url'       	 => $this->config->item ('captcha_image_url'),
                                    'font_path'     	 => $this->config->item ('captcha_font_path'),
                                    'img_width'     	 => '206',
                                    'img_height'    	 => 30,
                                    'expiration'     	 => 3600
                                );
        }
        $captcha = create_captcha ($this->vals);
        $this->session->set_userdata ("captcha_word", $captcha['word']);	
        return $captcha;
    }	
	
	
	//shipping services and rate
	function servicesrate($arr)
    {
		$admindet = $arr['admindetails'];
		 $this->load->plugin ('fedex');
		 $this->vals = array(
		 	'weight_units' 	=>	'LBS'
			,8				=>	$admindet[0]['state']// Sender State
			,9				=>	$admindet[0]['zpcode']//Sender Postal Code
			,117			=>	$admindet[0]['country']// Sender Country Code
			,16				=>  $arr['b_state']// Recipient State
			,17				=>  $arr['b_zipcode']//Recipient Postal Code
			,50				=>  $arr['b_country']//Recipient Country Code
			,57				=>	''//Dim Height
			,58				=>	''//Dim Width
			,59				=>	''//Dim Length
			,1116			=>	'IN'// Dim Units
			,1401			=>	$arr['weight']//Total Package Weight/ Shipment total weight
			,1333			=>	'1'//Drop Off Type
			);
			
		  $rates = rateservices ($this->vals);
		  return $rates;
    }
	
	// ship matrial
	function shipmaterial($arr,$admin)
    {
		$this->load->plugin ('fedex');
			 
		 $this->vals = 	  array(
			'weight_units' 	=> 		'LBS'
			,16				=>   	$arr['r_state']
			,13				=>   	$arr['r_address']
			,5				=>   	$admin[0]['company_address']
			,1273			=>		'01'
			,1274			=> 		$arr['r_method']
			,18				=>   	$arr['r_phone']
			,15				=>   	$arr['r_city']
			,23				=>   	'1'
			,9				=>    	$admin[0]['zpcode']
			,183			=>  	$admin[0]['phone']
			,8				=>    	$admin[0]['state']
			,117			=>  	$admin[0]['country']
			,17				=>   	$arr['r_zipcode']
			,50				=>   	$arr['r_country']
			,4				=>    	$admin[0]['company_name']
			,7				=>    	$admin[0]['city']
			,12				=>   	$arr['r_name']
			,1333			=> 		'1'
			,1401			=> 		$arr['courseweight']
			,116 			=> 		1
			,68 			=>  	'USD'
			,1368			=> 		2
			,1369 			=> 		1
			,1370 			=> 		5
			//,3025 			=> 		''
		);
		  $result = ship($this->vals);
		  return $result;
    }

	// getting service type
	function servicemethod($id){
		 switch ($id) {
		 	case 01:
			return  "Express Priority Overnight";
			break;
		case 03:
			return  "Express Economy Two Day";
			break;
		case 05:
			return  "Express Standard Overnight";
			break;
		case 06:
			return  "Express First Overnight";
			break;
		case 20:
			return  "Express Saver";
			break;
		case 70:
			return  "Freight Overnight";
			break;
		case 80:
			return  "Freight Two Day";
			break;
		case 83:
			return  "Freight Express Saver";
			break;
		case 86:
			return  "Freight International Priority";
			break;
		case 90:
			return  "Ground Home Delivery";
			break;
		case 92:
			return  "Ground Business Delivery";
			break;
			
		}
	}
	//function to get license
	function get_license($userid){
		$query= $this->db->query("select licensetype from  adhi_user where id = '$userid'");
		$result=$query->result_array();
		$licensetype=$result[0]['licensetype'];
		return 	$licensetype;
	}
	//end
	function listmonth(){
	
	$montharray= array(	"1"=>"Jan",
						"2"=>"Feb",
						"3"=>"Mar",
						"4"=>"Apr",
						"5"=>"May",
						"6"=>"Jun",
						"7"=>"Jul",
						"8"=>"Aug",						
						"9"=>"Sep",
						"10"=>"Oct",
						"11"=>"Nov",
						"12"=>"Dec"
						);
	return $montharray;
	}
	
	function listyear($cyear){
		$endyr = $cyear + 10;
		$yeararray= array();
		$j=0;
		for ($i=$cyear; $i<=$endyr; $i++){
			$yeararray[$j]= $i;
			$j++;
		}
		return $yeararray;
	}
	
	

function payment($arr)
	{
	
	$this->load->plugin ('paypal');

	$paymentType = urlencode('Sale');				// or 'Sale'
	$firstName = urlencode($arr['firstname']);
	$lastName =  urlencode($arr['lastname']);
	$creditCardType = urlencode($arr['cardtype']);
	$creditCardNumber = urlencode($arr['ccno']);
	$expDateMonth = $arr['expmonth'];
	// Month must be padded with leading zero
	$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
	
	$expDateYear = urlencode($arr['expyear']);
	$cvv2Number = urlencode($arr['cvv2no']);
	$address1 = urlencode($arr['address1']);
	$address2 = urlencode($arr['address1']);
	$city = urlencode($arr['city']);
	$state = urlencode($arr['state']);
	$zip = urlencode($arr['zipcode']);
	$country = urlencode($arr['country']);				// US or other valid country code
	$amount = urlencode($arr['amount']);
	$currencyID = urlencode('USD');		
						// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
					// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
	
	// Add request-specific fields to the request string.
	$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
	"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
	"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
	// Execute the API operation; see the PPHttpPost function above.
	$httpParsedResponseAr = PPHttpPost('DoDirectPayment', $nvpStr);
	return $httpParsedResponseAr;
	}	
	
		 
		 
	 function selectstate($id){
		$query= $this->db->query("Select state from adhi_states where state_code = '$id'");
		return $query->result_array();
	 }
	 function get_mail($userid){
		$query= $this->db->query("Select emailid from adhi_user where id = '$userid'");
		return $query->result_array();
	 }
	
	function userregistration($arr){
	
		$this->db->insert('adhi_user_reg_temp', $arr);
		$adhi_user_id   = $this->db->insert_id(); 
                return $adhi_user_id;
	}
        function updateuserreg($arr,$id){
		$this->db->where('id', $id);
		$this->db->update('adhi_user_reg_temp', $arr);
	}
        /************added by ajay**************/
        function adduser_forum($arr){
            //print_r($arr);
         //$configVal=array();
       // $this->vals = $configVal;
       // $path=$this->config->item ('site_basepath');
        //$DB2= $this->load->database('blog', TRUE);
        $username=$arr['email'];
        $password=$arr['password'];
        $email=$arr['email'];
        $usergid=$arr['usergroupid'];

        //$DB2->query("INSERT INTO user (username,email,usergroupid,password) VALUES ('$username' ,'$email','$usergid', md5(concat(md5(" . $this->db->escape($password) . "), salt)))");
         //$query	= $DB2->insert('user',$arr);
	//return $DB2->result();
        //return true;
       // mysql_close();
				//include $xcart_dir."/modules/xvbIntegration/class.vbreg.php";
        
       
        //$this->load->plugin ('vbintegration');
       
        //include $path."system/plugins/vbintegrat
        
        //$this->load->database('default', FALSE);
        //$this->load->library ('vbintegration');

        require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
        //$this->load->library('vbintegration');
				$this->vbulletin = new xvbIntegration();
				//unset($vbInsert);
				$vbInsert['username'] = $arr['forum_alias'];
				//$vbInsert['username'] = $arr['firstname'].$arr['lastname'];
				$vbInsert['email'] = $arr['email'];
				$vbInsert['password'] = $arr['password'];
                               /// $userfield['firstname'] = $arr['firstname'];
                               // $userfield['lastname'] = $arr['lastname'];
				$this->vbulletin->xvbRegister($vbInsert);
                             //  $this->vbulletin->xvbRegister($vbInsert,'','',$userfield);
//				$xvb = new xvbIntegration();
//				unset($vbInsert);
//				$vbInsert['username'] = $arr['emailid'];
//				$vbInsert['email'] = $arr['emailid'];
//				$vbInsert['password'] = text_decrypt($arr['password']);
//				$xvb->xvbRegister($vbInsert);
//
//                                set_error_handler('_exception_handler');
//                                return true;
        }
        function vb_login($ar){
         //$this->load->library('vbintegration');
//echo $ar;
            //require_once('/var/www/html/adhischools/trunk/system/application/libraries/vbintegration.php');
          require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
            $this->vbulletin = new xvbIntegration();
            $this->vbulletin->xvbLogin($ar,true);
        }
         function vb_logout(){
             //echo "dsfs";
        
  require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
            //require_once('/var/www/html/adhischools/trunk/system/application/libraries/vbintegration.php');
            $this->vbulletin = new xvbIntegration();
            $this->vbulletin->xvbLogout();
        }
        function vb_forcelogout($userid){
           // echo $userid;

  require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
            //require_once('/var/www/html/adhischools/trunk/system/application/libraries/vbintegration.php');
            $this->vbulletin = new xvbIntegration();
            $this->vbulletin->xvbForceLogout($userid);
        }
        /**************************************/
	
	function order($arr){
		
		$this->db->insert('adhi_orderdetails', $arr);
		return $this->db->insert_id();
	}
	
	
	function usercourse($arr){
	if($arr['course'] !=''){
		for($i=0;$i<count($arr['course']);$i++){
			$course=array(
			"userid" => $arr['userid'],
			"courseid" => $arr['course'][$i],
			"orderid 	" => $arr['orderid'],
			"enrolled_date" => $arr['enrolled_date']
			
			);
			//if($arr['course'][$i] !=5)
			$this->db->insert('adhi_user_course', $course);
		}
		}
		if($arr['subcourse'] !=''){
		
			$course=array(
				"userid" => $arr['userid'],
				"courseid" => $arr['subcourse'],
				"orderid 	" => $arr['orderid'],
				"enrolled_date" => $arr['enrolled_date']
				
				);				
				$this->db->insert('adhi_user_course', $course);
		}
		if($arr['course_o'] !=''){
		
			$course=array(
				"userid" => $arr['userid'],
				"courseid" => $arr['course_o'],
				"orderid 	" => $arr['orderid'],
				"enrolled_date" => $arr['enrolled_date']
				
				);				
				$this->db->insert('adhi_user_course', $course);
		}
	}
	function renewcourse($arr){
	$query= $this->db->query("select * from adhi_user_renewdetails where reg_courseid ='".$arr['reg_courseid']."'");
		$result= $query->num_rows();
		if($result){
			$query1= $this->db->query("update  adhi_user_renewdetails set renew_date ='".$arr['renew_date']."',
			b_address = '".$arr['b_address']."',b_city = '".$arr['b_city']."', b_state = '".$arr['b_state']."',
			b_zipcode = '".$arr['b_zipcode']."'  where reg_courseid ='".$arr['reg_courseid']."'  ");
			
			
		}else{
			$query1= $this->db->insert('adhi_user_renewdetails', $arr);
			//$result1= $query1->num_rows();
		}
	
			$query= $this->db->query("update  adhi_user_course set	renewal_status ='Y' where id ='".$arr['reg_courseid']."'  ");
		
	}
	
	function updateorder($arr,$id){
		$this->db->where('id', $id);
		$this->db->update('adhi_orderdetails', $arr); 
	}
	/************added by ajay**************/
        function checkuser_blog($emailid){
        	//local
       // $DB2 	= $this->load->database('vbulletin', TRUE);
     //       $query	= $DB2->query("select * from user where email = '$emailid'");
            
         //live
           	$this->db1 	= $this->load->database('db1', TRUE);
          	$query	= $this->db1->query("select * from user where email = '$emailid'");
            $this->db1->close();
			$result	= $query->num_rows();
			$this->db 	= $this->load->database('default', TRUE);
            $this->db->close();
        	return $result;
        }
        /**************************************/
	function checkuser($emailid){
	
	$query= $this->db->query("select * from adhi_user where emailid = '$emailid'");
	$result= $query->num_rows();
	return $result;
	}
	
	function get_admin(){
		$query= $this->db->query("select firstname,lastname,emailid,company_name,company_address,state,city,zpcode,country,phone   from adhi_admin");
		return $query->result_array();
	}
	function get_b_address($userid){
	 	 	 	 	 	
		$query= $this->db->query("select b_address,b_state,b_zipcode,phone,b_city,b_country,firstname,lastname,emailid   from adhi_user where id ='$userid'");
		return $query->result_array();
	}
	function get_s_address($userid){
	 	 	 	 	 	
		$query= $this->db->query("select s_address,s_state,s_zipcode,phone,s_city,s_country,firstname,lastname,emailid   from adhi_user where id ='$userid'");
		return $query->result_array();
	}
	function send_mailto_user($mail,$order,$trackinfo,$from_admin='',$ship='yes'){
	
		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course']);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse']);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o']);
		}
		
		$from ='';
		$toemail= $mail['useremail'];
		$subject='Registration Details Adhi Real Estate School';
		$contents		= '';
			$contents		.= 'Dear '.$mail['name'].",<br><br>";
		
			$contents		.= '<table cellpadding="0" cellspacing="0" border="0" width="600" >
			<tr><td><br /></td></tr>
			<tr><td align="justify" ><p align="justify">&nbsp;&nbsp;&nbsp;&nbsp;Thank you for registering with Adhi Schools, LLC your California real estate education provider.  We pride ourselves on service first and foremost.  Open communication is important in any relationship and ours is no exception!</p></td>
			</tr>
			<tr><td><br /></td></tr>
			<tr><td align="left">So how do you contact us if you need to?</td></tr>
			<tr><td><br /></td> </tr>
			<tr><td align="left">1.	Facebook at <a href="www.facebook.com/adhischools">www.facebook.com/adhischools</a><br />
			2.	Twitter @adhischools<br />
			3.	YouTube at youtube.com/adhischoolsllc</td> </tr>
			<tr><td><br /></td></tr>
			<tr><td align="justify" ><p align="justify"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Don&acute;t like any of that social media stuff?  You can always send an email to me directly at:  <a href="mailto:kartik@adhischools.com">kartik@adhischools.com</a> or call our office at 888 768 5285 if you have any questions.</p></td>
			</tr>
			<tr><td><br /></td> </tr>
			<tr><td align="justify" ><p align="justify" >&nbsp;&nbsp;&nbsp;&nbsp;Your shipment will be sent to you via FedEx.  For each class you enrolled in Bureau of Real Estate guidelines dictate that you must wait a minimum of 18 calendar days from the date your received the course material before you attempt the final exam for that class.  <b>This 18 day requirement applies to each class that you signed up for.</b>  The Adhi Schools website will track the shipment and allow access to the final exams according to this rule.</p></td>
			</tr>
			<tr><td><br /></td></tr>
			<tr><td align="justify" ><p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;If you have signed up for an optional principles live class, you can go to any of our locations.  Visit our website under the &ldquo;Schedules and locations&rdquo; link.</p></td>
			</tr>
			<tr><td><br /></td> </tr>
			<tr><td align="justify" ><p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;If you signed up for any other classes, check our schedule if you would like to come to any of our one day review sessions.  If applicable, this is included in your enrollment.</p></td>
 			</tr>
   			<tr><td><br /></td> </tr>
   			<tr> <td>Below are your registration details:<br />
			Please find your login details.<br />
			Login Id : '.$mail['useremail'].'<br />';
			if($from_admin == "admin"){
				$contents		.='Password : '.$mail['password'].'<br />';
			}
			$contents		.='</td> </tr>
		    <tr><td><br /></td> </tr>
			</table>';



			$contents		.= '<b>Payment Details</b><br>';
			$contents		.= 
			'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				
				
				<tr>
					<td align="left"  width="150" >Payment Method</td>
					<td align="left"  width="150" >'.$order['payment_method'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Address </td>
					<td align="left"  width="150" >'.$order['b_address'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Country </td>
					<td align="left"  width="150" >United States </td>
				</tr>
				<tr>
					<td align="left"  width="150" >State </td>
					<td align="left"  width="150" >'.$state.'  </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Zipcode </td>
					<td align="left"  width="150" >'.$order['b_zipcode'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Course Amount </td>
					<td align="left"  width="150" > $'.$order['course_price'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Shipping Rate</td>
					<td align="left"  width="150" > $'.$order['ship_rate'].' </td>
				</tr>

				<tr>
					<td align="left"  width="150" >Total Amount </td>
					<td align="left"  width="150" > $'.$order['total_amount'].' </td>
				</tr>
				
				</table>';
				$contents		.= '<br><br><b>Registered Courses</b><br>';
					$contents .= 	'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
							<tr>'.
							/*<td><b>Course Code</b> </td>*/
							
							'<td><b>Course Name</b> </td>
							<td><b>Course Price</b> </td>
							</tr>';
					if($course !=''){
					for($i=0; $i< count($course); $i++)
					{
					
				$contents .= 	'<tr>'.
							/*<td>'.$course[$i]['course_code'].'</td>*/
							
							'<td>'.$course[$i]['course_name'].'</td>
							<td>$'.$course[$i]['amount'].'</td>
							</tr>';
					
					}
					}
					if($course_o !=''){
					$contents .= 	'<tr>'.
							/*<td>'.$course_o['course_code'].'</td>*/
						
							'<td>'.$course_o['course_name'].'</td>
							<td>$'.$course_o['amount'].'</td>
							</tr>';
					
					}
					if($subcourse != ''){
					$contents .= 	'<tr>'.
							/*<td>'.$subcourse['course_code'].'</td>*/
							
							'<td>'.$subcourse['course_name'].'</td>
							<td>$'.$subcourse['amount'].'</td>
							</tr>';
					
					
					}
						$contents		.= '					
						
						</table>';
						if($ship =='yes'){
						if(is_array($trackinfo)){
							$contents		.= '<br><br><b>Tracking Information</b><br>';
						$contents .= '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
						
							<tr>
								<td align="left"  width="150" >Tracking No</td>
								<td align="left"  width="150" >'.$trackinfo['trackingno'].' </td>
							</tr>
						</table>';
						}else{
						$contents .= '<table cellpadding="0" cellspacing="0" border="0" width="500">
							<tr>
								<td><b>We will resend your Tracking Information </b></td>
							</tr>
							<tr>
							</table>';
						
						}
						}
						//$contents		.= "<br><br>Exam date will be informed you via E-mail<br><br>";
						
						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";
		$this->Common_model->send_mail($toemail,$from,$subject,$contents,'yes');
		
	}
	
	function send_renewal_mailto_user($mail){
			$this->load->model('Common_model');

		$from ='';
		$toemail= $mail['useremail'];
		$subject='Renewal Details';
		$contents		= '';
		$contents		.= 'Dear '.$mail['name'].",<br><br>";
		
		$contents		.= "You are successfully renewed ".$mail['coursename']." <br><br>";
		$contents		.= '<b>Payment Details</b><br>';
			$contents		.= 
			'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				
				<tr>
					<td align="left"  width="150" >Payment Method</td>
					<td align="left"  width="150" >Paypal Payment Method </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Address </td>
					<td align="left"  width="150" >'.$mail['b_address'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Country </td>
					<td align="left"  width="150" >United States </td>
				</tr>
				<tr>
					<td align="left"  width="150" >State </td>
					<td align="left"  width="150" >'.$mail['b_state'].'  </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Zipcode </td>
					<td align="left"  width="150" >'.$mail['b_zipcode'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Course Amount </td>
					<td align="left"  width="150" > $'.$mail['courseprice'].' </td>
				</tr>
				
			
				</table>';
						
						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";

				$this->Common_model->send_mail($toemail,$from,$subject,$contents);
	
	}
	
		function new_send_mailto_user($mail,$order,$trackinfo){
	
		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course']);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse']);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o']);
		}
		
		$from ='';
		$toemail= $mail['useremail'];
		$subject='Order Details';
		$contents		= '';
		$contents		.= 'Dear '.$mail['name'].",<br><br>";
		
		$contents		.= "You are successfully ordered new courses.<br><br>";
		$contents		.= '<b>Payment Details</b><br>';
			$contents		.= 
			'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				<tr>
					<td align="left"  width="150" >Payment Method</td>
					<td align="left"  width="150" >'.$order['payment_method'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Address </td>
					<td align="left"  width="150" >'.$order['b_address'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Country </td>
					<td align="left"  width="150" >United States </td>
				</tr>
				<tr>
					<td align="left"  width="150" >State </td>
					<td align="left"  width="150" >'.$state.'  </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Zipcode </td>
					<td align="left"  width="150" >'.$order['b_zipcode'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Course Amount </td>
					<td align="left"  width="150" > $'.$order['course_price'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Shipping Rate</td>
					<td align="left"  width="150" > $'.$order['ship_rate'].' </td>
				</tr>

				<tr>
					<td align="left"  width="150" >Total Amount </td>
					<td align="left"  width="150" > $'.$order['total_amount'].' </td>
				</tr>
				
				</table>';
				$contents		.= '<br><b>Ordered Courses</b><br>';
				$contents .= '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
							<tr>'.
							/*<td><b>Course Code</b> </td>*/
							
							'<td><b>Course Name</b> </td>
							<td><b>Course Price</b> </td>
							</tr>';
					if($course !=''){
					for($i=0; $i< count($course); $i++)
					{
					
				$contents .= 	'<tr>'.
							/*<td>'.$course[$i]['course_code'].'</td>*/
							
							'<td>'.$course[$i]['course_name'].'</td>
							<td>$'.$course[$i]['amount'].'</td>
							</tr>';
					
					}
					}
					if($course_o !=''){
					$contents .= 	'<tr>'.
							/*<td>'.$course_o['course_code'].'</td>*/
							
							'<td>'.$course_o['course_name'].'</td>
							<td>$'.$course_o['amount'].'</td>
							</tr>';
					
					}
					if($subcourse != ''){
					$contents .= 	'<tr>'.
							/*<td>'.$subcourse['course_code'].'</td>*/
							
							'<td>'.$subcourse['course_name'].'</td>
							<td>$'.$subcourse['amount'].'</td>
							</tr>';
					
					
					}
						$contents		.= '					
						
						</table>';
						
						if(is_array($trackinfo)){
						$contents		.= '<br><br><b>Tracking Information</b><br>';
						$contents .= '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
							<tr>
								<td align="left"  width="250" >Tracking No</td>
								<td align="left"  width="150" >'.$trackinfo['trackingno'].' </td>
							</tr>
						</table>';
						}else{
						$contents .= '<table cellpadding="0" cellspacing="0" border="0" width="500">
							<tr>
								<td colspan="2" width="500"><b>Admin will resend your Tracking Information </b></td>
							</tr>
							<tr>
							</table>';
						
						}
						$contents		.= "<br><br>Exam date will be informed you via E-mail<br><br>";
						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";

		$this->Common_model->send_mail($toemail,$from,$subject,$contents);
		
	}
	function send_mailto_admin($mail,$order,$admin,$trackinfo){

		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course']);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse']);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o']);
		}
		
		$from ='';
		$toemail= $admin[0]['emailid'];
		$subject='Registration Details';
		$contents		= '';
		$contents		.= '<b>Account Details</b><br>';
			$contents		.= 
			'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				
				<tr>
					<td align="left"  width="150" >User Name</td>
					<td align="left"  width="150" >'.$mail['name'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Email</td>
					<td align="left"  width="150" >'.$mail['useremail'].' </td>
				</tr>
				</table>';
				$contents		.= '<br><b>Payment Details</b><br>';
				$contents		.= 
				'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				
				<tr>
					<td align="left"  width="150" >Payment Method</td>
					<td align="left"  width="150" >'.$order['payment_method'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Address </td>
					<td align="left"  width="150" >'.$order['b_address'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Country </td>
					<td align="left"  width="150" >United States </td>
				</tr>
				<tr>
					<td align="left"  width="150" >State </td>
					<td align="left"  width="150" >'.$state.'  </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Zipcode </td>
					<td align="left"  width="150" >'.$order['b_zipcode'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Course Amount </td>
					<td align="left"  width="150" > $'.$order['course_price'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Shipping Rate</td>
					<td align="left"  width="150" > $'.$order['ship_rate'].' </td>
				</tr>

				<tr>
					<td align="left"  width="150" >Total Amount </td>
					<td align="left"  width="150" > $'.$order['total_amount'].' </td>
				</tr>
				
				</table>';
				$contents		.= '<br><b>Registered Courses</b><br>';
					$contents		.= '
						<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
							<tr>'.
							/*<td><b>Course Code</b> </td>*/
							
							'<td><b>Course Name</b> </td>
							<td><b>Course Price</b> </td>
							</tr>';
					if($course !=''){
						for($i=0; $i< count($course); $i++)
						{
						
					$contents .= 	'<tr>'.
								/*<td>'.$course[$i]['course_code'].'</td>*/
								
								'<td>'.$course[$i]['course_name'].'</td>
								<td>$'.$course[$i]['amount'].'</td>
								</tr>';
						
						}
					}
					if($course_o !=''){
					$contents .= 	'<tr>'.
							/*<td>'.$course_o['course_code'].'</td>*/
							
							'<td>'.$course_o['course_name'].'</td>
							<td>$'.$course_o['amount'].'</td>
							</tr>';
					
					}
					if($subcourse != ''){
					$contents .= 	'<tr>'.
							/*<td>'.$subcourse['course_code'].'</td>*/
							
							'<td>'.$subcourse['course_name'].'</td>
							<td>$'.$subcourse['amount'].'</td>
							</tr>';
					
					
					}
						$contents		.= '					
						
						</table>';
						
						if(is_array($trackinfo)){
							$contents		.= '<br><br><b>Tracking Information</b><br>';
						$contents .= '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
						
							<tr>
								<td align="left"  width="150" >Tracking No</td>
								<td align="left"  width="150" >'.$trackinfo['trackingno'].' </td>
							</tr>
						</table>';
						}else{
						$contents .= '<table cellpadding="0" cellspacing="0" border="0" width="500">
							<tr>
								<td><b>Order Detail is on Queue. Please resend this order  </b></td>
							</tr>
							<tr>
							</table>';
						
						}
					
						
						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";

		$this->Common_model->send_mail($toemail,$from,$subject,$contents);
	
	
	}
	
		function new_send_mailto_admin($mail,$order,$admin,$trackinfo){

		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course']);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse']);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o']);
		}
		
		$from ='';
		$toemail= $admin[0]['emailid'];
		$subject='Order Details';
		$contents		= '';
		$contents		.= '<b>Account Details</b><br>';
			$contents		.= 
			'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				
				<tr>
					<td align="left"  width="150" >User Name</td>
					<td align="left"  width="150" >'.$mail['name'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Email</td>
					<td align="left"  width="150" >'.$mail['useremail'].' </td>
				</tr>
				</table>';
				$contents		.= '<br><b>Payment Details</b><br>';
				$contents		.= 
				'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
				
				<tr>
					<td align="left"  width="150" >Payment Method</td>
					<td align="left"  width="150" >'.$order['payment_method'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Address </td>
					<td align="left"  width="150" >'.$order['b_address'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Country </td>
					<td align="left"  width="150" >United States </td>
				</tr>
				<tr>
					<td align="left"  width="150" >State </td>
					<td align="left"  width="150" >'.$state.'  </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Zipcode </td>
					<td align="left"  width="150" >'.$order['b_zipcode'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Course Amount </td>
					<td align="left"  width="150" > $'.$order['course_price'].' </td>
				</tr>
				<tr>
					<td align="left"  width="150" >Shipping Rate</td>
					<td align="left"  width="150" > $'.$order['ship_rate'].' </td>
				</tr>

				<tr>
					<td align="left"  width="150" >Total Amount </td>
					<td align="left"  width="150" > $'.$order['total_amount'].' </td>
				</tr>
				
				</table>';
					$contents		.= '<br><b>Ordered Courses</b><br>';
					$contents		.= '
						<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
							<tr>'.
							/*<td><b>Course Code</b> </td>*/
							
							'<td><b>Course Name</b> </td>
							<td><b>Course Price</b> </td>
							</tr>';
					if($course !=''){
						for($i=0; $i< count($course); $i++)
						{
						
					$contents .= 	'<tr>'.
								/*<td>'.$course[$i]['course_code'].'</td>*/
								
								'<td>'.$course[$i]['course_name'].'</td>
								<td>$'.$course[$i]['amount'].'</td>
								</tr>';
						
						}
					}
					if($course_o !=''){
					$contents .= 	'<tr>'.
							/*<td>'.$course_o['course_code'].'</td>*/
							
							'<td>'.$course_o['course_name'].'</td>
							<td>$'.$course_o['amount'].'</td>
							</tr>';
					
					}
					if($subcourse != ''){
					$contents .= 	'<tr>'.
							/*<td>'.$subcourse['course_code'].'</td>*/
							
							'<td>'.$subcourse['course_name'].'</td>
							<td>$'.$subcourse['amount'].'</td>
							</tr>';
					
					
					}
						$contents		.= '					
						
						</table>';
						
						
					if(is_array($trackinfo)){
							$contents		.= '<br><br><b>Tracking Information</b><br>';
						$contents .= '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
						
							<tr>
								<td align="left"  width="150" >Tracking No</td>
								<td align="left"  width="150" >'.$trackinfo['trackingno'].' </td>
							</tr>
						</table>';
						}else{
						$contents .= '<table cellpadding="0" cellspacing="0" border="0" width="500">
							<tr>
								<td><b>Order Detail is on Queue. Please resend this order  </b></td>
							</tr>
							<tr>
							</table>';
						
						}
						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";

						
		$this->Common_model->send_mail($toemail,$from,$subject,$contents);
	
	
	}
	function courselist($course){
		$courselist='';
		if($course !=''){
		for($i=0;$i<count($course);$i++){
		/*if($course[$i] !=5){*/
			$query= $this->db->query("select parent_course_name,course_code,course_name,amount from  adhi_courses  where id = '".$course[$i]."'");
			$result=$query->result_array();
			$courselist[$i]['parent_course_name']=$result[0]['parent_course_name'];
			$courselist[$i]['course_code']=$result[0]['course_code'];
			$courselist[$i]['course_name']=$result[0]['course_name'];
			$courselist[$i]['amount']=$result[0]['amount'];
			//}
		}
		}
		if($courselist !='')
		return $courselist;
	}
	function subcourselist($subcourse){
			$query= $this->db->query("select parent_course_name,course_code,course_name,amount from  adhi_courses  where id = '$subcourse'");
			$result=$query->result_array();
			$subcourselist['parent_course_name']=$result[0]['parent_course_name'];
			$subcourselist['course_code']=$result[0]['course_code'];
			$subcourselist['course_name']=$result[0]['course_name'];
			$subcourselist['amount']=$result[0]['amount'];
			return $subcourselist;
	}
	function opcourselist($opcourse){
	
			$query= $this->db->query("select parent_course_name,course_code,course_name,amount from  adhi_courses  where id = '$opcourse'");
			$result=$query->result_array();
			$opcourselist['parent_course_name']=$result[0]['parent_course_name'];
			$opcourselist['course_code']=$result[0]['course_code'];
			$opcourselist['course_name']=$result[0]['course_name'];
			$opcourselist['amount']=$result[0]['amount'];
			return $opcourselist;

	}
	function get_statename($statecode){
			$query= $this->db->query("select state from  adhi_states  where state_code = '$statecode'");
			$result=$query->result_array();
			$statename=$result[0]['state'];
			return 	$statename;
	}
	function get_courseweight($arr){
	$course_weight = 0.0;
	
		if($arr['course'] !=''){
			for($i=0;$i<count($arr['course']);$i++){
				$course=array(
				"userid" => $arr['userid'],
				"courseid" => $arr['course'][$i],
				"orderid 	" => $arr['orderid'],
				"enrolled_date" => $arr['enrolled_date']
				);
				//if($arr['course'][$i] !=5){
				$query= $this->db->query("select wieght from adhi_courses where id='".$arr['course'][$i]."' ");
				$result=$query->result_array();
				$course_weight = $course_weight + $result[0]['wieght'];
				//}
			}
		}
		if($arr['subcourse'] !=''){			
			$query=$this->db->query("select wieght from adhi_courses where id='".$arr['subcourse']."' ");
			$result=$query->result_array();
			$course_weight = $course_weight + $result[0]['wieght'];
		}
		if($arr['course_o'] !=''){
			$query=$this->db->query("select wieght from adhi_courses where id='".$arr['course_o']."' ");
			$result=$query->result_array();
			$course_weight = $course_weight + $result[0]['wieght'];
		}
		return 	$course_weight;
	 }
	 
	 /**
	 * function to get the password using the email
	 */
	function get_password($email){
		
		if(isset ($email) && '' != $email){
			
			$this->db->where('emailid',$email);
			$this->db->select ("password,id,firstname,lastname");
			$query	=	$this->db->get('adhi_user');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
			
		}else 	
			return FALSE;
	}
	
	
		 /**
	 * function to get the password using the email
	 */
	function change_password($email,$id,$password){
		
		if(isset ($email) && '' != $email && isset ($id) && '' != $id && isset ($password) && '' != $password ){
			
			$array = array('password' => $password);
			$this->db->set($array);
			
			$this->db->where('id',$id);
			$this->db->where('emailid',$email);
			//$vbInsert['username'] = $email;
			$vbInsert['email'] = $email;
			$vbInsert['password'] = $password;
			
			if($this->db->update('adhi_user')){

                         require_once $site_basepath.'system/application/libraries/vbintegration.php';

                                $this->vbulletin = new xvbIntegration();

				$this->vbulletin->xvbUpdate($vbInsert);
				return TRUE;
                        }else
				return FALSE;
			
		}else 	
			return FALSE;
	}
	
			 /**
	 * function to get the password using the email
	 */
	function confirm_password($password,$id){
		
		if(isset ($id) && '' != $id && isset ($password) && '' != $password){
			
			$this->db->where('password',$password);
			$this->db->where('id',$id);
			$this->db->select ("password,id");
			$query	=	$this->db->get('adhi_user');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
			
		}else 	
			return FALSE;
	}
	function paymentlog($arr){
	   	$this->db->insert('adhi_payment_log', $arr);
		return $this->db->insert_id();
	}
	function checkuser_forumalias($forumalias,$id=''){
	if('' != $id){
		$query= $this->db->query("select * from adhi_user where forum_alias = ".$this->db->escape($forumalias)." and id!=".$id);
	}else {
		$query= $this->db->query("select * from adhi_user where forum_alias = ".$this->db->escape($forumalias));
	}
	$result= $query->num_rows();
	return $result;
	}	
	
	
	function send_registration_mail_to_admin($to, $data, $subject){
		$contents		= '';
        $contents		.= '<b>Account Details</b><br>';
    	$contents		.='<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
                                <tr>
                                    <td align="left"  width="150" >First name</td>
                                    <td align="left"  width="150" >'.$data['firstname'].' </td>
                                </tr>
                                <tr>
                                    <td align="left"  width="150" >Last name</td>
                                    <td align="left"  width="150" >'.$data['lastname'].' </td>
                                </tr>
                                <tr>
                                    <td align="left"  width="150" >email</td>
                                    <td align="left"  width="150" >'.$data['emailid'].' </td>
                                </tr>
                                <tr>
                                    <td align="left"  width="150" >phone number</td>
                                    <td align="left"  width="150" >'.$data['phone'].' </td>
                                </tr>
                           </table>';
        $contents		.= "<br><br>With regards,<br><br>";
        $contents		.= "Adhi Schools";
       $this->Common_model->send_mail($to,'',$subject,$contents);
      
                           
	}
 }
 
?>