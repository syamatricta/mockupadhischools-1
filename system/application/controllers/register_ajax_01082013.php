<?php

class Register_ajax extends Controller {

		function Register_ajax(){
			parent::Controller();			
			$this->load->helper("form");
			$this->load->helper('url');
			
		}
	
		
                
                
	       function get_ship(){
                    
                    $this->load->helper('fedex');
                    
                    $aryRecipient = array(
                            'Contact' => array(
                                    'PersonName' => 'Recipient Name',
                                    'CompanyName' => 'Company Name',
                                    'PhoneNumber' => $this->input->post("s_phone")
                            ),
                            'Address' => array(
                                    'StreetLines' => array('Address Line 1'),
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
                    $aryPackage = getPackage($packageDetails);

                    $aryOrder = array(
                                    'TotalPackages' => $total_packages,
                                    'PackageType' => 'YOUR_PACKAGING',        #FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                                    'ServiceType' => 'INTERNATIONAL_PRIORITY',
                                    'TermsOfSaleType' => "DDU",         #    DDU/DDP
                                    'DropoffType' => 'REGULAR_PICKUP'         # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                            );
                    $ratedetails = getRate($aryRecipient, $aryOrder, $aryPackage);
                  //  print_r($ratedetails); die();
                      
                    //echo number_format($ratedetails['rateReply']->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2);
                    $rateService = array();
                    $cnt = 0;
                    if (!empty($ratedetails['rateReply'])){
                        foreach ($ratedetails['rateReply'] as $rateReply){

                            $rateService[$cnt]['service'] = str_replace('_', ' ', $rateReply->ServiceType);
                            $rateService[$cnt]['fedexno'] = 1;
                            $rateService[$cnt]['methodno'] = $rateReply->ServiceType;
                            $rateService[$cnt]['rate'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;

                            $cnt++;
                            //$rateService[$rateReply->ServiceType]['AMOUNT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                            //$rateService[$rateReply->ServiceType]['UNIT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;
                            //echo $rateReply->ServiceType.' => '.$rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount.'<br/>';                
                        }
                    }
                    
                    $data['return_value'] = $rateService;
                    $this->load->view ('dsp_show_ship.php',  $data);
                    
                }	
                
                
                
        function get_ship_old()
        {
            $this->load->model ('user_model');
			$data['admindetails'] = $this->user_model->get_admin();	
           /* $from               = $this->input->post("from");
            if(isset($from) && !empty($from))
                $captcha        = $this->common_model->generate_captcha ("",$from);
            else*/
			$data['b_address'] = $this->input->post("s_address");
			$data['b_city'] = $this->input->post("s_city");
			$data['b_phone'] = $this->input->post("s_phone");
			$data['b_state'] = $this->input->post("s_state");
			$data['b_country'] = $this->input->post("s_country");
			$data['b_zipcode'] = $this->input->post("s_zipcode");
			$data['weight'] = $this->input->post("weight");
			
			$shiprate=$this->user_model->servicesrate($data);
			
			$data['return_value']	=   $shiprate;
			
          //  $captcha        = $this->user_model->get_ship ();
			//$data['return_value']	=   $captcha['image'];
			$this->load->view ('dsp_show_ship',  $data);
  
  	}
  		
  		
  		function admin_get_courses(){
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
				$this->load->view ('admin/register/ajax_sales_package',  $data);
			}	
			else if(6 == $usertype || 8 == $usertype){
                           // $data['coursearr']= $data['courses_m'];
                             //$data['courseop']= $data['courses_o'];
				$this->load->view ('admin/register/ajax_sales_cart',  $data);
			}
                        
  		}
  		
  	function get_courses(){
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
				$this->load->view ('user/userregister/ajax_broker_live_package',  $data);
			}else if(2 == $usertype || 4 == $usertype){
				
				$this->load->view ('user/userregister/ajax_broker_cart',  $data);
			}else if(5 == $usertype || 7 == $usertype){
				$data['courses_m']=$this->common_model->licensecourselist_m(6);
				$data['mandatory_course_weight']=0.0;
				foreach($data['courses_m'] as $weight){
					$data['mandatory_course_weight'] += $weight['wieght'];
				}
				$data['courses_o']=$this->common_model->licensecourselist_o(6);
				$this->load->view ('user/userregister/ajax_sales_package',  $data);
			}	
			else if(6 == $usertype || 8 == $usertype){
				$this->load->view ('user/userregister/ajax_sales_cart',  $data);
			}			
  		}

		function iframe_get_courses(){
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
                            'StreetLines' => array('Address Line 1'),
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
            $aryPackage = getPackage($packageDetails);

            $aryOrder = array(
                            'TotalPackages' => $total_packages,
                            'PackageType' => 'YOUR_PACKAGING',        #FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                            'ServiceType' => 'INTERNATIONAL_PRIORITY',
                            'TermsOfSaleType' => "DDU",         #    DDU/DDP
                            'DropoffType' => 'REGULAR_PICKUP'         # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                    );
            $ratedetails = getRate($aryRecipient, $aryOrder, $aryPackage);
          //  print_r($ratedetails); die();
              
            //echo number_format($ratedetails['rateReply']->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2);
            $rateService = array();
            $cnt = 0;
            if (!empty($ratedetails['rateReply'])){
                foreach ($ratedetails['rateReply'] as $rateReply){

                    $rateService[$cnt]['service'] = str_replace('_', ' ', $rateReply->ServiceType);
                    $rateService[$cnt]['fedexno'] = 1;
                    $rateService[$cnt]['methodno'] = $rateReply->ServiceType;
                    $rateService[$cnt]['rate'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;

                    $cnt++;
                    //$rateService[$rateReply->ServiceType]['AMOUNT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                    //$rateService[$rateReply->ServiceType]['UNIT'] = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Currency;
                    //echo $rateReply->ServiceType.' => '.$rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount.'<br/>';                
                }
            }
            
            $data['return_value'] = $rateService;
            $this->load->view ('iframe_user/userregister/dsp_show_ship',  $data);
      }
		
 }
?>
