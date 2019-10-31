<?php 
class Adhitest extends Controller {

	function Adhitest()
	{
		parent::Controller();	
		//$this->load->model('MessagesModel');
	}
	function index()
	{
		//$this->dailymessages();
	}
//	function dailymessages()
//	{
//		$this->load->model("MessagesModel");
//		$this->load->model("client/SecurityModel");
//		$members		= $this->SecurityModel->get_all_company_memebrs_by_company( );
//		$this->MessagesModel->getDailyMessages($members);
//	}
//	function weeklymessages()
//	{
//		$this->load->model("MessagesModel");
//		$this->load->model("client/SecurityModel");
//		$members		= $this->SecurityModel->get_all_company_memebrs_by_company( );
//		$this->MessagesModel->getWeeklyMessages($members);
//	}
//	function weeklyreminder()
//	{
//		$this->load->model("MessagesModel");
//		$this->load->model("client/SecurityModel");
//		$this->MessagesModel->getWeeklyReminder();
//	}
//	function paymentremainder()
//	{
//		$this->load->model("client/PaymentModel");
//		$this->PaymentModel->callPaymentReminder();
//	}
	
	function emailposting(){ 
		error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
		$this->load->helper('emailposting');echo 's';
		$allowed_file_types	= array('.jpg', '.txt', '.pdf', '.doc', '.xls', '.rtf', '.gif', '.bmp', '.flv' ,'.png', '.ppt', '.jpeg');	
		//$obj= new receiveMail('obayoo@obayoo.com','obayoo#2009','obayoo@obayoo.com','secure.emailsrvr.com','pop3','110');
                $obj= new receiveMail('smtpuser@rainconcert.in','tm55ZefHsk','smtpuser@rainconcert.in','Pop.secureserver.net','pop3','110');
		//Connect to the Mail Box
		$obj->connect();
		// Get Total Number of Unread Email in mail box
		$tot=$obj->getTotalMails(); //Total Mails in Inbox Return integer value
                echo $tot;
		$path = _DOCUMENT_ROOT.'down/';
		for($i=1;$i<=$tot;$i++)
		{
			$head	=	$obj->getHeaders($i);  // Get Header Info Return Array Of Headers **Key Are (subject,to,toOth,toNameOth,from,fromName)
			
			print '<pre>';
			print_r($head);
			print '<pre>';	
			echo "Subjects :: ".$head['subject']."<br>";
			echo "TO :: ".$head['to']."<br>";
			echo "To Other :: ".$head['toOth']."<br>";
			echo "ToName Other :: ".$head['toNameOth']."<br>";
			echo "From :: ".$head['from']."<br>";
			echo "FromName :: ".$head['fromName']."<br>";
			echo "<br><BR>";
			echo "<br>*******************************************************************************************<BR>";
			
			if(isset($head['from']) && trim($head['from']) != ''){
				//$user_details = $this->get_user_details($head['from']);
				if(count($user_details) > 0){
					$message_contant =  $obj->getBody($i);  // Get Body Of Mail number Return String Get Mail id in interger
					//$str=$obj->GetAttech($i,"./"); // Get attached File from Mail Return name of file in comma separated string  args. (mailid, Path to store file)
					$attachments = $obj->extract_attachments($i);
					for($j=0;$j<count($attachments);$j++){
						if(trim($attachments[$j]['is_attachment']) == 1){
							$extension	=	strtolower(strrchr($attachments[$j]['name'], '.'));
							if(in_array($extension, $allowed_file_types))
							{
								$fp=fopen($path.$attachments[$j]['name'],"w");
								fwrite($fp,$attachments[$j]['attachment']);
								fclose($fp);
							}
							
						}
					}
					//$this->store_email_messages($message_contant, @$head['subject'],  $user_details, $attachments );
				}
			}
			//$obj->deleteMails($i); // Delete Mail from Mail box
		}
		$obj->close_mailbox();   //Close Mail Box
	}
	
	function get_user_details($email){
		$sql = "SELECT MM.member_id, MM.company_id, MM.md_id, MM.member_username, MM.member_email, MM.member_verified, 
				MM.member_status, MM.member_del_status,MD.md_full_name, MD.timezoneid FROM member_master AS MM 
				INNER JOIN member_details AS MD ON MM.md_id = MD.md_id 
				INNER JOIN company_master AS CM ON MM.company_id = CM.company_id AND CM.company_status = 'A'
				WHERE MM.member_email = '".$email."' AND MM.member_verified = 'Y' AND MM.member_del_status = 'N' AND member_status = 'A'";
		$query = $this->db->query( $sql );
		return $result = $query->result_array();
	}
	
	function store_email_messages($msg, $subject, $user_details, $files=array()){
		
		$member_id 		= $user_details[0]['member_id'];
		$company_id		= $user_details[0]['company_id'];
		//$timeZoneId 	= $user_details[0]['timezoneid'];
		//$message_time 	= $this->timezone->GetTime($timeZoneId, get_time_zone($timeZoneId));
		$message_time	= gmdate("Y-m-d H:i:s");
		$msg 			= strip_tags($msg);
		$msg			= '['.$subject.']'.$msg.'<br> from <a href="'.base_url().'account/configuration">E-mail</a>';
		$message_data	= array(
								'member_id' 			=> $member_id,
								'group_id' 				=> 0,
								'message_description' 	=> $msg,
								'company_id' 			=> $company_id, 
								'message_date' 			=> $message_time,
								'message_parent_id' 	=> 0,
								'client_id' 			=> 0,
								'message_update_date'	=> $message_time
							 );
			$this->db->insert( constant("TABLE_MESSAGES"), $message_data);
			$message_id = $this->db->insert_id();
			
			if((int)$message_id >0 && $member_id >0){
				$hash_sep = (hash_sep($msg));
				$this->MessagesModel->tags_insert($hash_sep, $message_time);
				if(count($files) >0){
					//print 'have attachment';
					$this->store_attachments($message_id, $files);
				}
				$this->MessagesModel->set_message_link_des($message_id);
			}
	}
	
	function store_attachments($message_id, $attachments){
		$allowed_file_types	= array('.jpg', '.txt', '.pdf', '.doc', '.xls', '.rtf', '.gif', '.bmp', '.flv' ,'.png', '.ppt', '.jpeg');	
		$make_thumb	= array('.jpg', '.gif', '.bmp', '.png', '.jpeg');
		$numoffile	= count($attachments);
		$file_dir 	= $this->config->item("message_image_folder");
		$path 		= _DOCUMENT_ROOT.'down/';
		for ($i=0; $i<$numoffile; $i++) 
		{ 
			if(trim($attachments[$i]['is_attachment']) == 1){
				$name		= 	strtolower($attachments[$i]['name']);
				$randNum    =   substr(fncUuid(),0,35);
				$file_name	=	clean_file_name($randNum.$name);
				$extension	=	strtolower(strrchr($name, '.'));
				if(in_array($extension, $allowed_file_types))
				{
					$newfile 	= 	$file_dir.$file_name; 
					if(rename($path.$attachments[$i]['name'], $newfile)){
						$attachment_data	= array( 'message_id' 	=> $message_id,	'mattach_file' 	=> $file_name );
						$this->db->insert( constant("TABLE_MESSAGES_ATTACHMENTS"), $attachment_data);
						if(in_array($extension, $make_thumb)){
							$image_size = getimagesize($newfile);
							$Config = array();
							$Config['image_library'] = 'gd2';
							$Config['source_image'] = $newfile;
							$Config['create_thumb'] = TRUE;
							$Config['maintain_ratio'] = true;
							$Config['width'] = ($image_size[0]) < 51 ? $image_size[0] : 50;
							$Config['height'] = ($image_size[1]) < 51 ? $image_size[1] : 50;
							$Config['thumb_marker'] = '';
							$Config['new_image'] = './uploads/attachments/Thump_'.$file_name;
							$this->load->library('image_lib', $Config);
							$this->image_lib->initialize($Config);
							$this->image_lib->resize();
							$this->image_lib->clear();
						}
					}
				}
			}
		}
	}
	function set_all_msg_link()
	{
		$messages	=	$this->db->get("messages");
		foreach($messages->result_array() as $message)
		{
			$this->MessagesModel->set_message_link_des($message['message_id']);
		}
	}
	
	function update_rss(){
		require_once(constant('_DOCUMENT_ROOT').'rss_parser/rss_fetch.php');		
		$this->load->model("client/FeedsModel");
		$message_time 	= gmdate("Y-m-d H:i:s");

		$feed_master_details	=	$this->db->get("feed_master");
		$feed_master_data	= 	$feed_master_details->result_array();
		foreach($feed_master_data as $feed_master)
		{
			$url		=	trim($feed_master["feed_url"]);
			$type		=	$feed_master["feed_type"];
			$feed_id	=	$feed_master["feed_id"];
			$data 		= 	array();
			$rss 		= 	fetch_rss( $url );
			
		
			if(isset($rss->items) and count($rss->items) > 0){
				if( $rss->items > 0){
					foreach ($rss->items as $item)
					{
						if (isset($item['updated']))
						{
							$message_time 	= gmdate("Y-m-d H:i:s",strtotime($item['updated']));
						}
						else if (isset($item['date_timestamp']))
						{
							$message_time 	= gmdate("Y-m-d H:i:s",$item['date_timestamp']);
						}
						else if (isset($item['date']))
						{
							$message_time 	= gmdate("Y-m-d H:i:s",strtotime($item['date']));
						}
						else if (isset($item['pubdate']))
						{
							$message_time 	= gmdate("Y-m-d H:i:s",strtotime($item['pubdate']));
						}
						else if (isset($item['published']))
						{
							$message_time 	= gmdate("Y-m-d H:i:s",strtotime($item['published']));
						}
						
						if(!isset($item['link'])) {
							$check_link = @$item['guid'];
						}else{
							$check_link = $item['link'];
						}
						if (trim($check_link) != '')
						{
							//$where		=	"feed_id = '".$feed_id."' AND fd_link = '".trim(addslashes($check_link))."'";
							$this->db->where("feed_id",$feed_id);
							$this->db->where("fd_link",trim($check_link));
							$feed_details	=	$this->db->get_where("feed_details");
							if ($feed_details->num_rows() <= 0)
							{
								$feed_details_data = array(
										'feed_id' 		=> 	$feed_id,
										'fd_title'		=>  @$item['title'],
										'fd_link'		=>  $check_link,
										'fd_date'		=>  $message_time,
										'fd_author'	 	=>  @$datas['author']
								);
								//print '<pre>';
								//print_r($rss->items);
								//print '</pre>';
								$this->FeedsModel->save_feed_data( $feed_details_data );
							}
							else
							{
								$where		=	array("feed_id" => $feed_id, "fd_link" => trim($check_link));
								$feed_details_data = array(
										'feed_id' 		=> 	$feed_id,
										'fd_title'		=>  @$item['title'],
										'fd_link'		=>  $check_link,
										'fd_date'		=>  $message_time,
										'fd_author'	 	=>  @$datas['author']
								);
								$this->FeedsModel->save_feed_data( $feed_details_data,$where );
							}
						}
					}
				}
				$this->db->where("feed_id",$feed_id);
				$feed_details		=	$this->db->get("feed_details");
				$feed_count			=	$feed_details->num_rows();
				if ($feed_count > 50)
				{
					$this->db->where("feed_id",$feed_id);
					$this->db->order_by("fd_date","DESC");
					$this->db->limit($feed_count,50);
					$feed_details		=	$this->db->get("feed_details");
					foreach ($feed_details->result_array() as $feeds)
					{
						$fd_id	=	$feeds['fd_id'];
						$this->db->where("feed_id",$fd_id);
						$this->db->where("feed_id != ","0");
						$this->db->delete("messages");
						
						$this->db->where("fd_id",$fd_id);
						$this->db->delete("feed_details");
					}
				}
				
			}
		}

	}
        
        function job(){
            echo 'HAI';exit;
        }
        
        function _authentication(){
            if (!$this->authentication->logged_in ("admin"))
            {
                    redirect("admin");
            }
            else if($this->authentication->logged_in ("admin") === "sub") 
            {
                $this->session->set_flashdata('success', $this->session->flashdata("success"));
                redirect("admin/noaccess");
                exit;
            }
        }
        function send_registration_email($user_id, $confirm = 'dont_send'){
            
            $this->_authentication();            
            
            $this->load->model(array('user_model', 'admin_user_model'));
            //$user_ids = array(7576);
            $return = '<pre><center><div style="text-align:left;width:600px;">';
            //foreach($user_ids as $user_id){
            
                $user               = $this->admin_user_model->select_single_userdetails($user_id);                
                if($user){
                    $course_user_type   = $this->admin_user_model->select_user_course_types($user->course_user_type);
                    $courses    = $this->admin_user_model->select_single_user_course_details($user_id);
                    
                    $order      = $this->admin_user_model->select_single_user_order_details($user_id)[0];
                    //print_r($order);exit;
                    $return .= $this->_send_mailto_user($user, $courses, $order, 'admin', $course_user_type, 'yes', $confirm);
                    
                    if('dont_send' == $confirm){
                        $url = $this->config->item('site_baseurl').'adhitest/send_registration_email/'.$user_id.'/send';
                        $url = str_replace('https', 'http', $url);
                        $return .= '<br/><br/><br/><a style="font-size:20px;font-weight:600;color:blue;" 
                            href="'.  $url.'">Confirm and Send</a>';
                    }                    
                }else{
                    $return .= 'Not found user';
                }
            $return .= '</div></center>';
            //echo $return;exit;
            
            $this->load->view('dsp_show_ajax', array('return_value' => $return));            
        }
        
        
        
        
        function _send_mailto_user($user, $courses, $order, $from_admin = '', $course_user_type, $ship='yes', $confirm = 'dont_send'){
                $state      = $this->admin_user_model->select_state_name($user->state)->state;
                $usertype   = $course_user_type->id;
                $this->load->model('Common_model');
		
		$from ='';
                
		$toemail= $user->emailid;
                $subject='Registration Details Adhi Real Estate School';
                
		$contents_live		= '';
                $contents_live		.= 'Dear '.$user->firstname.' '.$user->lastname.",";

                $contents_live		.= '<table cellpadding="0" cellspacing="0" border="0" width="600" >
                <tr><td><br /></td></tr>
                <tr><td align="justify" >
                <p align="justify"><b>Real estate classes classroom option: What to Expect</b></p></td>
                </tr>
                <tr><td><br /></td></tr>
                <tr><td align="left"><b>Login to your account at:  <a href="https://www.adhischools.com" target="_blank"> www.adhischools.com </b></td></tr>
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
                1. Start coming to the weekly Real Estate Principles class as soon as possible.  Even if you don&acute;t have your books yet, still come and take notes.  You can transfer these notes into your book later.  Find the closest location to you at <a href="https://www.adhischools.com/schedule" target="_blank"> www.adhischools.com/schedule </a> <br/>
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
                $contents_online	.= 'Dear '.$user->firstname.' '.$user->lastname.",<br/> <br/>";
                

                $contents_online        .= '<table cellpadding="0" cellspacing="0" border="0" width="600" >
                
                <tr><td align="justify" >
                <p align="justify"><b>Real estate classes home study: What to Expect</b></p></td>
                </tr>
                <tr><td align="left"><b>Login to your account at:  <a href="https://www.adhischools.com" target="_blank"> www.adhischools.com </b></td></tr>
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
                <b>Login Id : '.$user->emailid.'<br />';
                if($from_admin == "admin"){
                        //$contents		.='Password : '.$mail['password'].'<br />';
                }                
                $contents		.='</b></td> </tr>
                <tr><td><br /></td> </tr>
                </table>';



                $contents		.= '<b>Payment Details</b><br>';
                $contents		.=
                '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">


                <tr>
                        <td align="left"  width="150" >Payment Method</td>
                        <td align="left"  width="150" >Paypal Payment Method</td>
                </tr>
                <tr>
                        <td align="left"  width="150" >Address </td>
                        <td align="left"  width="150" >'.$order->b_address.' </td>
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
                        <td align="left"  width="150" >'.$order->b_zipcode.' </td>
                </tr>
                <tr>
                        <td align="left"  width="150" >Course Amount </td>
                        <td align="left"  width="150" > $'.$order->course_price.' </td>
                </tr>
                <tr>
                        <td align="left"  width="150" >Shipping Rate</td>
                        <td align="left"  width="150" > $'.$order->ship_rate.' </td>
                </tr>

                <tr>
                        <td align="left"  width="150" >Total Amount </td>
                        <td align="left"  width="150" > $'.$order->total_amount.' </td>
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
                if($courses !=''){
                    foreach($courses as $course){

                        $contents .= 	'<tr>
                        <td>'.$course->course_code.'</td>

                        <td>'.$course->course_name.'</td>';

                        if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
                            $contents.='<td>$'.$course->amount.'</td>';
                        }
                        $contents.='</tr>';

                    }
                }
                
                
                $contents		.= '

                </table>';
                
                if($ship =='yes'){
                    if(isset($order->trackingno) && '' != $order->trackingno){
                        $contents		.= '<br><br><b>Tracking Information</b><br>';
                        $contents .= '<table cellpadding="4" cellspacing="0" border="1" width="300"  style="border:#CCCCCC thin;">

                                <tr>
                                        <td align="left"  width="150" >Tracking No</td>
                                        <td align="left"  width="150" >'.$order->trackingno.' </td>
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
                
                //$course_usertype = (isset($this->regdata['course_usertype'])) ? $this->regdata['course_usertype'] : $this->session->userdata('course_usertype');
                
                if($course_user_type->course_type == 'Online'){
                    $text = $contents_online;
                } else {
                    $text = $contents_live;
                }
                
                $contents = $text.$contents;
                if('send' == $confirm){
                    return ($this->Common_model->send_mail($toemail,$from,$subject,$contents,'yes')) ? 'Successfully send' : 'Failed to send';
                }else{
                    return $contents;
                }

	}
        
        function cross_ref_report(){
            
            $this->_authentication();            
            
            $this->load->model('admin_user_model');
            $this->admin_user_model->getCrossRefUsers();
        }

	function date_test(){
echo time();exit;
		$today  = date('Y-m-d H:i:s', strtotime(convert_UTC_to_PST_datetime('2017-07-19 13:23:40')));
		echo $today;
		echo '<br/>';
                $check  = date('Y-m-d H:i:s', strtotime($today.' +'. $this->config->item('trial_account_activation_email_expiry')));//already saved in PST
		echo $check;
		echo '<br/>';
		echo strtotime(time());
		echo '<br/>';
		echo strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));

		echo '<br/>';
		$check  = date('Y-m-d H:i:s', strtotime($today.' +7 days'));
		echo $check;
		exit;
	}
}	
?>
