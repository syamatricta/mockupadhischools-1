<?php
include("dbconfig.php");
include("time_helper.php");
$cut_off_date = "2018-09-16";

$query = "select us.id,c.course_name, c.course_code, c.parent_course_name,u.renewal_status,u.id as reg_courseid,us.firstname,us.lastname,us.emailid
FROM adhi_user_course AS u JOIN adhi_user as us on us.id = u.userid JOIN adhi_courses AS c ON c.id = u.courseid WHERE u.status !='P' ORDER BY us.id,u.enrolled_date;";

$resul=mysql_query($query);
	
if($resul){
    while ($row = mysql_fetch_array($resul))
    {
           $result_arrays1[] = $row;
           $result_arrays2[] = $row;
           $result_arrays3[] = $row;
    }

    $previous_user = 0;
    $result = array();
    
    if(count($result_arrays1)>0){
            foreach ($result_arrays1 as $ky => $result_array){
                
                $current_user = $result_array['id'];
                $cou = count($result) > 0 ? count($result) - 1 : 0;

                if($result_array['parent_course_name'] != ''){
                    $result[$cou]['course_name'] = $result_array['parent_course_name']." - ".$result_array['course_name'];
                }

                if($result_array['renewal_status'] =='Y'){

                    /*$query="SELECT
                    DATE_SUB(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ), INTERVAL 1 MONTH) as maildate ,
                    date_format(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate

                    FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";*/
                    $query = "SELECT r.renew_date FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";
                    $resul = mysql_query($query);
                    
                    if($resul){
                            $row = mysql_fetch_array($resul);
                            $span = ((find_date_diff ($cut_off_date, $row['renew_date'])) > 0) ? "+2 years" : "+1 years";
                            $rnw = $row['renew_date'];
                            $firstdate = date('Y-m-d', strtotime($span, strtotime($rnw)));
                            $row['maildate'] = date('Y-m-d', strtotime("-1 MONTHS", strtotime($firstdate)));
                            $row['expiredate'] = date('m/d/Y', strtotime($span, strtotime($rnw)));

                            if(0 == $previous_user && $previous_user != $current_user){
                                $result_array['maildate'] =$row['maildate'];
                                $result_array['expiredate'] =$row['expiredate'];
                                //echo $result_array['expiredate']."<br>";
                            }else{
                                if($row['expiredate'] != $result[$cou]['expiredate']){
                                    $result_array['maildate'] =$row['maildate'];
                                    $result_array['expiredate'] =$row['expiredate'];
                                }else{
                                    $previous_user = $current_user;
                                    $result[count($result) - 1]['course_name'] .= ", ".$result_array['course_name'];
                                    continue;
                                }
                            }
                    }

                }else{
                    /*$query="SELECT
                    DATE_SUB(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ), INTERVAL 1 MONTH) as maildate ,
                    date_format(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate

                    FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";*/
                    
                    $query = "SELECT u.enrolled_date FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";
                    $resul = mysql_query($query);
                    
                    if($resul){
                            $row = mysql_fetch_array($resul);
                            $span = ((find_date_diff ($cut_off_date, $row['enrolled_date'])) > 0) ? "+2 years" : "+1 years";
                            $firstdate = date('Y-m-d', strtotime($span, strtotime($row['enrolled_date'])));
                            $row['maildate'] = date('Y-m-d', strtotime("-1 MONTHS", strtotime($firstdate)));
                            $row['expiredate'] = date('m/d/Y', strtotime($span, strtotime($row['enrolled_date'])));

                        if(0 == $previous_user && $previous_user != $current_user){
                            $result_array['maildate'] =$row['maildate'];
                            $result_array['expiredate'] =$row['expiredate'];
                            //echo $result_array['expiredate']."<br>";
                        }else{
                            if($row['expiredate'] != $result[$cou]['expiredate']){
                                $result_array['maildate'] =$row['maildate'];
                                $result_array['expiredate'] =$row['expiredate'];
                            }else{
                                $previous_user = $current_user;
                                $result[$cou]['course_name'] .= ", ".$result_array['course_name'];
                                continue;
                            }
                        }
                    }
                }

                $previous_user = $current_user;
                $result[] =$result_array;
        }
    }

    $previous_user = 0;
    
    if(count($result_arrays2)>0){
            foreach ($result_arrays2 as $ky => $result_array){
                
                $current_user = $result_array['id'];
                $cou = count($result) > 0 ? count($result) - 1 : 0;

                if($result_array['parent_course_name'] != ''){
                    $result[$cou]['course_name'] = $result_array['parent_course_name']." - ".$result_array['course_name'];
                }

                if($result_array['renewal_status'] =='Y'){

                    /*$query="SELECT
                    DATE_SUB(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ), INTERVAL 2 MONTH) as maildate ,
                    date_format(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate

                    FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";*/
                    $query = "SELECT r.renew_date FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";
                    $resul = mysql_query($query);
                    
                    if($resul){
                            $row = mysql_fetch_array($resul);
                            $span = ((find_date_diff ($cut_off_date, $row['renew_date'])) > 0) ? "+2 years" : "+1 years";
                            $rnw = $row['renew_date'];
                            $firstdate = date('Y-m-d', strtotime($span, strtotime($rnw)));
                            $row['maildate'] = date('Y-m-d', strtotime("-1 MONTHS", strtotime($firstdate)));
                            $row['expiredate'] = date('m/d/Y', strtotime($span, strtotime($rnw)));
                            
                            if(0 == $previous_user && $previous_user != $current_user){
                                $result_array['maildate'] =$row['maildate'];
                                $result_array['expiredate'] =$row['expiredate'];
                                //echo $result_array['expiredate']."<br>";
                            }else{
                                if($row['expiredate'] != $result[$cou]['expiredate']){
                                    $result_array['maildate'] =$row['maildate'];
                                    $result_array['expiredate'] =$row['expiredate'];
                                }else{
                                    $previous_user = $current_user;
                                    $result[count($result) - 1]['course_name'] .= ", ".$result_array['course_name'];
                                    continue;
                                }
                            }
                    }

                }else{
                    /*$query="SELECT
                    DATE_SUB(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ), INTERVAL 2 MONTH) as maildate ,
                    date_format(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate

                    FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";*/
                    $query = "SELECT u.enrolled_date FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";
                    $resul = mysql_query($query);
                    
                    if($resul){
                            $row = mysql_fetch_array($resul);
                            $span = ((find_date_diff ($cut_off_date, $row['enrolled_date'])) > 0) ? "+2 years" : "+1 years";
                            $firstdate = date('Y-m-d', strtotime($span, strtotime($row['enrolled_date'])));
                            $row['maildate'] = date('Y-m-d', strtotime("-2 MONTHS", strtotime($firstdate)));
                            $row['expiredate'] = date('m/d/Y', strtotime($span, strtotime($row['enrolled_date'])));

                        if(0 == $previous_user && $previous_user != $current_user){
                            $result_array['maildate'] =$row['maildate'];
                            $result_array['expiredate'] =$row['expiredate'];
                            //echo $result_array['expiredate']."<br>";
                        }else{
                            if($row['expiredate'] != $result[$cou]['expiredate']){
                                $result_array['maildate'] =$row['maildate'];
                                $result_array['expiredate'] =$row['expiredate'];
                            }else{
                                $previous_user = $current_user;
                                $result[$cou]['course_name'] .= ", ".$result_array['course_name'];
                                continue;
                            }
                        }
                    }
                }

                $previous_user = $current_user;
                $result[] =$result_array;
        }
    }

    $previous_user = 0;
    
    if(count($result_arrays3)>0){
            foreach ($result_arrays3 as $ky => $result_array){
                
                $current_user = $result_array['id'];
                $cou = count($result) > 0 ? count($result) - 1 : 0;

                if($result_array['parent_course_name'] != ''){
                    $result[$cou]['course_name'] = $result_array['parent_course_name']." - ".$result_array['course_name'];
                }

                if($result_array['renewal_status'] =='Y'){

                    /*$query="SELECT
                    DATE_SUB(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ), INTERVAL 3 MONTH) as maildate ,
                    date_format(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate

                    FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";*/
                    $query = "SELECT r.renew_date FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";
                    $resul = mysql_query($query);
                    
                    if($resul){
                            $row = mysql_fetch_array($resul);
                            $span = ((find_date_diff ($cut_off_date, $row['renew_date'])) > 0) ? "+2 years" : "+1 years";
                            $rnw = $row['renew_date'];
                            $firstdate = date('Y-m-d', strtotime($span, strtotime($rnw)));
                            $row['maildate'] = date('Y-m-d', strtotime("-1 MONTHS", strtotime($firstdate)));
                            $row['expiredate'] = date('m/d/Y', strtotime($span, strtotime($rnw)));

                            if(0 == $previous_user && $previous_user != $current_user){
                                $result_array['maildate'] =$row['maildate'];
                                $result_array['expiredate'] =$row['expiredate'];
                                //echo $result_array['expiredate']."<br>";
                            }else{
                                if($row['expiredate'] != $result[$cou]['expiredate']){
                                    $result_array['maildate'] =$row['maildate'];
                                    $result_array['expiredate'] =$row['expiredate'];
                                }else{
                                    $previous_user = $current_user;
                                    $result[count($result) - 1]['course_name'] .= ", ".$result_array['course_name'];
                                    continue;
                                }
                            }
                    }

                }else{
                    /*$query="SELECT
                    DATE_SUB(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ), INTERVAL 3 MONTH) as maildate ,
                    date_format(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate

                    FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";*/
                    $query = "SELECT u.enrolled_date FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";
                    $resul = mysql_query($query);
                    
                    if($resul){
                            $row = mysql_fetch_array($resul);
                            $span = ((find_date_diff ($cut_off_date, $row['enrolled_date'])) > 0) ? "+2 years" : "+1 years";
                            $firstdate = date('Y-m-d', strtotime($span, strtotime($row['enrolled_date'])));
                            $row['maildate'] = date('Y-m-d', strtotime("-3 MONTHS", strtotime($firstdate)));
                            $row['expiredate'] = date('m/d/Y', strtotime($span, strtotime($row['enrolled_date'])));

                        if(0 == $previous_user && $previous_user != $current_user){
                            $result_array['maildate'] =$row['maildate'];
                            $result_array['expiredate'] =$row['expiredate'];
                            //echo $result_array['expiredate']."<br>";
                        }else{
                            if($row['expiredate'] != $result[$cou]['expiredate']){
                                $result_array['maildate'] =$row['maildate'];
                                $result_array['expiredate'] =$row['expiredate'];
                            }else{
                                $previous_user = $current_user;
                                $result[$cou]['course_name'] .= ", ".$result_array['course_name'];
                                continue;
                            }
                        }
                    }
                }

                $previous_user = $current_user;
                $result[] =$result_array;
        }
    }

    
    $currentdate = date('Y-m-d');

    foreach ($result as $result){
             if($result['maildate'] == $currentdate ){
                 
                    $cours_arr = explode(",",$result['course_name']);
                    
                    if(count($cours_arr) > 1){
                        $course_count = "courses";
                    }else{
                        $course_count = "course";
                    }
                    
                    $Email_Body = ''; 
                    $Email_Body="<div style='font-size:17px; font-family: 'Times New Roman', Times, serif;'>";
                    $Email_Body=$Email_Body. "Dear ".ucfirst($result['firstname'])." ".ucfirst($result['lastname']).", <br/><br/>";
                    $Email_Body=$Email_Body. "Your time is almost up to finish up your ".$result['course_name']." ".$course_count." by taking the open book final exam on our website. <br/><br/>Please take the time to study and pass before your enrollment period is up! We know how important it is to obtain your certificates of completion and to move on to the state exam!"." <br/><br/>";
                    $Email_Body=$Email_Body. "If we can be helpful, please let us know. We are rooting for you to finish up!<br/><br/>";

                    $Email_Body=$Email_Body. "Expire Date :-  ". $result['expiredate']." <br/><br/>";
                    $Email_Body=$Email_Body. '<img src="/home/adhischools/public_html/crone/images/pass-adhi.png" style="width:400px;"/><br/><b>Andrew Liberty</b><br/>Top producer<br/>ADHI alum<br/><br/>';

                    $Email_Body=$Email_Body. "<br/>ADHI Schools, LLC<br/><a target='_blank' href='https://www.adhischools.com'>www.adhischools.com</a><br/>888-768-6285<br/><br/><div style='clear:both;'></div> ";
                    $Email_Body=$Email_Body. '<table><tr>
                                                <td><a href="https://twitter.com/adhischools/" style="display:block;float:left;" target="_blank"><img alt="Twitter" src="/home/adhischools/public_html/crone/images/twitter.png"/></a> </td>
                                                <td><a href="https://facebook.com/adhischools/" style="display:block;float:left;" target="_blank"><img alt="Facebook" src="/home/adhischools/public_html/crone/images/face_book.png"/></a> </td>
                                                <td><a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" style="display:block;float:left;"  target="_blank"><img alt="Youtube" src="/home/adhischools/public_html/crone/images/youtube.png"/></a> </td>
                                                <td><a href="https://www.instagram.com/adhischools/" style="display:block;float:left;"  target="_blank"><img alt="Instagram" src="/home/adhischools/public_html/crone/images/instagram.png" width="35"/></a> </td>
                                                <td><a href="https://www.yelp.com/biz/adhi-schools-newport-beach" style="display:block;float:left;" target="_blank"><img alt="Yelp" src="/home/adhischools/public_html/crone/images/yelp.png"/></a> </td>
                                                <td><a href="https://www.adhischools.com/blog/" style="display:block;float:left;" target="_blank"><img alt="Blog" src="/home/adhischools/public_html/crone/images/blog.png"/></a></td></tr></table></div>
                    ';

                    /*
                    include_once('mailconfig.php');	
                    $this->load->library ('email');
                    $this->email->_smtp_auth     = TRUE; 	    
                    $this->email->protocol       = "smtp";
                    $this->email->smtp_host      = constant ('_SMTP_HOST');
                    $this->email->smtp_user      = constant ('_SMTP_USER');
                    $this->email->smtp_pass      = constant ('_SMTP_PASS');
                    $this->email->mailtype       = 'html';
                    $this->email->smtp_port      = '465';
                    $from_name		     = ($from=='')?constant ('_SMTP_FROMNAME'):constant ('_SMTP_FROM');
                    $this->email->from ($this->config->item ('smtp_from'), $from_name);
                    $this->email->to ("syama@farming.cards"); //$result['emailid']
                    $this->email->reply_to (constant ('_SMTP_FROM'),$from_name);    
                    $this->email->subject ($subject);
                    $this->email->message ($body_content);
                    foreach($attachment as $attach )
                    {
                        $this->email->attach($attach);
                    }

                    if ($this->email->send ()){
                        echo "Mail delivered";
                    }else{
                        echo "Mail not delivered";
                    }
                    */

                    include_once('class.phpmailer.php');
                    include_once('mailconfig.php');			
                    $mail               = new PHPMailer();
                    $mail->From         = constant ('_SMTP_FROM'); 
                    $mail->FromName     = constant ('_SMTP_FROMNAME'); 
                    $mail->Subject      = 'Your Courses Are Expiring Soon!';
                    $mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

                    $mail->MsgHTML ($Email_Body);
                    $mail->AddAddress($result['emailid'], $result['firstname']);
                    //$mail->AddAddress($result['emailid'], $result['firstname']);
                    //$mail->addAttachment('https://www.adhischools.com/images/reskin/i-passed.png');
                    //$mail->AddAddress ($result['emailid'] , $result['firstname']);

                    $mail->IsSMTP ();
                    $mail->Host 							= 	constant ('_SMTP_HOST');
                    $mail->SMTPAuth 						= 	true;
                    $mail->Username 						= 	constant ('_SMTP_USER');
                    $mail->Password 						= 	constant ('_SMTP_PASS');
                    $mail->Port = 465;
                    $mail->isHTML(true);

                    if (!$mail->Send ()){
                         echo 'Mailer Error: ' . $mail->ErrorInfo;
                        echo  "Mail not delivered";
                    }else{
                        echo 'Mail successfully sent!';   
                    }
            }	
     }
}
?>
