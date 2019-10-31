<?php
if('development' == ENVIRONMENT){
    //Google analytics - api details
    $config['ga_profile_id']            = '85101887';//11533762';
    $config['ga_tracking_id']           = 'UA-5713717-1';
    $config['ga_hostname_filter']       = 'mockup.adhischools.com';
    
    $config['ga_application_name']      = 'AdhiSchoolsReskin';
    $config['ga_key_file']              = 'AdhiSchoolsReskin-f67cb30ba331.p12';
    $config['ga_service_account_email'] = 'test-313@adhischoolsreskin-1314.iam.gserviceaccount.com';
    
    $config['cco_url']                  = "http://192.168.0.107/crashcourseonline/trunk/";

    $config['main_cc_to']               = 'jomon@farming.cards';
    $config['main_bcc_to']              =  '';
    
    /* Email bcc to emails while guest registration */
    $config['guest_account_email_bcc']  = 'jomon@farming.cards';
    
    /* Bcc to emails while career seminar confirmation */
    $config['career_seminar_email_bcc']  = 'jomon@farming.cards';

    // To avoid OTP for admin Usernames 
    $config['otp_excluded_usernames']   = array('rahul');

    $config['guest_pass_enquiry']       = 'jomon@farming.cards';
    $config['cc_mails']                 = 'jomon@farming.cards';

    $config['java_path']			    = '/usr/bin/java';

    $config['wsdl_folder']			    = 'wsdl-test/';

    $config['BRE_user_ids']            = array(69);//user ids from db
    $config['BRE_user_license_number'] = array(69 => 'ABC123');//for testing Govt officials
    $config['BRE_user_password']       = array(69 => 'rain123');//for testing Govt officials

    $config['course_contact_to']        = 'jomon@farming.cards';

    $config['course_except_exam_users'] = array();

    $config['disable_classroom_for_users']  = array();
    $config['disable_supplement_for_users'] = array();
	$config['disable_quiz_for_users']       = array();

    $config['student_test_accounts']    = array();
    $config['regulator_test_accounts']  = array();
    
}else if('staging' == ENVIRONMENT){
    //Google analytics - api details
    $config['ga_profile_id']            = '85101887';//11533762';
    $config['ga_tracking_id']           = 'UA-5713717-1';
    $config['ga_hostname_filter']       = 'mockup.adhischools.com';
    
    $config['ga_application_name']      = 'AdhiSchoolsReskin';
    $config['ga_key_file']              = 'AdhiSchoolsReskin-f67cb30ba331.p12';
    $config['ga_service_account_email'] = 'test-313@adhischoolsreskin-1314.iam.gserviceaccount.com';
    
    $config['cco_url']                  = "https://qa.crashcourseonline.com/";

    /*$config['main_cc_to']               = 'rahul@rainconcert.in';
    $config['main_bcc_to']              =  '';*/

    $config['main_cc_to']               = 'jomon@farming.cards';
    $config['main_bcc_to']              = 'jomon@farming.cards';
    
    /* Email bcc to emails while guest registration */
    /*$config['guest_account_email_bcc']  = 'rahul@rainconcert.in';*/
    $config['guest_account_email_bcc']  = 'jomon@farming.cards';
    
    /* Bcc to emails while career seminar confirmation */
    /*$config['career_seminar_email_bcc']  = 'rahul@rainconcert.in';*/
    $config['career_seminar_email_bcc']  = 'jomon@farming.cards';

    // To avoid OTP for admin Usernames 
    $config['otp_excluded_usernames']   = array('syam');

    /*$config['guest_pass_enquiry']       = 'rahul@rainconcert.in';
    $config['cc_mails']                 = 'rahul@rainconcert.in';*/

    $config['guest_pass_enquiry']       = 'jomon@farming.cards';
    $config['cc_mails']                 = 'jomon@farming.cards';

    $config['java_path']			    = '/opt/jdk1.8.0_144/bin/java';

    $config['wsdl_folder']			    = 'wsdl-test/';

    $config['BRE_user_ids']            = array(7044);//user ids from db
    $config['BRE_user_license_number'] = array(7044 => 'C12345');//for testing Govt officials
    $config['BRE_user_password']       = array(7044 => 'bretest1');//for testing Govt officials

    $config['course_contact_to']        = 'jomon@farming.cards';
	
    $config['course_except_exam_users'] = array();

    $config['disable_classroom_for_users']  = array();
    $config['disable_supplement_for_users'] = array();	
	$config['disable_quiz_for_users']       = array(10137, 10136);
	
    $config['student_test_accounts']    = array();
    $config['regulator_test_accounts']  = array();
          
}else if('production' == ENVIRONMENT){
    //Google analytics - api details
    $config['ga_profile_id']            = '11533762';
    $config['ga_tracking_id']           = 'UA-5713717-1';
    $config['ga_hostname_filter']       = 'www.adhischools.com';
    
    $config['ga_application_name']      = 'AdhiSchools';
    $config['ga_key_file']              = 'API Project-91a9ceff5ecf.p12';
    $config['ga_service_account_email'] = 'adhi-admin-panel@api-project-940764332599.adhischools.com.iam.gserviceaccount.com';
    
    $config['cco_url']                  = "http://www.crashcourseonline.com/";

    $config['main_cc_to']               = 'jomon@farming.cards';//'kartik@adhischools.com';
    $config['main_bcc_to']              = 'jomon@farming.cards';//'students@adhischools.com';
    
    /* Email bcc to emails while guest registration */
    $config['guest_account_email_bcc']  = 'jomon@farming.cards';//'sophia@adhischools.com,crystal@adhischools.com';
    
    /* Bcc to emails while career seminar confirmation */
    $config['career_seminar_email_bcc']  = 'jomon@farming.cards';//'laycee@adhischools.com,sophia@adhischools.com,crystal@adhischools.com';

    // To avoid OTP for admin Usernames 
    $config['otp_excluded_usernames']   = array('rainconcert');

    $config['guest_pass_enquiry']       = 'jomon@farming.cards';//'kartik@adhischools.com , crystal@adhischools.com , sophia@adhischools.com';
    $config['cc_mails']                 = 'jomon@farming.cards';//'crystal@adhischools.com , sophia@adhischools.com';

    $config['java_path']			    = '/usr/java/jdk1.7.0_75/bin/java';

    $config['wsdl_folder']			    = 'wsdl/';

    $config['BRE_user_ids']             = array(9743);//user ids from db
    $config['BRE_user_license_number']  = array(9743 => 'C12345');//for testing Govt officials
    $config['BRE_user_password']        = array(9743 => 'bretest1');//for testing Govt officials

    $config['course_contact_to']        = 'jomon@farming.cards';//'kartik@adhischools.com , crystal@adhischools.com , sophia@adhischools.com, students@adhischools.com';
	
	$config['course_except_exam_users'] = array(10124, 10125, 10126, 10127, 10134);

    $config['disable_classroom_for_users']  = array(10137, 10136);
    $config['disable_supplement_for_users'] = array(10137);
    $config['disable_quiz_for_users']       = array(10137, 10136);

    $config['student_test_accounts']    = array(10136);
    $config['regulator_test_accounts']  = array(10137);
}

?>
