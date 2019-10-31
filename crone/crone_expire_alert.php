<?php

include("dbconfig.php");
include("time_helper.php");
$cut_off_date = "2018-09-16";
$email_arr = array();
$p = 0;

//$query = "select AUC.userid,us.firstname,us.lastname,us.emailid,AUC.*,AC.parent_course_name,AC.course_name,O.ship_status, ET.id as tracking_id, ET.exam_ended, ET.will_end_at, ET.ended_at, ET.updated_at as tracking_updated_at, ET.status as tracking_status, AC.course_code, AC.amount 
//FROM adhi_user_course AS AUC JOIN adhi_user as us on us.id = AUC.userid JOIN adhi_courses as AC on AC.id = AUC.courseid JOIN adhi_orderdetails AS O ON AUC.orderid = O.id LEFT JOIN adhi_exam_tracking AS ET ON (ET.user_id= AUC.userid AND ET.course_id=AUC.courseid AND ET.is_latest=1) WHERE ET.status != 'P' AND AUC.reinstate_status = 0 ORDER BY AUC.userid, AUC.enrolled_date DESC;";

$query = "select AUC.enrolled_date,AUC.userid,us.firstname,us.lastname,us.emailid,AUC.*,AC.parent_course_name,AC.course_name 
FROM adhi_user_course AS AUC JOIN adhi_user as us on us.id = AUC.userid JOIN adhi_courses as AC on AC.id = AUC.courseid WHERE AUC.reinstate_status = 0 ORDER BY AUC.userid, AUC.enrolled_date DESC;";


$resul=mysql_query($query);
if($resul){
        while ($row = mysql_fetch_array($resul)){
                $result_array[] = $row;
        }
        
        $previous_user = 0;
        $result = array();

        if(count($result_array)>0){
                foreach ($result_array as $cou => $result){
                    $renew_expired    = 'N';
                    
                    if($result['parent_course_name'] != ''){
                        $result_array[$cou]['course_name'] = $result['parent_course_name']." - ".$result['course_name'];
                    }
                    
                    if($result['renewal_status'] == 'Y'){
                        $query1 = "SELECT * FROM `adhi_user_renewdetails` WHERE `reg_courseid` = ".$result['id']." ORDER BY `id` DESC LIMIT 1;";
                        $resul1 = mysql_query($query1);
                        if($resul1){
                            $row1 = mysql_fetch_array($resul1);
                            
                            $span = ((find_date_diff ($cut_off_date, $row1['renew_date'])) > 0) ? "+2 years" : "+1 years";
                            $date_diff = find_date_diff ($row1['renew_date'].$span, convert_UTC_to_PST_date(date('Y-m-d')));
                            $expired_date = date('m-d-Y', strtotime($span, strtotime($row1['renew_date'])));
                            
                            $renew_expired = ($date_diff == 0) ? 'Y' : 'N';
                        }
                    }else{
                        $span = ((find_date_diff ($cut_off_date, $result['enrolled_date'])) > 0) ? "+2 years" : "+1 years";
                        $date_diff = find_date_diff ($result['enrolled_date'].$span, convert_UTC_to_PST_date(date('Y-m-d')));
                        $expired_date = date('m-d-Y', strtotime($span, strtotime($result['enrolled_date'])));
                    }
                    
                    if($date_diff == 0 ){
                        if($result['renewal_status'] != 'Y' || ($result['renewal_status'] == 'Y' && $renew_expired == 'Y')){
                            if(!in_array($result['emailid'],$email_arr)){
                                $email_arr[$p++] = $result['emailid'];
                                $Email_Body = "<div style='font-size:17px; font-family: 'Times New Roman', Times, serif;'>";
                                $Email_Body=$Email_Body. "Hello ".ucfirst($result['firstname'])." ".ucfirst($result['lastname']).","." <br/><br/>";
                                $Email_Body=$Email_Body. "It looks like your account has expired! No worries, we have options to get you back on track. Below is a list of our reinstatement options. "." <br/><br/>";
                                $Email_Body=$Email_Body. "Expired On :-  ".$expired_date." <br/><br/>";

                                $Email_Body=$Email_Body. "<b>Reinstatement Fees *includes 1 further year of enrollment</b><br/><br/>";
                                $Email_Body=$Email_Body. "<b>Live w/current text book</b> - $75 per class<br/>";
                                $Email_Body=$Email_Body. "<b>Live w/new text book</b> - $99 per class<br/><br/>";
                                $Email_Body=$Email_Body. "<b>Online w/current text book </b>- $50 per class<br/>";
                                $Email_Body=$Email_Body. "<b>Online w/new text book</b> - $65 per class<br/><br/>";
                                $Email_Body=$Email_Body. "<b>*per class</b> - i.e. Real Estate Principles, Real Estate Practice, Real Estate Law<br/><br/>";
                                $Email_Body=$Email_Body. "To reinstate your crash course <b><i>if it was included in your original package</i></b> you would simply pay $49. <i><u>The crash course enrollment is good for 4 months from purchase so we advise waiting until you are done with the certificate final exams and are ready to apply for the state</u></i>.<br/><br/>";
                                $Email_Body=$Email_Body. "We can take these payments over the phone and get your account reinstated instantly. Don't let your goal slip away - get your courses done with us and we will help you onto the next step, the DRE real estate licensing exam.<br/><br/>";
                                $Email_Body=$Email_Body. "Please let us know if you have any questions. <br/><br/>";

                                $Email_Body=$Email_Body. "ADHI Schools, LLC <br/>888-768-6285<br/><br/> <div style='clear:both;'></div><br/><br/> ";
                                $Email_Body=$Email_Body. '<table><tr>
                                                    <td><a href="https://twitter.com/adhischools/" style="display:block;float:left;" target="_blank"><img alt="Twitter" src="./images/twitter.png"/></a> </td>
                                                    <td><a href="https://facebook.com/adhischools/" style="display:block;float:left;" target="_blank"><img alt="Facebook" src="./images/face_book.png"/></a> </td>
                                                    <td><a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" style="display:block;float:left;"  target="_blank"><img alt="Youtube" src="./images/youtube.png"/></a> </td>
                                                    <td><a href="https://www.instagram.com/adhischools/" style="display:block;float:left;"  target="_blank"><img alt="Instagram" src="./images/instagram.png" width="35"/></a> </td>
                                                    <td><a href="https://www.yelp.com/biz/adhi-schools-newport-beach" style="display:block;float:left;" target="_blank"><img alt="Yelp" src="./images/yelp.png"/></a> </td>
                                                    <td><a href="https://www.adhischools.com/blog/" style="display:block;float:left;" target="_blank"><img alt="Blog" src="./images/blog.png"/></a></td></tr></table></div>
                                ';

                                include_once('class.phpmailer.php');
                                include_once('mailconfig.php');			
                                $mail               = new PHPMailer();
                                $mail->From         = constant ('_SMTP_FROM'); 
                                $mail->FromName     = constant ('_SMTP_FROMNAME'); 
                                $mail->Subject      = 'Oh No! It looks like your courses have expired. Reinstate now!';
                                $mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

                                $mail->MsgHTML ($Email_Body);
                                //$mail->AddAddress ("syama@farming.cards" ,$result['firstname']);
                                $mail->AddAddress ($result['emailid'] ,$result['firstname']);

                                $mail->IsSMTP ();
                                $mail->Host 						= 	constant ('_SMTP_HOST');
                                $mail->SMTPAuth 						= 	true;
                                $mail->Username 						= 	constant ('_SMTP_USER');
                                $mail->Password 						= 	constant ('_SMTP_PASS');
                                $mail->Port = 465;
                                if (!$mail->Send ()){
                                    echo  "Mail not delivered";
                                }else{
                                    echo 'Mail successfully sent!';   
                                }
                            }
                            
                        }
                    }
                }
        }
}
?>
