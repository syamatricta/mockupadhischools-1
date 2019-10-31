<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		soumya
 * @link		http://ahischools.com/user/
 */

// ------------------------------------------------------------------------

class Trial_account extends Controller 
{
	var $gen_contents   = array();
	var $message        = array();
	
        
	/**
	 * init function
	 * Enter description here ...
	 */
	function Trial_account(){
            //error_reporting(E_ALL);
            //ini_set('dispaly_errors',1);
            parent::Controller();

            $this->load->model('Common_model');       
            $this->load->model(array('user_model', 'trial_account_model', 'admin_trial_account_model')); 
            $this->load->library("form_validation");
            
            $this->gen_contents['css'] = array();
            $this->gen_contents['js'] = array();
	}
	
	/**
	 * incex function
	 * Enter description here ...
	 * @access public
	 * @param void
	 * @return void
	 */
	function index() {
            if($this->authentication->logged_in("normal")){
                redirect("profile");
            }else if($this->authentication->logged_in("trial")){
                redirect("trial_account/profile");
            }else{
                redirect("trial_account/register");
            }
            
	}
        
        
        /**
         * Function User registration
         * @param type $step_back
         */        
        function register() {
            if($this->authentication->logged_in("normal")){
                redirect("profile");
            }else if($this->authentication->logged_in("trial")){
                redirect("trial_account/profile");
            }
            $this->load->library("form_validation");
            $this->template->set_template('user');
            $this->template->write_view('content', 'reskin/trial/register', $this->gen_contents);
            $this->template->render();
        }
        
        /*
         * Trail user registration submission
         */
        function ajax_register() {
            
            $this->gen_contents['errors']   = '';
            $this->gen_contents['proceed']  = 0;
            $this->form_validation->set_rules('firstname', 'FIRST NAME', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('lastname', 'LAST NAME', 'trim|required|max_length[128]');
            $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('confirm_email', 'CONFIRM EMAIL', 'trim|required');
            $this->form_validation->set_rules('psword', 'PASSWORD', 'required');
            $this->form_validation->set_rules('psword1', 'CONFIRM PASSWORD', 'required');                    
            $this->form_validation->set_rules('phone', 'PHONE NO', 'trim|required');
            $this->form_validation->set_rules('terms', 'Terms and Conditions', 'trim|required');
            if($this->form_validation->run() == TRUE) {
                $check_in_trial = $this->trial_account_model->userExists($this->input->post('email'));
                $check_in_user  = $this->user_model->checkuser($this->input->post('email'));
                if($check_in_trial){
                    if(0 == $check_in_trial->status){
                        $this->gen_contents['errors']   = 'You are already registered as Guest User. Please check your inbox to verify the email.';
                    }else if(1 == $check_in_trial->status){
                        $this->gen_contents['errors']   = 'You already have a Guest account. <a class="login-popup" href="#">Please Login</a>';
                    }else if(2 == $check_in_trial->status){
                        $this->gen_contents['errors']   = 'You already have an account in Adhischools. <a class="login-popup" href="#">Please Login</a>';
                    }
                }
                if($check_in_user){
                    $this->gen_contents['errors']   = 'You have already registered as AdhiSchools User. <a class="login-popup" href="#">Please Login</a>';
                }
                if('' == $this->gen_contents['errors']){
                    
                    $activation_code    = md5(uniqid(rand(), true));
                    while($this->trial_account_model->activationCodeExists($activation_code)){
                        $activation_code    = md5(uniqid(rand(), true));
                    }
                    
                    /* Registration in process save mail starts */
                    $save_data = array(
                        'first_name'        => $this->Common_model->safe_html($this->input->post('firstname')),
                        'last_name'         => $this->Common_model->safe_html($this->input->post('lastname')),
                        'email'             => $this->Common_model->safe_html($this->input->post('email')),
                        'phone'             => $this->Common_model->safe_html($this->input->post('phone')),
                        'ip_address'        => $this->input->ip_address(),
                        'password'          => md5($this->Common_model->safe_html($this->input->post('psword'))),
                        'created_at'        => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                        'activation_code_sent_at'        => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                        'status'            => 0,
                        'activation_code'   => $activation_code
                    );
                    
                    if($this->trial_account_model->save($save_data)){
                        $settings                   = $this->admin_trial_account_model->getSettings();
                        $trail_activation_link  = base_url().'trial_account/activation/'.$activation_code;
                        $mail_data  = array(
                                            'firstname'             => $save_data['first_name'], 
                                            'trail_activation_link' => '<a href="'.$trail_activation_link.'">'.$trail_activation_link.'</a>',
                                            'trial_validity_days'   => $settings->validity_days
                                        );
                        $sendmail   = $this->trial_account_model->email_trial_user($this->input->post('email'), $mail_data, 'Welcome to your guest account with ADHI Schools');
                        
                        $this->gen_contents['proceed']      = 1;
                        $this->gen_contents['page_view']    = $this->load->view('reskin/trial/_reg_success', '', TRUE);
                    }else{
                        $this->gen_contents['proceed']      = 'Failed to register as Trial User, please try later.';
                    }
                }
            }else{
                $this->gen_contents['errors']   = validation_errors();
            }
            
            $data['return_value']   = json_encode($this->gen_contents);
            $this->load->view ('dsp_show_ajax',  $data);
        }
	
        function activation(){
            if($this->authentication->logged_in("normal")){
                redirect("home");
            }else if($this->authentication->logged_in("trial")){
                redirect("home");
            }
            $activation_code    = $this->uri->segment(3);
            if('' != $activation_code){
                $user = $this->trial_account_model->activationCodeExists($activation_code);
                if($user){
                    if($adhi_user = $this->trial_account_model->getAdhiUserByEmail($user->email)){
                        $this->message['info'] = 'You already have an account in Adhischools, please <a class="login-popup" href="#">Login</a>';
                        $save_data = array(
                                'activation_code'   => '',
                                'status'            => 2
                        );
                        $this->trial_account_model->update($user->id, $save_data);
                    }else{
                        $today  = strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
                        $check  = strtotime($user->activation_code_sent_at.' +'. $this->config->item('trial_account_activation_email_expiry'));//already saved in PST
                        if($today <= $check){
                            $settings                   = $this->admin_trial_account_model->getSettings();
                            $save_data = array(
                                'activated_at'      => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                'activation_code'   => '',
                                'status'            => 1,
                                'will_expire_at'    => convert_UTC_to_PST_datetime(strtotime(time()).' +'. $settings->validity_days .' days'),
                                
                            );
                            if($settings->validity_days > 1){
                                $maketing_day   = floor($settings->validity_days/2);
                                $save_data['marketing_email_at'] = convert_UTC_to_PST_datetime(strtotime(time()).' +'. $maketing_day .' days');
                            }
                            if($this->trial_account_model->update($user->id, $save_data)){
                                $mail_data  = array('firstname' => $user->first_name);
                                $sendmail   = $this->trial_account_model->email_trial_user($user->email, $mail_data, 'Guest account activated', 'activated');
                            }
                            $this->message['success'] = 'Your Guest account has been activated, please <a class="login-popup" href="#">Login</a>';
                        }else{
                            $this->message['info'] = 'Activation link is expired, please <a href="'.  base_url().'trial_account/resend_activation/'.$activation_code.'">resend activation link</a>';
                        }
                    }
                    
                }else{
                    $this->message['error'] = 'Invalid request';
                }
                $this->template->set_template('user');
                $this->template->write_view('content', 'reskin/trial/activation', $this->gen_contents);
                $this->template->render();
            }
        }
		
        function resend_activation(){
            if($this->authentication->logged_in("normal")){
                redirect("home");
            }else if($this->authentication->logged_in("trial")){
                redirect("home");
            }
            $activation_code    = $this->uri->segment(3);
            if('' != $activation_code){
                $user = $this->trial_account_model->activationCodeExists($activation_code);
                if($user){
                    if(0 == $user->status){
                        $activation_code    = md5(uniqid(rand(), true));
                        while($this->trial_account_model->activationCodeExists($activation_code)){
                            $activation_code    = md5(uniqid(rand(), true));
                        }

                        $save_data = array(
                            'activation_code_sent_at'   => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                            'activation_code'           => $activation_code
                        );
                        
                        $trail_activation_link  = base_url().'trial_account/activation/'.$activation_code;
                        $mail_data  = array('firstname' => $user->first_name, 'trail_activation_link' => '<a href="'.$trail_activation_link.'">'.$trail_activation_link.'</a>');
                        $sendmail   = $this->trial_account_model->email_trial_user($user->email, $mail_data, 'New Activation link', 'resend');
                        
                        if($sendmail){
                            if($this->trial_account_model->update($user->id, $save_data)){
                                $this->message['success']   = 'Please check your inbox for new activation link.';
                            }else{
                                $this->message['error']   = 'Failed to resend activation link.';
                            }
                        }else{
                            $this->message['error']   = 'Failed to resend activation link, email error. Please try later.';
                        }
                    }else{
                        $this->message['error']   = 'You account is already activated. <a class="login-popup" href="#">Please Login</a>';
                    }
                }else{
                    $this->message['error'] = 'Invalid request';
                }
                $this->template->set_template('user');
                $this->template->write_view('content', 'reskin/trial/activation', $this->gen_contents);
                $this->template->render();
            }
        }
        
        function profile(){
            if(!$this->authentication->logged_in("trial")){
                redirect("home");
            }
            /* It will check the trial period expiration and will show proper message and redirection */
            trial_period_checking();
            
            $this->load->model('admin_trial_account_model');
            $settings                   = $this->admin_trial_account_model->getSettings();
            
            $this->gen_contents['selected_nav'] = 'profile'; 
            $this->gen_contents['user'] = $this->trial_account_model->getUser(s('TRIAL_USERID'));
            $this->gen_contents['expire_within'] = expires_within($settings->validity_days, $this->gen_contents['user']->activated_at);
            $this->template->set_template('user');
            $this->template->write_view('content', 'reskin/trial/profile', $this->gen_contents);
            $this->template->render();
        }
        
        function classroom(){
            if(!$this->authentication->logged_in("trial")){
                redirect('/home');
            }
            /* It will check the trial period expiration and will show proper message and redirection */
            trial_period_checking();
            
            $this->gen_contents['selected_nav']	=   'classroom';
            $this->load->model('admin_trial_account_model');
            $settings                   = $this->admin_trial_account_model->getSettings();
            $quiz_details               = $this->admin_trial_account_model->getQuizDetails($settings->quiz_list_id);
            
            $this->gen_contents['video']        = (object) array('video' => $quiz_details->video, 'desc' => $quiz_details->video_desc);
            $this->gen_contents['chapter_title']= $quiz_details->course_name;
            
            //$this->_template('view', $this->gen_contents);
            $this->template->set_template('user');
            $this->template->write_view('content', 'reskin/trial/classroom/view', $this->gen_contents);
            $this->template->render();
        }
        
        function expired(){
            if(!$this->session->userdata('TRIAL_EXPIRED')){
                redirect('/home');
            }else{
                $user_id        = $this->session->userdata('EXPIRED_TRIAL_ID');
                $user           = $this->trial_account_model->getUser($user_id);
                if(2 == $user->status){
                    $session_data 	= array (
                                                'TRIAL_EXPIRED'     => '',
                                                'EXPIRED_TRIAL_ID'  => '',
                                                'EXP_USER_NAME'     => '',
                                                'EXP_LAST_NAME'     => '',
                                                'EXP_EMAIL'         => '',
                                                'EXP_PHONE'         => ''
                                        );
                    $this->session->unset_userdata($session_data);
                    redirect('/home');
                }
            }
            $this->template->set_template('user');
            $this->template->write_view('content', 'reskin/trial/expired', $this->gen_contents);
            $this->template->render();
        }
        
        /* Cron job for trial period expiration email 1 before expiry */
        function expiration_reminder(){
            $users      = $this->trial_account_model->getUsersToExpire();
            $emails     = array();
            $users_ids  = array();
            if($users){
                foreach($users as $user){
                    array_push($emails, $user->email);
                    array_push($users_ids, $user->id);
                    $this->trial_account_model->email_trial_user($user->email, array('firstname' => $user->first_name), 'Guest account expiration', 'expiration');
                }
                //Update mail sent information on Trial users table
                $save_data  = array('reminder_sent' => 1);
                $this->trial_account_model->update($users_ids, $save_data);
            }
            echo 'Total reminder email sent = '.count($emails).'<br/>';
            echo (count($emails) > 0) ? implode(', ', $emails) : '';
        }
        
        /* Cron job for set trial account expired */
        function set_expired(){
            $result = $this->trial_account_model->updateTrialUserExpire();
            echo $result;
        }
        
        /* Cron job for trial period expiration email 1 before expiry */
        function maketing_email(){
            $users      = $this->trial_account_model->getUsersToMarketingEmail();
            $emails     = array();
            $users_ids = array();
            if($users){
                foreach($users as $user){
                    array_push($emails, $user->email);
                    array_push($users_ids, $user->id);
                    $this->trial_account_model->email_trial_user($user->email, array('firstname' => $user->first_name), 'Adhischools.LLC', 'marketing_email');
                }
                $save_data  = array('marketing_email_sent' => 1);
                $this->trial_account_model->update($users_ids, $save_data);
            }
            echo 'Total marketing email sent = '.count($emails);
            echo (count($emails) > 0) ? implode(', ', $emails) : '';
        }
        
        function upgrade(){
            if(!$this->session->userdata('TRIAL_EXPIRED')){
                redirect('/home');
            }else{
                $user_id        = $this->session->userdata('EXPIRED_TRIAL_ID');
                $user           = $this->trial_account_model->getUser($user_id);
                if(2 == $user->status){
                    $session_data 	= array (
                                                'TRIAL_EXPIRED'     => '',
                                                'EXPIRED_TRIAL_ID'  => '',
                                                'EXP_USER_NAME'     => '',
                                                'EXP_LAST_NAME'     => '',
                                                'EXP_EMAIL'         => '',
                                                'EXP_PHONE'         => ''
                                        );
                    $this->session->unset_userdata($session_data);
                    loginto_continue_msg('You already have an account in Adhischools', '/home');
                }else {
                    $session_data 	= array (
                                                'EXP_USER_NAME' => $user->first_name,
                                                'EXP_LAST_NAME' => $user->last_name,
                                                'EXP_EMAIL'     => $user->email,
                                                'EXP_PHONE'     => $user->phone
                                        );
                    $this->session->set_userdata($session_data);
                    redirect('user/register');
                }
            }
        }
}
