<?php
class User_model extends Model {


    function User_model()
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
	function generate_captcha ($configVal = array (),$from = "",$admin = 1)
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
                                    'expiration'     	 => 3600,
                                    'admin'              => $admin
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
        //function to get Course user type
	function get_course_user_type($userid){
		$query= $this->db->query("select course_user_type from  adhi_user where id = '$userid'");
		$result=$query->result_array();
		$course_user_type=$result[0]['course_user_type'];
		return 	$course_user_type;
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

	function userregistration($arr, $register_user=0){
                if($this->session->userdata ('USERID') && $register_user != 1) {
                    $arr['created_by']   = $this->session->userdata ('ADMINTYPE');
                    $arr['created_type'] = $this->session->userdata ('USERID');
                } else {
                    $arr['created_type'] = 0;
                }
		$this->db->insert('adhi_user', $arr);
		$adhi_user_id   = $this->db->insert_id();
                return $adhi_user_id;
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
			$d_edition = getDefaultEdition($arr['course'][$i]);
			$course=array(
			"userid" => $arr['userid'],
			"courseid" => $arr['course'][$i],
			"orderid 	" => $arr['orderid'],
			"enrolled_date" => $arr['enrolled_date'],
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
				"edition" => $d_edition
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

        	$DB2 	= $this->load->database('blog', TRUE);
            $query	= $DB2->query("select * from user where email = '$emailid'");
			$result	= $query->num_rows();
        	return $result;




        	//local
       	// $DB2 	= $this->load->database('adhischools_forum', TRUE);
        //    $query	= $DB2->query("select * from user where email = '$emailid'");

         //live
          // 	$this->db1 	= $this->load->database('db1', TRUE);
       	 // 	$query	= $this->db1->query("select * from user where email = '$emailid'");

		//	$result	= $query->num_rows();
		//	$this->db 	= $this->load->database('blog', TRUE);
        //	return $result;
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

		$query= $this->db->query("select b_address,b_state,b_zipcode,phone,b_city,b_country,firstname,lastname,emailid,billing_sameas_shipping   from adhi_user where id ='$userid'");
		return $query->result_array();
	}
	function get_s_address($userid){

		$query= $this->db->query("select s_address,s_state,s_zipcode,phone,s_city,s_country,firstname,lastname,emailid   from adhi_user where id ='$userid'");
		return $query->result_array();
	}
	function send_mailto_user($mail,$order,$trackinfo,$from_admin='',$usertype,$ship='yes'){
		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course'],$usertype);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse'],$usertype);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o'],$usertype);
		}

                
		$from ='';
		$toemail= $mail['useremail'];
		$subject='Registration Details Adhi Real Estate School';
                
		$contents_live		= '';
                $contents_live		.= 'Dear '.$mail['name'].",";

                $contents_live		.= '<table cellpadding="0" cellspacing="0" border="0" width="600" >
                <tr><td><br /></td></tr>
                <tr><td align="justify" >
                <p align="justify"><b>Real estate classes classroom option: What to Expect</b></p></td>
                </tr>
                <tr><td><br /></td></tr>
                <tr><td align="left"><b>Login to your account at:  <a href="www.adhischools.com" target="_blank"> www.adhischools.com </b></td></tr>
                <tr><td><br /></td> </tr>
                <tr><td align="left"><b>Welcome to the world of real estate! </b></tr>
                <tr><td><br /></td></tr>
                <tr><td align="justify" ><p align="justify"> <b> You have chosen to do the real estate classes with a classroom option as well as our online tools.   Obtaining a professional license does require a certain element of commitment and discipline.  It&acute;s not so much that the concepts are so difficult, it&acute;s just that the books are so big and there is so much material to go over it can often get overwhelming even with the option of coming to class.</b></p></td>
                </tr>
                <tr><td><br /></td> </tr>
                <tr><td align="justify" ><p align="justify" > <b> With that being said, you may know real estate agents that got their real estate licenses years ago and say things like &ldquo;Getting your real estate license is the easiest thing ever!&rdquo;  &ldquo;That test was a piece of cake!&rdquo;   This is especially true of real estate licensees that got their licenses many years ago when the requirements were different.  Prior to October 1, 2007 all you needed was one class in order to qualify for the exam - now you need three.   Also, the pass rates for the real estate examination aren&acute;t as high as you might think.  For example, in May of 2015 only 54% of those that took the real estate salespersons examination actually passed it.  So there is definitely some studying that&acute;s going to be required and a bit of a commitment on your part.  </b></p></td>
                </tr>
                <tr><td><br /></td></tr>
                <tr><td align="justify" ><p align="justify"> <b> Here&acute;s how I would recommend going over the course material.  You can take these in any order that you wish, but I think that this would give you the greatest chance of success. </b></p> </td>
                </tr>
                <tr><td><br /></td> </tr>
                <tr><td align="justify" style="font-family:Times;">
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                1. Start coming to the weekly Real Estate Principles class as soon as possible.  Even if you don&acute;t have your books yet, still come and take notes.  You can transfer these notes into your book later.  Find the closest location to you at <a href="www.adhischools.com/schedule" target="_blank"> www.adhischools.com/schedule </a> <br/>
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                2. Consider taking more than one class per week.  This might sound like too much but we have many different instructors and they all have different ways of doing things.  Some lecture styles might resonate more than others.<br/>
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                3. Take the weekend Practice and Law classes right away, even if you haven&acute;t finished the Principles lectures as yet. <br/>
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                4. Watch all the videos in the &ldquo;Classroom&rdquo; tab on our website before or after hearing the live lecture.  This will help reinforce the live lecture. <br/>
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                5. Spend a minimum of 18 days and 45 hours with each book and take the final exams on our website. <br/>
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                <b>6. Congrats! Now you have all three of your certificates!  Now you can apply for the real estate examination.  Call our office at <span style="color:blue"> 888 768 5285 </span> and we will walk you through the next steps. </b><br/>
                </p></td>
                </tr>
                <tr><td><br /></td> </tr>
                <tr> <td> <b> Once you get done with our program call us or email us and we would be happy to set up interviews for you.  Some brokers will even reimburse some or all  of the money you paid to the school if you work there!  Call us once you get closer to finishing and we can set you up and explain this more fully. </b> <br/> <br/></td> </tr>';
                
                
                $contents_online         = '';
                $contents_online	.= 'Dear '.$mail['name'].",<br/> <br/>";

                $contents_online        .= '<table cellpadding="0" cellspacing="0" border="0" width="600" >
                
                <tr><td align="justify" >
                <p align="justify"><b>Real estate classes home study: What to Expect</b></p></td>
                </tr>
                <tr><td align="left"><b>Login to your account at:  <a href="www.adhischools.com" target="_blank"> www.adhischools.com </b></td></tr>
                <tr><td><br /></td> </tr>
                <tr><td align="left"><b>Welcome to the world of real estate! </b></tr>
                <tr><td><br /></td></tr>
                <tr><td align="justify" ><p align="justify"> <b>You have chosen to do the real estate classes on a home study basis with online quizzes and online final examinations.   Doing this on a home study basis does require a certain element of commitment and discipline.  It&acute;s not so much that the concepts are so difficult, it&acute;s just that the books are so big and there is so much material to go over it can often get overwhelming doing it on your own.</b></p></td></tr>
                <tr><td><br /></td> </tr>
                <tr><td align="justify" ><p align="justify" > <b> With that being said, you may know real estate agents that got their real estate licenses years ago and say things like &ldquo; Getting your real estate license is the easiest thing ever!&rdquo;  &ldquo; That test was a piece of cake! &rdquo;   This is especially true of real estate licensees that got their licenses many years ago when the requirements were different.  Prior to October 1, 2007 all you needed was one class in order to qualify for the exam - now you need three.   Also, the pass rates for the real estate examination aren&acute;t as high as you might think.  For example, in May of 2015 only 54% of those that took the real estate salespersons examination actually passed it.  So there is definitely some studying that&ldquo;s going to be required and a bit of a commitment on your part.  </b></p> </td>
                </tr>
                <tr><td><br /></td></tr>
                <tr><td align="justify" ><p align="justify"><b> Here&acute;s how I would recommend going over the course material.  You can take these in any order that you wish, but I think that this would give you the greatest chance of success.</b></p> <br/> </td>
                </tr>
                <tr><td><br /></td> </tr>
                <tr><td align="justify" ><b>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                1. Start with the Real Estate Practice book.  I think this is probably the &ldquo;lightest&rdquo; of all the course material.  It&acute;s a little sales book for the first 11 chapters and you might even find this fun and interesting.  The book goes over how to get customers, how to advertise, listing contracts, etc.  Go through the book and do the end of chapter quizzes.  The answers and explanations are in the back of the book. 
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                2. Login to the school website and take some of the practice quizzes in your student account to prepare you for the final examination for this course.
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                3. Take the final examination for Real Estate Practice as long as you have had the course material for 18 days and have spent a minimum of 45 hours with the course material.  You have to get a 60% or better in order to pass the exam and get the certificate for this course.  It&acute;s open book and open note.  If you fail it, you can take it again for free, but you have to wait another 18 days to attempt this final exam. 
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                4. Next, I would move on to tackle the Real Estate Principles book.  This is a bit more technical than Real Estate Practice, but I think that the confidence of getting your Practice certificate will help you through this book. Go through the book and do the end of chapter quizzes.  The answers are in the back of the book.</p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                5. Take the final examination for Real Estate Principles as long as you have had the course material for 18 days and you haven&acute;t taken another final within the first block of 18 days.  You have to get a 60% or better in order to pass the exam and get the certificate for this course.  It&acute;s open book and open note.  If you fail it, you can take it again for free, but you have to wait another 18 days to attempt this final exam.  This is true for all of our final exams.</p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                6. Finally, tackle your elective class if you need it.  This class is the most technical and maybe the driest of all the books.   You still have to spend 45 hours with the course material.  Knock out this final examination on our website.
                </p>
                <p align="justify">	&nbsp;&nbsp;&nbsp;&nbsp;
                7. Congrats! Now you have all three of your certificates!  Now you can apply for the real estate examination.  Call our office at <span style="color:blue"> 888 768 5285 </span> and we will walk you through the next steps.  We can give you the latest forms you need to apply as well as get you a discount coupon for a two-day crash course that is absolutely legendary and will ensure your success on the test!
                </p></b></td><br/><br/>
                </tr>
                <tr><td><br /><br/></td> </tr>
                <tr> <td><b>If this home study thing isn&acute;t working for you, just call our office at <span style="color:blue"> 888 768 5285 </span> and we can talk about upgrading you to a classroom option.</b><br/><br/></td> </tr> 
                
                <tr> <td><b>Once you get done with our program call us or email us and we would be happy to set up interviews for you.  Some brokers will even reimburse some or all  of the money you paid to the school if you work there!  Call us once you get closer to finishing and we can set you up and explain this more fully.</b><br/> <br/></td> </tr>';
                
                
                $contents = '<tr> <td>Below are your registration details:<br />
                Please find your login details.<br /><br />
                <b>Login Id : '.$mail['useremail'].'<br />';
                if($from_admin == "admin"){
                        $contents		.='Password : '.$mail['password'].'<br />';
                }
                $contents		.='</b></td> </tr>
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


                $contents .= '<br><br><b>Registered Courses</b><br>';
                $contents .= 	'<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
                                <tr>
                                <td><b>Course Code</b> </td>

                                <td><b>Course Name</b> </td>';

                if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
                $contents .='<td><b>Course Price</b> </td>';
                        }
                $contents .='</tr>';
                if($course !=''){
                for($i=0; $i< count($course); $i++)
                {

                $contents .= 	'<tr>
                <td>'.$course[$i]['course_code'].'</td>

                <td>'.$course[$i]['course_name'].'</td>';

                if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
                $contents.='<td>$'.$course[$i]['amount'].'</td>';
                }
                $contents.='</tr>';

                }
                }
                if($course_o !=''){
                $contents .= 	'<tr>
                                <td>'.$course_o['course_code'].'</td>

                                <td>'.$course_o['course_name'].'</td>';
                                if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
                                $contents.='<td>$'.$course_o['amount'].'</td>';
                                }
                $contents.='</tr>';

                }
                if($subcourse != ''){
                $contents .= 	'<tr>
                <td>'.$subcourse['course_code'].'</td>

                <td>'.$subcourse['course_name'].'</td>';
                if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
                        $contents.='<td>$'.$subcourse['amount'].'</td>';
                }
                $contents.='</tr>';
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

                $contents		.= "<br/><br/><b>Call us anytime if you need anything!</b><br/><br/>";
                $contents		.= "<b>ADHI Schools, LLC </b>";
                
                $course_usertype = (isset($this->regdata['course_usertype'])) ? $this->regdata['course_usertype'] : $this->session->userdata('course_usertype');
                $course_type = $this->get_the_course_type($course_usertype);
                if($course_type == 'Online'){
                    $text = $contents_online;
                } else {
                    $text = $contents_live;
                }
                
                $contents = $text.$contents;
                
		$this->Common_model->send_mail($toemail,$from,$subject,$contents,'yes');

	}

	function send_renewal_mailto_user($mail,$usertype){
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
				</tr>';
                if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
			$contents		.='<tr>
					<td align="left"  width="150" >Course Amount </td>
					<td align="left"  width="150" > $'.$mail['courseprice'].' </td>
				</tr>';
                }


				$contents		.='</table>';

						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";

				$this->Common_model->send_mail($toemail,$from,$subject,$contents);

	}

		function new_send_mailto_user($mail,$order,$trackinfo,$usertype = ''){

		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course'],$usertype);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse'],$usertype);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o'],$usertype);
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
							<tr>
							<td><b>Course Code</b> </td>

							<td><b>Course Name</b> </td>
							<td><b>Course Price</b> </td>
							</tr>';
					if($course !=''){
					for($i=0; $i< count($course); $i++)
					{

				$contents .= 	'<tr>
							<td>'.$course[$i]['course_code'].'</td>

							<td>'.$course[$i]['course_name'].'</td>
							<td>$'.$course[$i]['amount'].'</td>
							</tr>';

					}
					}
					if($course_o !=''){
					$contents .= 	'<tr>
							<td>'.$course_o['course_code'].'</td>

							<td>'.$course_o['course_name'].'</td>
							<td>$'.$course_o['amount'].'</td>
							</tr>';

					}
					if($subcourse != ''){
					$contents .= 	'<tr>
							<td>'.$subcourse['course_code'].'</td>

							<td>'.$subcourse['course_name'].'</td>
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

		$this->Common_model->send_mail($toemail,$from,$subject,$contents,'yes');

	}
	function send_mailto_admin($mail,$order,$admin,$trackinfo, $usertype){

		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course'],$usertype);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse'],$usertype);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o'],$usertype);
		}

		$from ='';
		$toemail= $admin[0]['emailid'];
		$subject='Registration Details';
                $note_section = ($mail['note'] != '') ? '<tr>
					<td align="left"  height="100%" width="150" >Note</td>
					<td align="left"  height="100%" width="150" >'.$mail['note'].' </td>
				</tr>' : '';
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
                                '.$note_section.'
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
							<tr>
							<td><b>Course Code</b> </td>

							<td><b>Course Name</b> </td>';
					if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){

					$contents .='		<td><b>Course Price</b> </td>';
					}

					$contents.='</tr>';
					if($course !=''){
						for($i=0; $i< count($course); $i++)
						{

					$contents .= 	'<tr>
								<td>'.$course[$i]['course_code'].'</td>

								<td>'.$course[$i]['course_name'].'</td>';
					if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
					$contents.='<td>$'.$course[$i]['amount'].'</td>';
					}
					$contents.='</tr>';

						}
					}
					if($course_o !=''){
					$contents .= 	'<tr>
							<td>'.$course_o['course_code'].'</td>

							<td>'.$course_o['course_name'].'</td>';
							if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
							$contents.='<td>$'.$course_o['amount'].'</td>';
							}
					$contents.='</tr>';


					}
					if($subcourse != ''){
					$contents .= 	'<tr>
							<td>'.$subcourse['course_code'].'</td>

							<td>'.$subcourse['course_name'].'</td>';
							if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
							$contents.='<td>$'.$subcourse['amount'].'</td>';
							}
					$contents.='</tr>';


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

		function new_send_mailto_admin($mail,$order,$admin,$trackinfo,$usertype = ''){

		$this->load->model('Common_model');
		$course ='';
		if($mail['course']!=''){
		$course= $this->courselist($mail['course'],$usertype);
		}
		$state= $this->get_statename($order['b_state']);
		$subcourse= '';
		$course_o ='';
		if($mail['subcourse']!=''){
		$subcourse= $this->subcourselist($mail['subcourse'],$usertype);
		}
		if($mail['course_o']!=''){
		$course_o= $this->opcourselist($mail['course_o'],$usertype);
		}

		$from ='';
		$toemail= $admin[0]['emailid'];
                $cc_mails = $this->config->item("cc_mails");
                
                if($cc_mails != ""){
                    $toemail .= ','.$cc_mails;
                }
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
							<tr>
							<td><b>Course Code</b> </td>

							<td><b>Course Name</b> </td>
							<td><b>Course Price</b> </td>
							</tr>';
					if($course !=''){
						for($i=0; $i< count($course); $i++)
						{

					$contents .= 	'<tr>
								<td>'.$course[$i]['course_code'].'</td>

								<td>'.$course[$i]['course_name'].'</td>
								<td>$'.$course[$i]['amount'].'</td>
								</tr>';

						}
					}
					if($course_o !=''){
					$contents .= 	'<tr>
							<td>'.$course_o['course_code'].'</td>

							<td>'.$course_o['course_name'].'</td>
							<td>$'.$course_o['amount'].'</td>
							</tr>';

					}
					if($subcourse != ''){
					$contents .= 	'<tr>
							<td>'.$subcourse['course_code'].'</td>

							<td>'.$subcourse['course_name'].'</td>
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
	function courselist($course,$usertype=''){
		//print_r($course);
		$courselist='';
		if($course !=''){
		for($i=0;$i<count($course);$i++){
		/*if($course[$i] !=5){*/
			//$query= $this->db->query("select parent_course_name,course_code,course_name,amount from  adhi_courses  where id = '".$course[$i]."'");
			if($usertype!=''){
                    if($usertype=='1' || $usertype=='3' || $usertype=='5' || $usertype=='7'){
                        $query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$course[$i]."'");
                    }else{
						$query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$course[$i]."' and acp.course_type_id='".$usertype."'");
                    }
			}else {
				$query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$course[$i]."'");
			}
			@$result=$query->result_array();
                      //  echo $this->db->last_query();
                     /* echo '<pre>';
                      print_r($result[0]);
                      echo '</pre>';*/
			$courselist[$i]['parent_course_name']=@$result[0]['parent_course_name'];
			$courselist[$i]['course_code']=@$result[0]['course_code'];
			$courselist[$i]['course_name']=@$result[0]['course_name'];
			$courselist[$i]['amount']=@$result[0]['amount'];
			//}
		}
		//die();
		}
		if($courselist !='')
		return $courselist;
	}
	function subcourselist($subcourse,$usertype=''){
			//$query= $this->db->query("select parent_course_name,course_code,course_name,amount from  adhi_courses  where id = '$subcourse'");
			if($usertype!=''){
					if($usertype=='1' || $usertype=='3' || $usertype=='5' || $usertype=='7'){
                        $query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$subcourse."'");
                    }else{
						$query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$subcourse."' and acp.course_type_id='".$usertype."'");
                    }
			}else {
				$query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$subcourse."'");
			}
			$result=$query->result_array();
			$subcourselist['parent_course_name']=$result[0]['parent_course_name'];
			$subcourselist['course_code']=$result[0]['course_code'];
			$subcourselist['course_name']=$result[0]['course_name'];
			$subcourselist['amount']=$result[0]['amount'];
			return $subcourselist;
	}
	function opcourselist($opcourse,$usertype=''){

			//$query= $this->db->query("select parent_course_name,course_code,course_name,amount from  adhi_courses  where id = '$opcourse'");
			if($usertype!=''){
				if($usertype=='1' || $usertype=='3' || $usertype=='5' || $usertype=='7'){
                        $query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$opcourse."'");
                    }else{
						$query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$opcourse."' and acp.course_type_id='".$usertype."'");
                    }
			}else {
				$query= $this->db->query("select ac.parent_course_name,ac.course_code,ac.course_name,acp.amount from  adhi_courses ac join adhi_course_price acp on ac.id = acp.course_id  where acp.course_id = '".$opcourse."'");
			}
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

	function save_step1_reg_details($arr){
		$this->db->insert('adhi_user_reg_temp', $arr);
		return $this->db->insert_id();
	}
	function update_step2_reg_details($arr,$userid){
		$this->db->where('id', $userid);
		$updates	=	$this->db->update('adhi_user_reg_temp', $arr);
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;

		}
	}
	function send_registration_mail_to_admin($to, $data, $subject){
		$contents		= '';
                $note_section           = ($data['note'] != '') ? '<tr>
                                            <td align="left"  height="100%" width="150" >note</td>
                                            <td align="left"  height="100%" width="150" >'.$data['note'].' </td>
                                           </tr>' : '';
		$contents		.= 'Dear Administrator,<br/><br/> A new registration is in process. Please find the details below<br/><br/>';
                $contents		.= '<b>Account Details</b><br>';
                $contents		.='<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">
                                                    <tr>
                                                        <td align="left"  width="150" >First Name</td>
                                                        <td align="left"  width="150" >'.$data['firstname'].' </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"  width="150" >Last Name</td>
                                                        <td align="left"  width="150" >'.$data['lastname'].' </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"  width="150" >Email</td>
                                                        <td align="left"  width="150" >'.$data['emailid'].' </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"  width="150" >Phone Number</td>
                                                        <td align="left"  width="150" >'.$data['phone'].' </td>
                                                    </tr>
                                                    '.$note_section.'
                                                    <tr>
                                                        <td align="left"  width="150" >IP Address</td>
                                                        <td align="left"  width="150" >'.$data['ip_address'].' </td>
                                                    </tr>   
                                           </table>';
               $contents		.= "<br><br>With regards,<br><br>";
               $contents		.= "Adhi Schools";
               
               $this->Common_model->send_mail($to,'',$subject,$contents);
	}
	function coursename($course){
		$courselist='';
		if($course !=''){
		for($i=0;$i<count($course);$i++){
			$query= $this->db->query("select parent_course_name,course_code,course_name from  adhi_courses  where id = '".$course[$i]."'");
			$result=$query->result_array();
			$courselist[$i]['parent_course_name']= @$result[0]['parent_course_name'];
			$courselist[$i]['course_code']=@$result[0]['course_code'];
			$courselist[$i]['course_name']=@$result[0]['course_name'];
		}
		}
		if($courselist !='')
		return $courselist;
	}/**
         * Added function get course details
         * Created on 15th May 2013
         * Developer : sam@rainconcert.in
         *
         * @param array $course_id_arr
         * @return array $course details arr
         */

        function get_course_details($arr){
            $retDetails = array();

            $course_weight = 0.0;
            $course_amount = 0.0;

            $course_cnt = 0;
            $arrCourseDetails = array();

            if($arr['course'] !=''){
                for($i=0;$i<count($arr['course']);$i++){

                    $this->db->where('id',$arr['course'][$i]);
                    $adhi_courses = $this->db->get('adhi_courses');

                    if ($adhi_courses->num_rows() > 0){
                        $arrCourseDetails[$course_cnt] = $adhi_courses->row_array();

                        $course_weight += $arrCourseDetails[$course_cnt]['wieght'];
                        $course_amount += $arrCourseDetails[$course_cnt]['amount'];

                        $course_cnt++;
                    }
                }
            }

            if($arr['subcourse'] !=''){
                $this->db->where('id',$arr['subcourse']);
                $adhi_courses = $this->db->get('adhi_courses');

                if ($adhi_courses->num_rows() > 0){
                    $arrCourseDetails[$course_cnt] = $adhi_courses->row_array();

                    $course_weight += $arrCourseDetails[$course_cnt]['wieght'];
                    $course_amount += $arrCourseDetails[$course_cnt]['amount'];

                    $course_cnt++;
                }
            }

            if($arr['course_o'] !=''){
                $this->db->where('id',$arr['course_o']);
                $adhi_courses = $this->db->get('adhi_courses');

                if ($adhi_courses->num_rows() > 0){
                    $arrCourseDetails[$course_cnt] = $adhi_courses->row_array();

                    $course_weight += $arrCourseDetails[$course_cnt]['wieght'];
                    $course_amount += $arrCourseDetails[$course_cnt]['amount'];

                    $course_cnt++;
                }
            }

            $retDetails['course_weight'] = $course_weight;
            $retDetails['course_amount'] = $course_amount;
            $retDetails['arrCourseDetails'] = $arrCourseDetails;


            return $retDetails;
        }
        //function to get Course type
	function get_the_course_type($course_user_type = FALSE){
                if($course_user_type){
                    $query= $this->db->query("select * from  adhi_user_course_types where id = $course_user_type");
                    $result=$query->row_array();
                    $course_type=$result['course_type'];
                    return $course_type;
                }
                return true;
	}
	//end
        
        /**
         * Added function get save_reg_in_process details
         * Created on 04 Dec 2015
         * Developer : syama.s@rainconcert.in
         *
         * @param array $data
         * @return boolean
         */
        
        function save_reg_in_process($data = array()){
            $this->db->insert('adhi_reg_in_process', $data);
            $adhi_reg_process_id   = $this->db->insert_id();
            return $adhi_reg_process_id;
	}
        
        function getTrialUserByEmail($email){
            if('' != $email){
        	$this->db->where('email', $email);
                $this->db->select("id, first_name, last_name, status");
                $query	= $this->db->get('adhi_trial_users');
		if($query->row()){
                    return $query->row();
                }
            }
            return FALSE;
        }
        
        
        function trial_user_change_password($userid, $password){
            $data = array('password' => $password, 'updated_at' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
            $this->db->set($data);
            $this->db->where('id', $userid);
            return $this->db->update('adhi_trial_users');
	}
        
        function getProfileProgress($user_id){
            $this->db->where('user_id', $user_id);
            $query	= $this->db->get('adhi_user_profile_progress');
            return ($query) ? $query->result_array() : FALSE;
        }
        
        function insertProfileProgress($data){
            $this->db->set($data);
            return $this->db->insert('adhi_user_profile_progress');
        }
        
        function updateProfileProgress($data, $user_id, $item){
            $this->db->set($data);
            $this->db->where('user_id', $user_id);
            $this->db->where('item', $item);
            return $this->db->update('adhi_user_profile_progress');
        }
        
        function getDrivingLicense($user_id){
            $this->db->select('driving_license');
            $this->db->where('id', $user_id);
            $query	= $this->db->get('adhi_user');
            $result = $query->row();
            return (isset($result->driving_license)) ? $result->driving_license : '';
        }
 }

?>