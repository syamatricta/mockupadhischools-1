<?php
$base_path = dirname(dirname(__FILE__));
include($base_path."/crone/db.php");
include($base_path."/crone/time_helper.php");
//error_reporting( E_ALL );
//ini_set('display_errors',1);

$query = "SELECT ANU.new_user_id,ANU.new_user_name,ANU.new_user_email_id,ANU.mail_count,ANU.created_date 
          FROM adhi_new_user AS ANU
          LEFT JOIN adhi_user AU ON AU.emailid = ANU.new_user_email_id
          WHERE AU.emailid IS NULL AND ANU.new_user_status = 1 and ANU.mail_status  =1 and ANU.cron_status = 1 "; 
$resul = mysqli_query($mysql_con, $query);


if ($resul) {
    $value = array();

    while ($row =  mysqli_fetch_assoc($resul)) {
        $value[] = $row;
    }
    if (count($value) > 0) {

        include_once($base_path.'/crone/guest_mailconfig.php');
        include_once($base_path.'/crone/class.phpmailer.php');

        foreach ($value as  $result_array) {
            
            $cur_date   =  convert_UTC_to_PST_date(gmdate('Y-m-d H:i:s'));               
            $date1      =  new DateTime($cur_date);
            $date2      =  new DateTime(date('Y-m-d',strtotime($result_array['created_date'])));
            $diff = $date2->diff($date1)->format("%r%a");
            //$diff = 22;                                                                    //Test value
                
            
            if($diff == 7 || $diff == 14 || $diff == 21){
                
                //$result_array['new_user_email_id'] = 'syama.s@rainconcert.in';            // Test Value
                $to = $result_array['new_user_email_id'];

                
                list($subject,$Email_Body) = get_email_template($diff,$result_array['new_user_id']);
                $subject = ucfirst($result_array['new_user_name']).', '.$subject;
                $AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                
                
                $mail_send	= sendContactMail($to,  $subject,  $Email_Body,  $AltBody);

                //$email_data = array('enquiry_id' => $result_array['new_user_id'],'email_id' => $result_array['new_user_email_id'], 'email_status' => $mail_send, 'created_date' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), 'status' => 1 );        
                $save_query = "INSERT INTO adhi_guest_enquiry_mail_history (enquiry_id,email_id,email_status,created_date,status) VALUES (".$result_array['new_user_id'].",'".$result_array['new_user_email_id']."',".$mail_send.",'".convert_UTC_to_PST_datetime(gmdate('Y-m-d H:i:s'))."',1)";        // Save email history  
                $email_history = mysqli_query($mysql_con, $save_query);
                
                if($diff == 7){
                    $mail_count = 2;
                    $cron_status = 1;
                } else if($diff == 14){
                    $mail_count = 3;
                    $cron_status = 1;
                } else if($diff == 21){
                    $mail_count = 4;
                    $cron_status = 0;
                }
                
                $update_query = "UPDATE `adhi_new_user` SET `mail_count` = ".$mail_count.",`cron_status` = ".$cron_status.",`updated_date` = '".convert_UTC_to_PST_datetime(gmdate('Y-m-d H:i:s'))."' WHERE `new_user_id` = ".$result_array['new_user_id']." AND `new_user_status` = 1";
                $email_count = mysqli_query($mysql_con, $update_query);
            }
         
        }
    }
}
mysqli_close($mysql_con);

function get_email_template($diff,$id){
    $subject = "";
    
    
    if($diff == 7){
        $subject     = "Live Or Online Real Estate Classes - ADHI Schools";
        $head        = "LIVE OR ONLINE REAL ESTATE CLASSES - <span style='color:#f73979'> <b> ADHI SCHOOLS </b> </span>";
        $body1       = "Did you get our last email? You can do classes live or online. Hear from veteran Realtor Robert Adams about what a career in real estate entails and how he got started.";
        $body2       = "Online Classes as low as";
        $body3       = "$56 each including video lectures and textbook!";
        $image_name  = "emailer-copy_54.png";
        $video_link  = "https://www.youtube.com/watch?v=HebK5BqDqXs";
        $video_title = "Robert Adams";
        $width       = 600;
    } else if($diff  ==  14){
        $subject     = "What It Takes To Be A Successful Realtor?";
        $head        = "WHAT IT TAKES TO BE A SUCCESSFUL <span style='color:#f73979'> <b> REALTOR? </b> </span>";
        $body1       = "You can do classes live or online! Hear from ADHI Schools' founder Kartik Subramaniam about
                        What it takes to be a successful Realtor?";
        $body2       = "Live Class packages";
        $body3       = "include our famous 2-Day crash course!";
        $image_name  =  "emailer-copy_55.png";
        $video_link  = "https://www.youtube.com/watch?v=estG4w07Htc";
        $video_title = "What it takes to be a successful Realtor";
        $width       = 600;
    } else if($diff  ==  21){
        $subject     = "How To Study For The Real Estate Exam From ADHI Schools";
        $head        = "HOW TO STUDY FOR THE REAL ESTATE EXAM FROM <span style='color:#f73979'> <b> ADHI SCHOOLS </b> </span>";
        $body1       = "Have you already signed up for real estate classes? Wonder what the best way is to study for the real estate exam? Check out this video.";
        $body2       = "We have live and online classes.";
        $image_name  = "emailer-copy_56.png";
        $video_link  = "https://www.youtube.com/watch?v=89hHgXHmxkk";
        $video_title = "";
        $width      = 625;
    } 
   
    $template = "<div style='font-family:sans-serif;'>
                        <table width='".$width."' style='background:url(".constant('_SITE_IMAGE_URL')."top_bg_mail.jpg);border-collapse:collapse'>
                            <tbody>
                               <tr> 
                                   <td>
                                      <table width='100%'>
                                            <tbody>
                                                <tr>
                                                    <td style='text-align:left; font-size:12px;padding:10px 50px 0px 30px;'>
                                                        <div>
                                                            <span style='display:block;'>
                                                               <a href='http://www.adhischools.com'>
                                                                     <img src='".constant('_SITE_IMAGE_URL')."adhi_logo_mail.png' alt=''/></a>
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td style='text-align:left; font-size:22px;padding:120px 0px 40px 0px;'>
                                                            <span style='display:block;color:white;'>
                                                               ".$head."
                                                            </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='font-size:22px; padding: 40px 5px;line-height:25px;text-align:center;color:#f73979;'>
                                        Greetings!
                                        <br/> 
                                    </td>
                                </tr>
                                <tr style='font-size:15px; text-align: center;color:white;'> <td>" .$body1." </td> </tr>
                                <tr>
                                    <td style='text-align:center; padding:0;'>
                                            <span style='display:block;'>
                                            <span style='color:white; display:block; margin:70px auto 15px;'>".$video_title."</span>
                                            
                                                <a href='".$video_link."' style='display:block;'>
                                                    <img width='".$width."' src='".constant('_SITE_IMAGE_URL').$image_name."' alt='".$video_title."'/></a>
                                                </a>
                                            </span>
                                    </td>
                                </tr>  
                         <tr>  
                             <td style='text-align:center;font-size:22px;'> 
                                <h4> 
                                    <a href='".constant('_SITE_BASE_URL')."user/register' style='text-decoration:none;color:white;'>Click here to register for classes!</a> 
                                 </h4>
                             </td>
                         </tr>
                        <tr style='text-align:center;font-size:18px;color:white;'>
                            <td>".$body2."</td>
                        </tr>
                        <tr style='text-align:center;font-size:15px;color:white;'>
                            <td> ".$body3." </td>
                        </tr>
                        <tr>
                            <td style='text-align:center;font-size:18px;color:white;'> <br/> <a target='_blank' href='".constant('_SITE_BASE_URL')."user/register' style='text-decoration:none;color:white;'>   <img src='".constant('_SITE_IMAGE_URL')."register_now_mail.png' alt=''/> </a> </td>
                        </tr>
                        <tr>
                            <td style='text-align:center;font-size:15px;color:white;'>  <img src='".constant('_SITE_IMAGE_URL')."contact_mail.png' alt=''/> <br/><br/> </td>
                        </tr>

                        <tr>
                            <td style='padding-bottom:4%;'>
                                <table width='100%'>
                                    <tbody>
                                        <tr>
                                            <td style='text-align:center;'>
                                                <span style='padding:0px 5px;'><a target='_blank' href='http://www.adhischools.com/blog/'><img src=".constant('_SITE_IMAGE_URL')."blog_mail.png alt=''/></a></span>
                                                <span style='padding:0px 5px;'><a target='_blank' href='https://twitter.com/adhischools/'><img src=".constant('_SITE_IMAGE_URL')."twitter_mail.png alt=''/></a></span>
                                                <span style='padding:0px 5px;'><a target='_blank' href='https://facebook.com/adhischools/'><img src=".constant('_SITE_IMAGE_URL')."fb_mail.png alt=''/></a></span>
                                                <span style='padding:0px 5px;'><a target='_blank' href='http://www.yelp.com/biz/adhi-schools-newport-beach'><img src=".constant('_SITE_IMAGE_URL')."yelp_mail.png alt=''/></a></span>
                                           </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr style='text-align:center;font-size:11px;color:white;'>
                            <td style='padding-bottom:2%;'>
                                If you don't wish to receive mails from info@adhischools, please click here to <a href='".constant('_SITE_BASE_URL')."home/unsubscribe_guest_pass/".$id."'>unsubscribe</a> 
                            </td>
                        </tr>
                     </tbody>
                  </table>           
                </div>";
    
//    print '<pre>';
//    print_r($template);
//    exit;
   
    return array($subject,$template);
}

function sendContactMail($strTo, $strSubject, $strMailBody, $strMailAltBody='', $strFrom='', $strFromName=''){
        $mail = new PHPMailer();
                $mail->CharSet = 'UTF-8';
		$mail->IsSMTP();
		$mail->Host = constant('_SMTP_HOST');
		$mail->SMTPAuth = true;
		$mail->Username = constant('_SMTP_USER');
		$mail->Password = constant('_SMTP_PASS');
                $mail->Port = constant('_SMTP_PORT');
		$mail->From = ($strFrom) ? $strFrom : constant("_SMTP_FROM");
		$mail->FromName = ($strFromName) ? $strFromName : constant("_SMTP_FROMNAME");
		$mail->AddAddress($strTo);
		$mail->AddReplyTo($strFrom, $strFromName);
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = $strSubject;
		$mail->Body = $strMailBody;
		$mail->AltBody = $strMailAltBody;

		if(!$mail->Send()){
			echo $mail->ErrorInfo;
			$error[]="Mailer Error: " . $mail->ErrorInfo;
			return false;
		}
		return true;
}

