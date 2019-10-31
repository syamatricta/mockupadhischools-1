<?php
class Register_ajax extends Controller {
                
                var $gen_contents       = array();
		var $payment_contents   = array();
                var $ship_contents      = array();
                var $course_contents    = array();
                //var $user_forum_contents= array();//Disabling forum
                var $order_updates      = array();
                var $mail_contents      = array();
                var $regdata            = array();
        
                function Register_ajax(){
                    parent::Controller();
                    $this->load->helper("form");
                    $this->load->helper('url');
                    $this->load->model('Common_model');
                    $this->regdata    = $this->session->userdata('reg_data');

		}
                
                function register(){
                    $this->load->model('user_model');
                    $this->load->library("form_validation");
                    $this->gen_contents['errors']   = '';
                    $this->gen_contents['proceed']  = 1;
                    $this->reg = array();
                    $step   = $this->input->post('step');
                    $this->_registration_rules($step);
                    if(1 == $step){
                        $this->reg_step1($step);
                    }else if(2 == $step){
                        $this->reg_step2($step);
                        $this->gen_contents['reg_data'] = $this->regdata;
                    }else if(3 == $step){
                        $this->reg_step3($step);
                    }else{
                        $this->gen_contents['proceed']  = 0;
                    }
                   
                    $data['return_value']   = json_encode($this->gen_contents);
                    $this->load->view ('dsp_show_ajax',  $data);
                }
                
                function reg_step1($step){        
                    if($this->form_validation->run() == TRUE) {
                        //$reg_data['admindetails'] = $this->user_model->get_admin();	
                        $check      = $this->user_model->checkuser($this->input->post('email'));
                        $check_blog = $this->user_model->checkuser_blog($this->input->post('email'));      

                        if($check <= 0 && $check_blog <= 0){
                            $regdata   = $this->regdata;
                            if(!isset($regdata['emailid'])){
                                $this->_session_set_reg_data($step);
                                $mailcontent    = $this->_mail_content();
                                $admin          = $this->user_model->get_admin();
                                $reg_data       = $this->regdata;
                                /* Registration in process save mail starts */
                                $save_data = array(
                                    'reg_ip_address'        => $this->input->ip_address() ,
                                    'reg_first_name'        => $reg_data['firstname'],
                                    'reg_last_name'         => $reg_data['lastname'],
                                    'reg_email'             => $reg_data['emailid'],
                                    'reg_phone'             => $reg_data['phone'],                                    
                                    'reg_date'       => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                    'created_by'     => 0,
                                    'status'         => 1
                                );
                                $this->user_model->save_reg_in_process($save_data);
                                /* Registration in process save mail ends */
                                $sendmail = $this->user_model->send_registration_mail_to_admin($this->config->item('guest_pass_enquiry'), $mailcontent, 'Registration in process');
                            }else{
                                $this->_session_set_reg_data($step);    
                            }
                            
                            
                        } else if ($check > 0 ){
                            $this->gen_contents['proceed']  = 0;
                            $this->gen_contents['errors']   = "Email Already Exist";
                        }		
                        
                    }else{
                        $this->gen_contents['proceed']  = 0;
                        $this->gen_contents['errors']   = validation_errors();
                    }
                }
                
                function reg_step2($step){
                    if($this->form_validation->run() == TRUE) {
                        $this->gen_contents['reset_shipping']  = 0;
                        if(
                            isset($this->regdata['s_state']) && $this->regdata['s_state'] != $this->input->post('state')
                                ||
                            isset($this->regdata['s_zipcode']) && $this->regdata['s_zipcode'] != $this->input->post('state')
                        ){
                            $this->gen_contents['reset_shipping']  = 1;
                        }
                        $this->_session_set_reg_data($step);
                        $this->gen_contents['reg_data'] = $this->session->userdata('red_data');
                    }else{
                        $this->gen_contents['proceed']  = 0;
                        $this->gen_contents['errors']   = validation_errors();
                    }
                }
                
                function reg_step3(){
                    $this->load->helper("form");
                    $this->load->helper("fedex");
                    $new_package = 0;
                    $this->load->library("form_validation");			
                    $this->load->model('Common_model');
                    $this->load->model('user_model');
                    if($this->form_validation->run() == TRUE) {
                        
                        //Rechecking the promocode if entered
                        $this->gen_contents["proceed"]  = $this->_recheck_promocode();
                        if(1 == $this->gen_contents["proceed"]){
                            $state		= $this->user_model->selectstate($this->regdata['b_state']);
                            $name 		= $this->regdata['firstname']." ".$this->regdata['lastname'];
                            $emailid	= $this->regdata['emailid'];
                            $course_name    = '';
                            $course         = '';
                            $subcourseid    = '';
                            $course_o       = '';

                            // assign new zipcode to session
                            /*$this->session->set_userdata('zipcode', $this->input->post('s_zipcode'));
                            $this->session->set_userdata('s_zipcode', $this->input->post('s_zipcode'));*/

                            $this->_reg_session_replace_with_new(array('zipcode' => $this->input->post('s_zipcode'), 's_zipcode' => $this->input->post('s_zipcode')));
                            /* added by shinu for broker /sales packages starts here */
                            $usertype = $this->regdata['course_usertype'];

                            // broker
                            if($usertype == 1 || $usertype == 3){
                                $courseids  = $this->Common_model->getCourseweight();
                                $course     = array();
                                foreach($courseids as $courseid){
                                    $course[] = $courseid->id;
                                }

                                $courselist = $this->user_model->coursename($course);	
                                if($course  !=''){							
                                    for($i=0; $i< count($courselist); $i++){
                                        if($course_name !='')		
                                            $course_name    = $course_name.",".$courselist[$i]['course_name'];
                                        else
                                            $course_name    = $courselist[$i]['course_name'];
                                    }
                                }
                            //sales
                            }else if($usertype == 5 || $usertype == 7){
                                /* For New Package*/
                                if($this->input->post('new_package') == 1){
                                    $courseids= $this->Common_model->licensecourselist_m(11);
                                    $new_package = 1;
                                }else{
                                    $courseids= $this->Common_model->licensecourselist_m(6);
                                }


                                $course         = array();
                                foreach($courseids as $courseid){
                                    $course[]   = $courseid['course_id'];
                                }
                                if($this->input->post('new_package') != 1)
                                    $course[]   = $this->input->post('hidcrsid');

                                $courselist= $this->user_model->coursename($course);	
                                if($course  !=''){							
                                    for($i=0; $i< count($courselist); $i++){
                                        if($course_name !='')		
                                            $course_name    = $course_name.",".$courselist[$i]['course_name'];
                                        else
                                            $course_name    = $courselist[$i]['course_name'];
                                    }
                                }
                            }else {
                                /* added by shinu for broker packages ends here */
                                if($this->input->post('course')){
                                    $course     = $this->input->post('course');
                                    //$courselist= $this->user_model->courselist($this->input->post('course'));
                                    $courselist = $this->user_model->coursename($this->input->post('course'));	
                                    if($course  !=''){							
                                        for($i=0; $i< count($courselist); $i++){
                                            if($course_name !='')		
                                                $course_name    = $course_name.",".$courselist[$i]['course_name'];
                                            else
                                                $course_name    = $courselist[$i]['course_name'];
                                        }
                                    }
                                }

                                if($this->input->post('subcourse')){
                                    $subcourseid    = $this->input->post('subcourse');
                                    if($subcourseid  !=''){
                                        $subcourselist= $this->user_model->subcourselist($this->input->post('subcourse'));									

                                        if($course_name !='')		
                                            $course_name=$course_name.",".$subcourselist['course_name'];
                                        else
                                            $course_name=$subcourselist['course_name'];

                                    }

                                }
                                if($this->input->post('course_b')){
                                    $course_o       = $this->input->post('course_b');
                                    if($course_o  !=''){
                                        $opcourselist   = $this->user_model->opcourselist($course_o);	

                                        if($course_name !='')		
                                            $course_name    = $course_name.",".$opcourselist['course_name'];
                                        else
                                            $course_name    = $opcourselist['course_name'];

                                    }
                                }
                            }
                            //echo '<pre>';print_r($course);die();
                            //init payment details - Registration
                            $this->_init_user_paymentdetails($state[0]['state']);
                            $temp_result = $this->saveDataInTemp($name,$emailid,$course_name,$course,$usertype,$new_package);
                            $data['payment']= $this->user_model->payment($this->payment_contents);
                            //$data['payment'] = array("ACK" => "SUCCESS", "TRANSACTIONID" => '111222333444');
                            //echo '<pre>';print_r($data['payment']);die();
                            $this->gen_contents['payment']  = $data['payment'];
                            if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
                                    echo "Testing";exit;
                                    $redirect_action	= "reg_result_success";
                                    /**
                                    *paymentlog
                                    **/							
                                    $status     = $data['payment']["ACK"];							
                                    $this->_init_payment_log($name,$emailid,$status,$course_name);
                                    $this->user_model->paymentlog($this->payment_log);
                                    /*****/

                                    $this->_init_user_registration($data['payment']["TRANSACTIONID"]);
                                    //New package update
                                    $this->user_contents["sales_new_package"] = $new_package;
                                    $register_user = 0;
                                    if($this->input->post('register_user')) {
                                        $register_user = 1;
                                    }

                                    $result = $this->user_model->userregistration($this->user_contents, $register_user);

                                    /* Update adhi_trial_users after registration */
                                    $this->load->model('trial_account_model');
                                    $trial_userid   = 0;
                                    if($this->authentication->logged_in("trial")){
                                        $trial_userid   = s('TRIAL_USERID');
                                    }else if($trial_user = $this->trial_account_model->userExists($this->user_contents['emailid'])){
                                        $trial_userid   = $trial_user->id;
                                    }
                                    if($trial_userid > 0){
                                        $trial_data = array(
                                                            'status'        => 2,
                                                            'reg_user_id'   => $result,
                                                            'updated_at'    => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                                        );
                                        $this->trial_account_model->update($trial_userid, $trial_data);
                                        $this->authentication->logout();
                                    }

                                    /*
                                     * Disabing forum                                 
                                        $this->_user_forum_data($data['payment']["TRANSACTIONID"]);                                
                                        $result_forum=$this->user_model->adduser_forum($this->user_forum_contents);
                                        if($result > 0 || $result_forum > 0) {
                                    */
                                    if($result > 0) {
                                            $this->order_contents['userid'] =$result;
                                            //Abhinand here the shipping method is trimmed to get rid of _ and assing white spaces in them
                                            //$this->order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
                                            $this->order_contents['ship_method']    = str_replace("_"," ",$this->input->post('shipid'));
                                            $this->order_contents['packaging_type'] = get_fedex_packaging_type(count($course));

                                            $result1=$this->user_model->order($this->order_contents);

                                            if($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7){
                                                    $savecourse = $course;
                                            }else {
                                                    $savecourse = $this->input->post('course');
                                                    if($this->input->post('subcourse')){
                                                        $subcourseid    = $this->input->post('subcourse');
                                                    }else{
                                                        $subcourseid    = '';
                                                    }
                                                    if($this->input->post('course_b')){
                                                        $course_o       = $this->input->post('course_b');
                                                    }else{
                                                        $course_o       = '';
                                                    }
                                            }
                                            $this->course_contents  = array(						
                                                                            "course"        => $savecourse,
                                                                            "subcourse"     => $subcourseid,
                                                                            "course_o"      => $course_o,
                                                                            "userid"        => $result,
                                                                            "orderid"       => $result1,
                                                                            "enrolled_date" => $this->order_contents['orderdate']
                                                                        );

                                            $result2                = $this->user_model->usercourse($this->course_contents);
                                            //$this->_init_user_ship();
                                            $this->_init_recipient();

                                            $courseDetails      = $this->user_model->get_course_details($this->course_contents);
                                            $course_weight      = $courseDetails['course_weight'];
                                            $course_amount      = $courseDetails['course_amount'];
                                            $arrCourseDetails   = $courseDetails['arrCourseDetails'];
                                            if(IS_FEDEX_ONE_RATE_ENABLED){
                                                $courseDetails['packagingType'] = $this->order_contents['packaging_type'];
                                            }
                                            $this->_init_package($courseDetails);

                                            //$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
                                            //$this->ship_contents['courseweight'] = $course_weight;
                                            //$ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});


                                            $aryOrder   = get_fedex_order_array(count($course));

                                            //$ship       = setShipment($aryOrder,$this->aryRecipient,$this->realPackages,$course_amount,$course_weight);
                                            $ship         = 'error';
                                            $this->_int_user_mail($this->course_contents);
                                            $this->order_updates    = array();

                                            if($ship !='error'){	

                                                /*$this->order_updates =array(						
                                                                        "trackingno" => $ship[29],
                                                                        "label_path" => $ship['label'],
                                                                        "status" => 'S'
                                                                        );*/
                                                $this->order_updates    = array(						
                                                                            "trackingno" => $ship['trackingno'],
                                                                            "label_path" => $ship['label'],
                                                                            "status" => 'S'
                                                                        );
                                                $orderid                = $result1;
                                                $this->user_model->updateorder($this->order_updates,$orderid);

                                                $this->gen_contents['page_view']    = $this->load->view('reskin/register/reg_result_success', '', TRUE);
                                                //$this->session->set_flashdata('msg',"Registration completed successfully");

                                            } else{ 
                                                $this->order_updates    = '';
                                                $admin = $this->user_model->get_admin();
                                                $this->session->set_flashdata('msg',"Registration completed successfully. Administrator will reship it");
                                                $this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents, $admin ,$this->order_updates,$usertype);
                                                $this->gen_contents['page_view']    = $this->load->view('reskin/register/reg_result_success_reship', '', TRUE);
                                            }
                                            $this->user_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates,'admin',$usertype);
                                            /// What $usertype is missing, need to findout
                                            ///$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);

                                            if($temp_result){
                                                $this->user_model->temp_userregistration_update($temp_result,$data['payment']["TRANSACTIONID"]);
                                            }
                                            $this->session->sess_destroy();
                                    }else {
                                        $this->gen_contents["error"]    = "Failed to register the user";
                                        $this->gen_contents['proceed']  = 0;
                                    }							
                            }else{
                                $this->gen_contents["errors"]="Payment transaction failed. ".urldecode($data['payment']['L_LONGMESSAGE0']);
                                $this->gen_contents['proceed']  = 0;
                                /**
                                *paymentlog
                                **/		
                                $status = urldecode($data['payment']['L_LONGMESSAGE0']);
                                $this->_init_payment_log($name,$emailid,$status,$course_name);
                                $this->user_model->paymentlog($this->payment_log);
                                
                                if($temp_result){
                                    $this->user_model->temp_userregistration_update($temp_result,"PAYMENT FAILED");
                                }
                                /**end **/
                                //$this->_int_user_register_course();//die('ff');

                            }
                        }
                    } else{
                           $this->gen_contents['errors']   = validation_errors();
                           $this->gen_contents['proceed']  = 0;
                    }
			
                }
                
                
                
                
                
                
                function _registration_rules($step){
                    if(1 == $step){
                        $this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
                        $this->form_validation->set_rules('lastname', 'LAST NAME', 'required|max_length[128]');
                        $this->form_validation->set_rules('confirm_name', 'CONFIRM NAME', 'required');
                        $this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email|max_length[128]');
                        $this->form_validation->set_rules('confirm_email', 'CONFIRM EMAIL', 'required|max_length[128]');
                        $this->form_validation->set_rules('psword', 'PASSWORD', 'required');
                        $this->form_validation->set_rules('psword1', 'CONFIRM PASSWORD', 'required');                    
                        $this->form_validation->set_rules('phone', 'PHONE NO', 'required');                        
                    }else if(2 == $step){                        
                        $this->form_validation->set_rules('txtLicencetype', 'License Type', 'required');
                        $this->form_validation->set_rules('txthowhear', 'How did you hear about us?', 'required|max_length[250]');

                        $this->form_validation->set_rules('address', 'ADDRESS', 'required|max_length[128]');
                        $this->form_validation->set_rules('state', 'STATE', 'required');
                        $this->form_validation->set_rules('city', 'CITY', 'required');
                        $this->form_validation->set_rules('country', 'COUNTRY', 'required');
                        $this->form_validation->set_rules('zipcode', 'ZIPCODE', 'required');
                        $this->form_validation->set_rules('driving_license', 'DRIVERS LICENSE NUMBER', 'required|max_length[20]');

                        $this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
                        $this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
                        $this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
                        $this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
                        $this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
                        $this->form_validation->set_rules('txtSearchengine');
                        $this->form_validation->set_rules('txtREO');
                    }else if(3 == $step){
                        $this->form_validation->set_rules('shipid', 'Ship Method', 'required');
                        $this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
                        $this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
                        $this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
                        $this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
                        $this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
                    }
                }
                
                function _session_set_reg_data($step){
                    if(1 == $step){
                        $reg_data =array(		
                            "firstname"             =>  $this->Common_model->safe_html($this->input->post('firstname')),
                            "lastname"              =>  $this->Common_model->safe_html($this->input->post('lastname')),
                            "name_on_certificate"   =>  $this->Common_model->safe_html($this->input->post('firstname'))." ".$this->Common_model->safe_html($this->input->post('lastname')),
                            "confirm_name"          =>  $this->Common_model->safe_html($this->input->post('confirm_name')),
                            "emailid"               =>  $this->Common_model->safe_html($this->input->post('email')),
                            "confirm_email"         =>  $this->Common_model->safe_html($this->input->post('confirm_email')),
                            "password"              =>  md5($this->Common_model->safe_html($this->input->post('psword'))),
                            "orgpassword"           =>  $this->Common_model->safe_html($this->input->post('psword')),
                            "phone"                 =>  $this->Common_model->safe_html($this->input->post('phone')),                            
                            "note"                  =>  $this->Common_model->safe_html($this->input->post('note'))
                        );
                    }else if(2 == $step){
                        $reason = '';
			if($this->Common_model->safe_html($this->input->post('txthowhear')) == 'Search engine'){
                            $reason = $this->Common_model->safe_html($this->input->post('txtSearchengine'));
			}else if($this->Common_model->safe_html($this->input->post('txthowhear')) == 'Referral from a real estate office'){
                            $reason = $this->Common_model->safe_html($this->input->post('txtREO'));
			}
			$reg_data  = array(
                                                //"forum_alias"               =>  $this->regdata['firstname']." ".$this->regdata['lastname'], // Disabling forum
                                                "licensetype"               => 	$this->input->post('txtLicencetype'),
                                                "unit_number"               =>	$this->Common_model->safe_html($this->input->post('unitnumber')),
                                                "testimonial"               => 	$this->Common_model->safe_html($this->input->post('txthowhear')),
                                                "reason"                    => 	$reason,
                                                "b_address"                 => 	$this->Common_model->safe_html($this->input->post('b_address')),
                                                "b_state"                   => 	$this->input->post('b_state'),
                                                "b_city"                    => 	$this->Common_model->safe_html($this->input->post('b_city')),
                                                "b_zipcode"                 =>	$this->Common_model->safe_html($this->input->post('b_zipcode')),
                                                "driving_license"           =>  generate_hash($this->Common_model->safe_html($this->input->post('driving_license'))),
                                                "b_country"                 => 	$this->input->post('b_country'),
                                                "billing_sameas_shipping"   => 	$this->input->post('setaddr'),
                                                "s_address"                 => 	$this->Common_model->safe_html($this->input->post('address')),
                                                "s_state"                   => 	$this->input->post('state'),
                                                "s_city"                    => 	$this->Common_model->safe_html($this->input->post('city')),
                                                "s_zipcode"                 =>	$this->Common_model->safe_html($this->input->post('zipcode')),
                                                "s_country"                 => 	$this->input->post('country')
					);
                    }
                    $this->_reg_session_replace_with_new($reg_data);
                    
                }
                
                function _reg_session_replace_with_new($reg_data){
                    $prev_data  = ('' == $this->session->userdata('reg_data')) ? array(): $this->regdata;
                    $reg_data   = array_merge($prev_data, $reg_data) ;
                    $this->session->set_userdata('reg_data', $reg_data);
                    $this->regdata = $this->session->userdata('reg_data');
                }
                
                function _init_user_paymentdetails($state){
				$this->payment_contents = array(		
                                                            "firstname" => $this->regdata['firstname'],
                                                            "lastname"	=> $this->regdata['lastname'],
                                                            "ccno" 	=> $this->Common_model->safe_html($this->input->post('ccno')),
                                                            "cardtype" 	=> $this->input->post('cardtype'),
                                                            "expmonth" 	=> $this->input->post('expmonth'),
                                                            "expyear" 	=> $this->input->post('expyear'),
                                                            "cvv2no" 	=> $this->Common_model->safe_html($this->input->post('cvv2no')),
                                                            "address1" 	=> $this->regdata['b_address'],
                                                            "zipcode" 	=> $this->regdata['b_zipcode'],
                                                            "country" 	=> $this->regdata['b_country'],
                                                            "state" 	=> $this->regdata['b_state'],//$state,
                                                            "city" 	=> $this->regdata['b_city'],
                                                            "amount" 	=> $this->input->post('totalprice')
                                                        );
		}
                
                function _init_package($courseDetails){
                    $package_weight     = $courseDetails['course_weight'];
                    $est_amount         = $courseDetails['course_amount'];
                    $arrCourseDetails   = $courseDetails['arrCourseDetails'];
                    $packagingType      = isset($courseDetails['packagingType']) ?  $courseDetails['packagingType'] : '';

                    $order_id           = $this->course_contents['orderid'];
                    
                    $packetDescription  = "FEDEX Package for order ".$order_id;
                    $packageDetails     = array(
                                                0 => array(
                                                    'weight'            => $package_weight,
                                                    'ItemDescription'   => $packetDescription
                                                )
                                            );
                    $packageDetails[0]     = array_merge($packageDetails[0], get_fedex_packaging_dimension($packagingType));

                    $cnt = 0;
                    foreach($arrCourseDetails as $courseDetails){
                        $aryPackageItems[$cnt]['item_qty'] = 1;
                        $aryPackageItems[$cnt]['item_price'] = $courseDetails['amount'];
                        $aryPackageItems[$cnt]['item_name'] = $courseDetails['course_name'];
                        $aryPackageItems[$cnt]['item_weight'] = $courseDetails['wieght'];
                        
                        $cnt++;
                    }
                    
                    $this->realPackages = array(
                                                0 => array(
                                                    'packageDetails' => $packageDetails,
                                                    'aryPackageItems' => $aryPackageItems,  
                                                    'package_amount' => $est_amount
                                                )
                                            );
                    
                    

                    
                }
                
                function _mail_content(){
                    return array(		
                            "firstname"         => $this->Common_model->safe_html($this->input->post('firstname')),
                            "lastname"          => $this->Common_model->safe_html($this->input->post('lastname')),
                            "emailid"           => $this->Common_model->safe_html($this->input->post('email')),
                            "orgpassword"       => $this->Common_model->safe_html($this->input->post('psword')),
                            "phone"             => $this->Common_model->safe_html($this->input->post('phone')),
                            "note"              => $this->Common_model->safe_html($this->input->post('note')),
                            "ip_address"        => $this->input->ip_address()
                    );
		}
                
                function _int_user_mail($course){
                    $this->mail_contents = array(
                                                "name" 			=> $this->regdata['firstname']." ".$this->regdata['lastname'],
                                                "useremail" 		=> $this->regdata['emailid'],
                                                "password" 		=> $this->regdata['orgpassword'],
                                                "course" 		=> $course['course'],
                                                "subcourse" 		=> $course['subcourse'],
                                                "course_o" 		=> $course['course_o'],
                                                "note"                  => $this->regdata['note']
                                            );
		}
                
                
                /**
                 * Added function init recepient
                 * Created on 14th May 2013
                 * Developer : sam@rainconcert.in
                 */
                function _init_recipient(){
                    
                    if ($this->regdata['firstname'] || $this->regdata['lastname']){
                        $user_name = $this->regdata['firstname']." ".$this->regdata['lastname'];
                    }else{
                        $user_name = get_loggedin_username();
                    }


                    $this->aryRecipient = array(
                                            'Contact' => array(
                                                    'PersonName' => $user_name,
                                                    //'CompanyName' => 'Company Name',
                                                    'PhoneNumber' => $this->input->post('bphone')
                                            ),
                                            'Address' => array(
                                                    'StreetLines'           => $this->regdata['s_address'].', '.$this->regdata['unit_number'],
                                                    'City'                  => $this->regdata['s_city'],
                                                    'StateOrProvinceCode'   => $this->regdata['s_state'],
                                                    'PostalCode'            => $this->regdata['s_zipcode'],
                                                    'CountryCode'           => $this->regdata['s_country'],
                                                    'Residential'           => false)
                                        );
                }
                
                function _init_payment_log($name,$emailid,$status,$course_name){
                        $this->payment_log = array(
                                                "name"          => 	$name,						
                                                "emailid" 	=> $emailid,
                                                "paymentdate"	=> convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
                                                "b_address" 	=> $this->regdata['b_address'].",".$this->regdata['b_city'].
                                                                                                        ",".$this->session->userdata('b_state').",".$this->regdata['b_country'].",".$this->regdata['b_zipcode'],

                                                "s_address" 	=> $this->regdata['s_address'].",".$this->regdata['s_city'].
                                                                                                        ",".$this->regdata['s_state'].",".$this->regdata['s_country'].",".$this->regdata['s_zipcode'],
                                                "coursename" 	=> $course_name,
                                                "status" 	=> $status
                                                );
		}
                
                
                function _init_user_registration($transactionid){
                    $this->user_contents    = array(		
                                                    "firstname"             => 	$this->regdata['firstname'],
                                                    "lastname"              => 	$this->regdata['lastname'],
                                                    "name_on_certificate"   =>  $this->regdata['name_on_certificate'],
                                                    //"forum_alias"           => 	$this->regdata['forum_alias'],//Disabling forum
                                                    "emailid"               => 	$this->regdata['emailid'],
                                                    "password"              => 	$this->regdata['password'],							
                                                    "address"               => 	$this->regdata['s_address'],
                                                    "state"                 => 	$this->regdata['s_state'],
                                                    "city"                  => 	$this->regdata['s_city'],
                                                    "zipcode"               => 	$this->regdata['s_zipcode'],
                                                    "country"               => 	$this->regdata['s_country'],
                                                    "phone"                 => 	$this->regdata['phone'],
                                                    "driving_license"       => 	$this->regdata['driving_license'],
                                                    "note"                  =>  $this->regdata['note'],    
                                                    "testimonial"           => 	$this->regdata['testimonial'],	
                                                    "reason"                =>	$this->regdata['reason'],
                                                    "licensetype"           => 	$this->regdata['licensetype'],
                                                    "b_address"             => 	$this->regdata['b_address'],
                                                    "b_country"             => 	$this->regdata['b_country'],
                                                    "b_state"               => 	$this->regdata['b_state'],
                                                    "b_city"                => 	$this->regdata['b_city'],
                                                    "billing_sameas_shipping" 	=> 	$this->regdata['billing_sameas_shipping'],
                                                    "b_zipcode"             => 	$this->regdata['b_zipcode'],
                                                    "s_address"             => 	$this->regdata['s_address'],
                                                    "s_country"             =>	$this->regdata['s_country'],
                                                    "s_state"               => 	$this->regdata['s_state'],
                                                    "s_city"                => 	$this->regdata['s_city'],
                                                    "s_zipcode"             => 	$this->regdata['s_zipcode'],
                                                    "course_user_type"      =>  $this->regdata['course_usertype'],
                                                    "unit_number"           =>  $this->regdata['unit_number'],
                                                );
			
			
			$this->order_contents =array(
							"b_address"     => $this->regdata['b_address'],
							"b_country" 	=> $this->regdata['b_country'],
							"b_state" 	=> $this->regdata['b_state'],
							"b_city" 	=> $this->regdata['b_city'],
							"b_zipcode" 	=> $this->regdata['b_zipcode'],
							"s_address" 	=> $this->regdata['s_address'],
							"s_country" 	=> $this->regdata['s_country'],
							"s_state" 	=> $this->regdata['s_state'],
							"s_city"	=> $this->regdata['s_city'],
							"s_zipcode" 	=> $this->regdata['s_zipcode'],
							"total_amount"	=> $this->input->post('totalprice'),
							"ship_rate" 	=> $this->input->post('shipprice'),
							"course_price" 	=> (float) $this->input->post('totalprice') - (float) $this->input->post('shipprice'),//$this->input->post('price'),
							"transactionid"	=> $transactionid,
							"payment_method"=> 'Paypal Payment Method',
							"orderdate" 	=> convert_UTC_to_PST_date(date('Y-m-d H:i:s')),                                                        
							);
                        if($this->input->post('is_promocode_applied') == 1){
                            $this->order_contents['is_promocode_applied']   = 1;
                            $promocode      = $this->input->post('hid_promocode');
                            $detail         = $this->user_model->getPromocodeDetails($promocode);
                            $this->order_contents['promocode_details']      = json_encode(array(
                                'promocode'                     => $promocode,
                                'promocode_id'                  => $detail->id,
                                'redeem_type'                   => $detail->redeem_type,
                                'redeem_value'                  => $detail->redeem_value,
                                'grand_total_before_promocode'  => $this->input->post('grand_total_before_promocode'),
                                'grand_total_after_promocode'   => $this->input->post('grand_total_after_promocode')
                            ));
                        }
		
		}
                
                /*
                 * Disabing forum
                function _user_forum_data($transactionid){
			$this->user_forum_contents =array(
							"usergroupid"       => 	2,
							"displaygroupid"    => 	0,
							"username"          => 	$this->regdata['emailid'],
							"password"          => 	$this->regdata['password'],
							"email"             => 	$this->regdata['emailid'],
							"showvbcode"        => 	'vb',
                                                        "firstname"         => 	$this->regdata['firstname'],
							"lastname"          => 	$this->regdata['lastname'],
							"forum_alias"       => 	$this->regdata['forum_alias'],
							"usertitle"         => 	'Junior Member'
							);

		}
                 */
                                
   function get_ship(){

            $this->load->helper('fedex');

            $aryRecipient = array(
                    'Contact' => array(
                            'PersonName'    => 'Recipient Name',
                            'CompanyName'   => 'Company Name',
                            'PhoneNumber'   => $this->input->post("s_phone")
                    ),
                    'Address' => array(
                            'StreetLines'   => /*array('Address Line 1')*/ $this->input->post('s_address').", ".$this->regdata['unit_number'],
                            'City'          => $this->input->post("s_city"),
                            'StateOrProvinceCode' => $this->input->post("s_state"),
                            'PostalCode'    => $this->input->post("s_zipcode"),
                            'CountryCode'   => $this->input->post("s_country"),
                            'Residential'   => false)
            );

            $packageDetails = array(
                                0 => array(
                                    'weight' => $this->input->post("weight"),
                                    'length' => "",
                                    'width' => "",
                                    'height' => ""
                                )
                            );

            $total_packages = count($packageDetails);
            $aryPackage = getPackage($packageDetails);

           $aryOrder    = get_fedex_order_array($this->input->post("book_count"));
           /* $aryOrder = array(
                            'TotalPackages' => $total_packages,
                            'PackageType' => 'YOUR_PACKAGING',        #FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                            'ServiceType' => 'INTERNATIONAL_PRIORITY',
                            'TermsOfSaleType' => "DDU",         #    DDU/DDP
                            'DropoffType' => 'REGULAR_PICKUP'         # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                    );*/
            $ratedetails = getRate($aryRecipient, $aryOrder, $aryPackage);

            $rateService    = array();
            $cnt            = 0;
            if (!empty($ratedetails['rateReply'])){
                if(IS_FEDEX_ONE_RATE_ENABLED){
                    $rateService[$cnt]['service']   = str_replace('_', ' ', $ratedetails['rateReply']->ServiceType);
                    $rateService[$cnt]['methodno']  = $ratedetails['rateReply']->ServiceType;
                    $rateService[$cnt]['fedexno']   = 1;
                    $rateService[$cnt]['rate']      = $ratedetails['rateReply']->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                }else {

                    foreach ($ratedetails['rateReply'] as $rateReply){

                        $rateService[$cnt]['service']   = str_replace('_', ' ', $rateReply->ServiceType);
                        $rateService[$cnt]['fedexno']   = 1;
                        $rateService[$cnt]['methodno']  = $rateReply->ServiceType;
                        $rateService[$cnt]['rate']      = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;

                        $cnt++;
                        //$rateService[$rateReply->ServiceType]['AMOUNT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                        //$rateService[$rateReply->ServiceType]['UNIT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;
                        //echo $rateReply->ServiceType.' => '.$rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount.'<br/>';
                    }
                }
            }else{
                $rateService['error'] = (isset($ratedetails['error'])) ? $ratedetails['error'] : 'Error occured while fetching shipping rate. Please try later';
            }
            $data['return_value'] = $rateService;
			$view = $this->input->post("view");
                        
            $course_type    = $this->input->post('course_type');
            $package_type   = $this->input->post('package_type');
            $license_type   = $this->input->post('license_type');

            $data['show_promocode_div'] = $this->_is_promocode_available($license_type, $course_type, $package_type);
			if(isset($view) && $this->input->post("view")=='bs'){
			    $this->load->view ('reskin/register/dsp_show_ship',  $data);
			}else{
			    $this->load->view ('dsp_show_ship',  $data);
			}
            

        }


  		function admin_get_courses(){
            $usertype_newpackage = "";
  			$this->load->model('user_model');
			if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '1';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Cart')){
				$usertype= '2';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Package')){
				$usertype= '3';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '4';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '5';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '6';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '7';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '8';
			}else {
				$usertype = '';
			}
			$data['license']	= $this->input->post("licensetype");

			$data['month']=$this->user_model->listmonth();
			$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
			$data['year']=$this->user_model->listyear($currentyear);

            $this->session->set_userdata (array('course_usertype'=>$usertype));
                        
			$this->load->model('common_model');
			$data['courses'] = $this->common_model->getCourses($usertype);

			/* New Package starts here*/
            if($usertype == 5){
                $usertype_newpackage = 9;
            }else{
                $usertype_newpackage = 10;
            }
            $data['courses_newpackage'] = $this->common_model->getCourses($usertype_newpackage);
            /* New Package ends here*/
                        
			//$data['coursearr']=$this->common_model->listallcourses();

			$data['courses_m']=$this->common_model->licensecourselist_m($usertype);
			$data['courses_o']=$this->common_model->licensecourselist_o($usertype);

		    //$data['subcourses']=$this->Common_model->subcourselist();
			if(1 == $usertype || 3 == $usertype){
				$data['course_weight'] = $this->common_model->getCourseweight();
				$data['total_weight']  = 0.0;
				foreach($data['course_weight'] as $weight){
					$data['total_weight'] += $weight->wieght;
				}
				$this->load->view ('admin/register/ajax_broker_live_package',  $data);
			}else if(2 == $usertype || 4 == $usertype){
				$this->load->view ('admin/register/ajax_broker_cart',  $data);
			}else if(5 == $usertype || 7 == $usertype){
                $data['courses_m']=$this->common_model->licensecourselist_m(6);
				$data['mandatory_course_weight']=0.0;
				foreach($data['courses_m'] as $weight){
					$data['mandatory_course_weight'] += $weight['wieght'];
				}
				$data['courses_o']=$this->common_model->licensecourselist_o(6);
				
                /* New Package starts here*/
                $data['courses_new_package_m']=$this->common_model->licensecourselist_m(11);
				$data['mandatory_course_weight_new_package']=0.0;
				foreach($data['courses_new_package_m'] as $weight_new_package){
					$data['mandatory_course_weight_new_package'] += $weight_new_package['wieght'];
				}
                /* New Package ends here*/

                $this->load->view ('admin/register/ajax_sales_package',  $data);
			}else if(6 == $usertype || 8 == $usertype){
			    //$data['coursearr']= $data['courses_m'];
                //$data['courseop']= $data['courses_o'];
				$this->load->view ('admin/register/ajax_sales_cart',  $data);
			}

  		}

  	function get_courses(){
  			$usertype_newpackage = "";
                        $this->load->model('user_model');
			if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '1';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Cart')){
				$usertype= '2';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Package')){
				$usertype= '3';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '4';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '5';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '6';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype")== 'Online') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '7';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '8';
			}else {
				$usertype = '';
			}
			$data['license']	= $this->input->post("licensetype");

			$data['month']=$this->user_model->listmonth();
			$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
			$data['year']=$this->user_model->listyear($currentyear);

                        $this->_reg_session_replace_with_new(array('course_usertype'=>$usertype));
                        
			$this->load->model('common_model');
			$data['courses'] = $this->common_model->getCourses($usertype);
                        /* New Package starts here*/
                        if($usertype == 5) 
                        {
                            $usertype_newpackage = 9;
                        }
                        else
                        {
                            $usertype_newpackage = 10;
                        }
                        $data['courses_newpackage'] = $this->common_model->getCourses($usertype_newpackage);
                        
                        /* New Package ends here*/
                        
			//$data['coursearr']=$this->common_model->listallcourses();

			$data['courses_m']=$this->common_model->licensecourselist_m($usertype);
			$data['courses_o']=$this->common_model->licensecourselist_o($usertype);

		//	$data['subcourses']=$this->Common_model->subcourselist();
			if(1 == $usertype || 3 == $usertype){
				$data['course_weight'] = $this->common_model->getCourseweight();
				$data['total_weight']  = 0.0;
				foreach($data['course_weight'] as $weight){
					$data['total_weight'] += $weight->wieght;
				}
				$this->load->view ('reskin/register/ajax_broker_live_package',  $data);
			}else if(2 == $usertype || 4 == $usertype){

				$this->load->view ('reskin/register/ajax_broker_cart',  $data);
			}else if(5 == $usertype || 7 == $usertype){
				$data['courses_m']=$this->common_model->licensecourselist_m(6);
				$data['mandatory_course_weight']=0.0;
				foreach($data['courses_m'] as $weight){
					$data['mandatory_course_weight'] += $weight['wieght'];
				}
				$data['courses_o']=$this->common_model->licensecourselist_o(6);
                                
                                /* New Package starts here*/
                $data['courses_new_package_m']=$this->common_model->licensecourselist_m(11);
				$data['mandatory_course_weight_new_package']=0.0;
				foreach($data['courses_new_package_m'] as $weight_new_package){
					$data['mandatory_course_weight_new_package'] += $weight_new_package['wieght'];
				}
                                /* New Package ends here*/
                                
				$this->load->view ('reskin/register/ajax_sales_package',  $data);
                                
			}
			else if(6 == $usertype || 8 == $usertype){
				$this->load->view ('reskin/register/ajax_sales_cart',  $data);
				//$this->load->view ('user/userregister/ajax_sales_cart',  $data);
			}
  		}

		function iframe_get_courses(){
                        $usertype_newpackage = "";
  			$this->load->model('user_model');
			if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '1';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Cart')){
				$usertype= '2';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Package')){
				$usertype= '3';
			}else if(($this->input->post("licensetype") == 'B') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '4';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '5';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Live') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '6';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype")== 'Online') && ($this->input->post("paymentype") == 'Package')){
				$usertype = '7';
			}else if(($this->input->post("licensetype") == 'S') && ($this->input->post("coursetype") == 'Online') && ($this->input->post("paymentype") == 'Cart')){
				$usertype = '8';
			}else {
				$usertype = '';
			}
			$data['license']	= $this->input->post("licensetype");

			$data['month']=$this->user_model->listmonth();
			$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
			$data['year']=$this->user_model->listyear($currentyear);

			$this->session->set_userdata (array('course_usertype'=>$usertype));
			$this->load->model('common_model');
			$data['courses'] = $this->common_model->getCourses($usertype);
                        
                        /* New Package starts here*/
                        if($usertype == 5) 
                        {
                            $usertype_newpackage = 9;
                        }
                        else
                        {
                            $usertype_newpackage = 10;
                        }
                        $data['courses_newpackage'] = $this->common_model->getCourses($usertype_newpackage);
                        
                        /* New Package ends here*/
			//$data['coursearr']=$this->common_model->listallcourses();

			$data['courses_m']=$this->common_model->licensecourselist_m($usertype);
			$data['courses_o']=$this->common_model->licensecourselist_o($usertype);

		//	$data['subcourses']=$this->Common_model->subcourselist();
			if(1 == $usertype || 3 == $usertype){
				$data['course_weight'] = $this->common_model->getCourseweight();
				$data['total_weight']  = 0.0;
				foreach($data['course_weight'] as $weight){
					$data['total_weight'] += $weight->wieght;
				}
				$this->load->view ('iframe_user/userregister/ajax_broker_live_package',  $data);
			}else if(2 == $usertype || 4 == $usertype){

				$this->load->view ('iframe_user/userregister/ajax_broker_cart',  $data);
			}else if(5 == $usertype || 7 == $usertype){
				$data['courses_m']=$this->common_model->licensecourselist_m(6);
				$data['mandatory_course_weight']=0.0;
				foreach($data['courses_m'] as $weight){
					$data['mandatory_course_weight'] += $weight['wieght'];
				}
				$data['courses_o']=$this->common_model->licensecourselist_o(6);
                                
                                /* New Package starts here*/
                                $data['courses_new_package_m']=$this->common_model->licensecourselist_m(11);
				$data['mandatory_course_weight_new_package']=0.0;
				foreach($data['courses_new_package_m'] as $weight_new_package){
					$data['mandatory_course_weight_new_package'] += $weight_new_package['wieght'];
				}
                                /* New Package ends here*/
                                
				$this->load->view ('iframe_user/userregister/ajax_sales_package',  $data);
			}
			else if(6 == $usertype || 8 == $usertype){
				$this->load->view ('iframe_user/userregister/ajax_sales_cart',  $data);
			}

   		}

		function iframe_get_ship(){ 

            $this->load->helper('fedex');

            $aryRecipient = array(
                    'Contact' => array(
                            'PersonName' => 'Recipient Name',
                            'CompanyName' => 'Company Name',
                            'PhoneNumber' => $this->input->post("s_phone")
                    ),
                    'Address' => array(
                            'StreetLines' => /*array('Address Line 1')*/ $this->input->post('s_address').", ".$this->session->userdata('unit_number'),
                            'City' => $this->input->post("s_city"),
                            'StateOrProvinceCode' => $this->input->post("s_state"),
                            'PostalCode' => $this->input->post("s_zipcode"),
                            'CountryCode' => $this->input->post("s_country"),
                            'Residential' => false)
            );

            $packageDetails = array(
                                0 => array(
                                    'weight' => $this->input->post("weight"),
                                    'length' => "",
                                    'width' => "",
                                    'height' => ""
                                )
                            );

            $total_packages = count($packageDetails);
            $aryPackage     = getPackage($packageDetails);
            $aryOrder       = get_fedex_order_array($this->input->post("book_count"));
            $ratedetails    = getRate($aryRecipient, $aryOrder, $aryPackage);
           
            //echo number_format($ratedetails['rateReply']->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2);
            $rateService = array();
            $cnt = 0;
            if (!empty($ratedetails['rateReply'])){
                if(IS_FEDEX_ONE_RATE_ENABLED){
                    $rateService[$cnt]['service']   = str_replace('_', ' ', $ratedetails['rateReply']->ServiceType);
                    $rateService[$cnt]['methodno']  = $ratedetails['rateReply']->ServiceType;
                    $rateService[$cnt]['fedexno']   = 1;
                    $rateService[$cnt]['rate']      = $ratedetails['rateReply']->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                }else {

                    foreach ($ratedetails['rateReply'] as $rateReply){

                        $rateService[$cnt]['service']   = str_replace('_', ' ', $rateReply->ServiceType);
                        $rateService[$cnt]['fedexno']   = 1;
                        $rateService[$cnt]['methodno']  = $rateReply->ServiceType;
                        $rateService[$cnt]['rate']      = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;

                        $cnt++;
                        //$rateService[$rateReply->ServiceType]['AMOUNT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                        //$rateService[$rateReply->ServiceType]['UNIT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;
                        //echo $rateReply->ServiceType.' => '.$rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount.'<br/>';
                    }
                }
            }else{
                $rateService['error'] = (isset($ratedetails['error'])) ? $ratedetails['error'] : 'Error occured while fetching shipping rate. Please try later';
            }

            $data['return_value'] = $rateService;
            $this->load->view ('iframe_user/userregister/dsp_show_ship',  $data);
           // $this->load->view ('reskin/register/dsp_show_ship',  $data);
      }

      function _is_promocode_available($license_type, $course_type, $package_type){
          $this->load->model('user_model');
          $promocodes            = $this->user_model->getAllPromocodes();          
          if($promocodes){
              $available = 0;
              foreach ($promocodes as $promocode){
                $apply_to       = json_decode($promocode->apply_to, TRUE);
                if(     $course_type == $apply_to['course_type'] 
                    &&  $package_type == $apply_to['payment_type']
                    &&  ('all' == $apply_to['license_type'] || $license_type == $apply_to['license_type']))
                {
                    $available++;
                    break;
                }
              }
              return $available > 0 ? TRUE : FALSE;
          }else{
              return false;
          }
      }
      
    function apply_promocode(){
        sleep(3);
        $this->load->model('user_model');
        $code               = $this->input->post('code') ? trim($this->input->post('code')) : '';
        $total              = $this->input->post('total');
        $course_type        = $this->input->post('course_type');
        $package_type       = $this->input->post('package_type');
        $license_type       = $this->input->post('license_type');
        if('' == $code){
            $data['msg']    = 'Please enter Promocode';
        }else{
            $details            = $this->user_model->getPromocodeDetails($code);
            $data['status']     = 'error';
            if($details){
                $now_strtotime  = strtotime(date('Y-m-d H:i:s'));
                $apply_to       = json_decode($details->apply_to, TRUE);
                $data['course_type']= $apply_to['course_type'];
                $data['payment_type']= $apply_to['payment_type'];
                if(
                        $course_type != $apply_to['course_type'] 
                    || $package_type != $apply_to['payment_type']
                    || ('all' != $apply_to['license_type'] && $license_type != $apply_to['license_type'])
                ){
                    $data['msg']            = 'Promocode is not applicable';
                }else if($notStarted = strtotime($details->start_at) > $now_strtotime){
                    $data['msg']            = 'This promocode will active on '.convert_UTC_to_PST_datetime($details->start_at);
                }else if($notEnded = $now_strtotime > strtotime($details->end_at)){
                    $data['msg']            = 'Sorry, this promocode is expired';
                }else if(!$notStarted && !$notEnded){
                    $data['status']     = 'success';
                    $data['new_total']  = (1 == $details->redeem_type) ? $total - $details->redeem_value : $total - (($total * $details->redeem_value) / 100);
                    $data['redeem_rate']= (1 == $details->redeem_type) ? '$'.$details->redeem_value : $details->redeem_value.'%';
                }else{
                    $data['msg']            = 'Promocode expired';
                }

            }else{            
                $data['msg']            = 'Invalid Promocode';
            }
        }
        $this->load->view ('dsp_show_ajax',  array('return_value' => json_encode($data)));
    }
    
    function _recheck_promocode(){                    
        if('' != $this->input->post('hid_promocode') && 1 == $this->input->post('is_promocode_applied')){
            $code               = $this->input->post('hid_promocode');
            $course_type        = $this->input->post('hidcoursetype');
            $package_type       = $this->input->post('package_type');
            $license_type       = $this->input->post('hidlicensetype');
            $details            = $this->user_model->getPromocodeDetails($code);
            $error              = '';
            if($details){
                $now_strtotime  = strtotime(date('Y-m-d H:i:s'));
                $apply_to       = json_decode($details->apply_to, TRUE);
                $data['course_type']= $apply_to['course_type'];
                $data['payment_type']= $apply_to['payment_type'];
                if(
                        $course_type != $apply_to['course_type'] 
                    || $package_type != $apply_to['payment_type']
                    || ('all' != $apply_to['license_type'] && $license_type != $apply_to['license_type'])
                ){
                    $error            = 'Promocode is not applicable';
                }else if($notStarted = strtotime($details->start_at) > $now_strtotime){
                    $error            = 'This promocode will active on '.convert_UTC_to_PST_datetime($details->start_at);
                }else if($notEnded = $now_strtotime > strtotime($details->end_at)){
                    $error            = 'Sorry, this promocode is expired';
                }else if(!$notStarted && !$notEnded){
                    $error         = '';                               
                }else{
                    $error         = 'Promocode expired';
                }

            }else{
                $error = 'Invalid promocode applied';
            }

            if('' == $error){
                $proceed = 1;
            }else{
                $proceed = 0;
                $this->gen_contents['errors'] = $error;
            }                        
        }else{
            $proceed = 1;
        }
        return $proceed;

    }
    
    function saveDataInTemp($name,$emailid,$course_name,$course,$usertype,$new_package){
        
        $this->load->model('user_model');
        $this->_temp_init_payment_log($name,$emailid,"GOING_TO",$course_name);
        $this->user_model->temp_paymentlog($this->temp_payment_log);
        $this->_temp_init_user_registration("00000000");
        
        //New package update
        $this->user_contents["sales_new_package"] = $new_package;
        $register_user = 0;
        if($this->input->post('register_user')) {
            $register_user = 1;
        }

        $temp_result = $this->user_model->temp_userregistration($this->user_contents, $register_user);
        
        if($temp_result > 0) {
            $this->order_contents['userid'] = $temp_result;
            $this->order_contents['ship_method']    = str_replace("_"," ",$this->input->post('shipid'));
            $this->order_contents['packaging_type'] = get_fedex_packaging_type(count($course));

            $temp_result1 = $this->user_model->temp_order($this->order_contents);
            $this->order_contents['userid'] = '';
            $this->order_contents['ship_method']    = '';
            $this->order_contents['packaging_type'] = '';

            if($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7){
                    $savecourse = $course;
            }else {
                    $savecourse = $this->input->post('course');
                    if($this->input->post('subcourse')){
                        $subcourseid    = $this->input->post('subcourse');
                    }else{
                        $subcourseid    = '';
                    }
                    if($this->input->post('course_b')){
                        $course_o       = $this->input->post('course_b');
                    }else{
                        $course_o       = '';
                    }
            }
            $this->course_contents  = array(						
                                            "course"        => $savecourse,
                                            "subcourse"     => $subcourseid,
                                            "course_o"      => $course_o,
                                            "userid"        => $temp_result,
                                            "orderid"       => $temp_result1,
                                            "enrolled_date" => $this->order_contents['orderdate']
                                        );

            $this->user_model->temp_usercourse($this->course_contents);
            return $temp_result;
        }
        
        return 0;
        
        /* Update after registration  													
         Update adhi_trial_users after registration 
        $this->load->model('trial_account_model');
        $trial_userid   = 0;
        if($this->authentication->logged_in("trial")){
            $trial_userid   = s('TRIAL_USERID');
        }else if($trial_user = $this->trial_account_model->userExists($this->user_contents['emailid'])){
            $trial_userid   = $trial_user->id;
        }
        if($trial_userid > 0){
            $trial_data = array(
                                'status'        => 2,
                                'reg_user_id'   => $result,
                                'updated_at'    => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                            );
            $this->trial_account_model->update($trial_userid, $trial_data);
            $this->authentication->logout();
        }

        /*
         * Disabing forum                                 
            $this->_user_forum_data($data['payment']["TRANSACTIONID"]);                                
            $result_forum=$this->user_model->adduser_forum($this->user_forum_contents);
            if($result > 0 || $result_forum > 0) {
        */                            
        /*****/
        
    }
    
    function _temp_init_payment_log($name,$emailid,$status,$course_name){
        $this->temp_payment_log = array(
            "name"          => 	$name,						
            "emailid"       => $emailid,
            "paymentdate"   => convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
            "b_address"     => $this->regdata['b_address'].",".$this->regdata['b_city'].
                                                                    ",".$this->session->userdata('b_state').",".$this->regdata['b_country'].",".$this->regdata['b_zipcode'],

            "s_address" 	=> $this->regdata['s_address'].",".$this->regdata['s_city'].
                                                                    ",".$this->regdata['s_state'].",".$this->regdata['s_country'].",".$this->regdata['s_zipcode'],
            "coursename" 	=> $course_name,
            "status" 	=> $status
        );
    }
    
    function _temp_init_user_registration($transactionid){
        $this->user_contents    = array(		
                                        "firstname"             => 	$this->regdata['firstname'],
                                        "lastname"              => 	$this->regdata['lastname'],
                                        "name_on_certificate"   =>      $this->regdata['name_on_certificate'],
                                        //"forum_alias"           => 	$this->regdata['forum_alias'],//Disabling forum
                                        "emailid"               => 	$this->regdata['emailid'],
                                        "password"              => 	$this->regdata['password'],							
                                        "address"               => 	$this->regdata['s_address'],
                                        "state"                 => 	$this->regdata['s_state'],
                                        "city"                  => 	$this->regdata['s_city'],
                                        "zipcode"               => 	$this->regdata['s_zipcode'],
                                        "country"               => 	$this->regdata['s_country'],
                                        "phone"                 => 	$this->regdata['phone'],
                                        "driving_license"       => 	$this->regdata['driving_license'],
                                        "note"                  =>      $this->regdata['note'],    
                                        "testimonial"           => 	$this->regdata['testimonial'],	
                                        "reason"                =>	$this->regdata['reason'],
                                        "licensetype"           => 	$this->regdata['licensetype'],
                                        "b_address"             => 	$this->regdata['b_address'],
                                        "b_country"             => 	$this->regdata['b_country'],
                                        "b_state"               => 	$this->regdata['b_state'],
                                        "b_city"                => 	$this->regdata['b_city'],
                                        "billing_sameas_shipping" 	=> 	$this->regdata['billing_sameas_shipping'],
                                        "b_zipcode"             => 	$this->regdata['b_zipcode'],
                                        "s_address"             => 	$this->regdata['s_address'],
                                        "s_country"             =>	$this->regdata['s_country'],
                                        "s_state"               => 	$this->regdata['s_state'],
                                        "s_city"                => 	$this->regdata['s_city'],
                                        "s_zipcode"             => 	$this->regdata['s_zipcode'],
                                        "course_user_type"      =>  $this->regdata['course_usertype'],
                                        "unit_number"           =>  $this->regdata['unit_number'],
                                    );


            $this->order_contents =array(
                                            "b_address"     => $this->regdata['b_address'],
                                            "b_country" 	=> $this->regdata['b_country'],
                                            "b_state" 	=> $this->regdata['b_state'],
                                            "b_city" 	=> $this->regdata['b_city'],
                                            "b_zipcode" 	=> $this->regdata['b_zipcode'],
                                            "s_address" 	=> $this->regdata['s_address'],
                                            "s_country" 	=> $this->regdata['s_country'],
                                            "s_state" 	=> $this->regdata['s_state'],
                                            "s_city"	=> $this->regdata['s_city'],
                                            "s_zipcode" 	=> $this->regdata['s_zipcode'],
                                            "total_amount"	=> $this->input->post('totalprice'),
                                            "ship_rate" 	=> $this->input->post('shipprice'),
                                            "course_price" 	=> (float) $this->input->post('totalprice') - (float) $this->input->post('shipprice'),//$this->input->post('price'),
                                            "transactionid"	=> $transactionid,
                                            "payment_method"=> 'Paypal Payment Method',
                                            "orderdate" 	=> convert_UTC_to_PST_date(date('Y-m-d H:i:s')),                                                        
                                            );
            if($this->input->post('is_promocode_applied') == 1){
                $this->order_contents['is_promocode_applied']   = 1;
                $promocode      = $this->input->post('hid_promocode');
                $detail         = $this->user_model->getPromocodeDetails($promocode);
                $this->order_contents['promocode_details']      = json_encode(array(
                    'promocode'                     => $promocode,
                    'promocode_id'                  => $detail->id,
                    'redeem_type'                   => $detail->redeem_type,
                    'redeem_value'                  => $detail->redeem_value,
                    'grand_total_before_promocode'  => $this->input->post('grand_total_before_promocode'),
                    'grand_total_after_promocode'   => $this->input->post('grand_total_after_promocode')
                ));
            }

    }
 }
 
?>