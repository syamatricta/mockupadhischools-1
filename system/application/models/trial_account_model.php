<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * Handles admin exam functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------


class Trial_account_model extends Model {
	
	function Trial_account_model() {
            parent::Model ();	
            //$this->output->enable_profiler();
	}
        
        function userExists($email, $other_than_user_id = ''){
            $this->db->where('email' ,  $email);
            if('' != $other_than_user_id){
                $this->db->where('id<>' ,  $other_than_user_id, FALSE);
            }
            $result = $this->db->get('adhi_trial_users');
            return $result->row();
        }
                
        function activationCodeExists($code){
            $this->db->where('activation_code' ,  $code);
            $result = $this->db->get('adhi_trial_users');
            return $result->row();
        }
        
        function save($data){
            $this->db->insert('adhi_trial_users', $data);
            return $this->db->insert_id();
	}
        function email_trial_user($to, $data, $subject, $type = 'register'){
            $bcc_emails         = '';
            $contents		= 'Dear '.$data['firstname'].',<br/><br/> ';
            $admin_bcc          = '';
            if('resend' == $type){
                $contents       .= ' Here is your new activation link. <br/>'
                                    .$data['trail_activation_link'].'<br/>';
            }else if('register' == $type){                
                $contents       .= '<p>Thank you for creating your guest account with ADHI Schools!  We welcome you to take our 
                                    program for a test drive and see if you like it.  If you do, you can upgrade your guest account by 
                                    clicking the link inside your profile.</p>

                                    <p>As a guest you have access to one of our chapter videos for Real Estate Principles as well as 
                                    the quiz that goes with it.  We are constantly recording new videos so check back often for new 
                                    content!</p>

                                    <p>You can also follow us on Facebook, Instagram, Twitter and YouTube. Search for ADHI Schools 
                                    and stay in touch.</p>

                                    <p>Your guest account is valid for '.$data['trial_validity_days'].' days.  This should be plenty of time to understand how our 
                                    program works and if it is right for you.</p>

                                    <p>Click on the link below to activate your account<br/>
                                    '.$data['trail_activation_link'].'</p>

                                    <p>We look forward to having you as our newest student!</p>';
                $admin_bcc          = 'yes';
                $bcc_emails         = c('guest_account_email_bcc');
            }else if('activated' == $type){
                $contents       .= ' Your Guest account has been activated, Now you can <a href="'.base_url().'user/login">login</a> to your account. <br/>';
                $bcc_emails         = c('guest_account_email_bcc');
            }else if('expiration' == $type){
                $contents       .= '<p>You only have one day left on your Guest account with ADHI Schools and it looks like you haven’t registered.
                                    We would love to help you get your real estate license. <a href="'.base_url().'user/register">Click</a> to upgrade your account.</p>
                                        
                                    <p>Hear from one of our students who started just like you and is now a top producing agent and President of the Arcadia Association of Realtors!</p>
                                    <p><a href="http://www.youtube.com/watch?v=X1YPrNeD5I0&feature=em-share_video_user"
                                        style="text-decoration:none;display:block" 
                                        target="_self"
                                        class="nonplayable"><img src="http://i1.ytimg.com/vi/X1YPrNeD5I0/mqdefault.jpg" width="320"/>
                                    </p>
                                    <p>After tomorrow your guest login will no longer work and we will be sad to see you go.</p>';
            }else if('marketing_email' == $type){
                $contents       .= '<p>It’s been a couple of days since you set up your guest account with us.  Have you had a chance to look at the chapter video as yet or try the quiz?</p>
                                    <p>We would love to have you as our newest student and get textbooks to your door!  <a href="'.base_url().'user/register">Click here</a> to register and complete your enrollment.</p>
                                    <p>Once you get your license you’ll have to pick a broker to work for.  Here are some tips from our Founder to make sure you end up at a good firm once you have your license</p>
                                    <p>
                                        <a href="http://www.youtube.com/watch?v=BZrGmBrZ1oU&feature=em-share_video_user"
                                        style="text-decoration:none;display:block" 
                                        target="_self"
                                        class="nonplayable"><img src="http://i1.ytimg.com/vi/BZrGmBrZ1oU/mqdefault.jpg" width="320"/></a>
                                    </p>
                                    ';
                
                
            }else if('created_by_admin' == $type){
                $contents       .= '<p>Thank you for creating your guest account with ADHI Schools!  We welcome you to take our 
                                    program for a test drive and see if you like it.  If you do, you can upgrade your guest account by 
                                    clicking the link inside your profile.</p>

                                    <p>As a guest you have access to one of our chapter videos for Real Estate Principles as well as 
                                    the quiz that goes with it.  We are constantly recording new videos so check back often for new 
                                    content!</p>

                                    <p>You can also follow us on Facebook, Instagram, Twitter and YouTube. Search for ADHI Schools 
                                    and stay in touch.</p>

                                    <p>Your guest account is valid for '.$data['trial_validity_days'].' days.  This should be plenty of time to understand how our 
                                    program works and if it is right for you.</p>

                                    <p>You can <a href="'.base_url().'user/login">login</a> with following credential<br/>
                                    <br/>Username : <b>'.$data['username'].'</b><br/>Password : <b>'.$data['password'].'</b></p>

                                    <p>We look forward to having you as our newest student!</p>';
            }
            
            $contents		.= "<br/><br/>Warm regards,<br/><br/>";
            $contents		.= "ADHI Schools<br/>888 768 5285";
            return $this->Common_model->send_mail($to,'',$subject, $contents, $admin_bcc, array(), $bcc_emails);
	}
        
        function update($id, $data){
            if(is_array($id)){
                $this->db->where_in('id', $id);
            }else{
                $this->db->where('id', $id);
            }
            return $this->db->update('adhi_trial_users', $data);
	}
        
        function getQuizList($quiz_id){
            $this->db->select('c.course_name, l.id,l.quiz_name, l.quiz_status, l.topic');            
            $this->db->join('adhi_courses c', 'l.course_id = c.id');
            $this->db->where('l.id', $quiz_id);
            
            $query = $this->db->get('adhi_quiz_list l');;
            if($query->result ()){
                return $query->result();
            }
            return FALSE;
        }
        
        function getUser($id){
            $this->db->where('id' ,  $id);
            $result = $this->db->get('adhi_trial_users');
            return $result->row();
        }
        
        function getUsersToExpire(){
            $today  = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
            
            $this->db->where("DATE(DATE_SUB(will_expire_at, INTERVAL 1 DAY)) <= '".$today."'", NULL, FALSE);
            $this->db->where('status', 1);
            $this->db->where('reminder_sent', 0);
            $result     = $this->db->get('adhi_trial_users');
            return $result->result();
        }
        
        function updateTrialUserExpire(){
            $this->db->where('status', 1);
            $this->db->where("will_expire_at <= '".convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))."'", NULL, FALSE);
            $result     = $this->db->get('adhi_trial_users');
            $users  = $result->result();
            if($users){
                $ids    = array();
                foreach ($users as $user){
                    array_push($ids, $user->id);
                }
                $data   = array('status' => 3);
                $this->db->where_in('id', $ids);
                $this->db->update('adhi_trial_users', $data);
                return count($ids);
            }
            return 0;
        }
        
        function getAdhiUserByEmail($email){
            if('' != $email){
        	$this->db->where('emailid', $email);
                $this->db->select("id, firstname, lastname, status");
                $query	= $this->db->get('adhi_user');
		if($query->row()){
                    return $query->row();
                }
            }
            return FALSE;
        }
        
        function getUsersToMarketingEmail(){
            $today  = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
            
            $this->db->where("DATE(marketing_email_at) <= '".$today."'", NULL, FALSE);
            $this->db->where('status', 1);
            $this->db->where('marketing_email_sent', 0);
            $result     = $this->db->get('adhi_trial_users');
            return $result->result();
        }
        
        
}