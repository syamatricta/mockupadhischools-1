<?php
$base_path = dirname(dirname(__FILE__));
include($base_path."/crone/db.php");
$query	= "select c.course_name, c.course_code, c.parent_course_name,u.renewal_status,u.id as reg_courseid,us.firstname,us.lastname,us.emailid
			FROM adhi_user_course AS u JOIN adhi_user as us on us.id = u.userid JOIN adhi_courses AS c ON c.id = u.courseid WHERE u.status !='P' ";


$resul	= mysqli_query($mysql_con, $query);
if(mysqli_affected_rows($mysql_con)){
    while ($row = mysqli_fetch_assoc($resul))
    {
        $result_array[] = $row;
    }

    if(count($result_array) > 0){
        include_once($base_path.'/crone/class.phpmailer.php');
        include_once($base_path.'/crone/mailconfig.php');
        foreach ($result_array as $result_array){
            if($result_array['renewal_status'] =='Y'){

                $query="SELECT
					DATE_SUB(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ), INTERVAL 2 MONTH) as maildate ,
					date_format(DATE_ADD( r.renew_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate
					
					FROM adhi_user_renewdetails AS r where r.reg_courseid ='".$result_array['reg_courseid']."'  ";
                $resul=mysqli_query($mysql_con, $query);

                if($resul){
                    $row = mysqli_fetch_array($resul);

                    $result_array['maildate'] 	= $row['maildate'];
                    $result_array['expiredate'] = $row['expiredate'];
                    //echo $result_array['expiredate']."<br>";
                }

            }else{
                $query="SELECT
					DATE_SUB(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ), INTERVAL 2 MONTH) as maildate ,
					date_format(DATE_ADD( u.enrolled_date, INTERVAL 2 YEAR ) , '%m/%d/%Y' ) AS expiredate
					
					FROM adhi_user_course AS u where u.id ='".$result_array['reg_courseid']."'  ";
                $resul=mysqli_query($mysql_con, $query);

                if($resul){
                    $row = mysqli_fetch_assoc($resul);

                    $result_array['maildate'] =$row['maildate'];
                    $result_array['expiredate'] =$row['expiredate'];
                    //echo $result_array['expiredate']."<br>";
                }
            }
            $result[] =$result_array;

        }
    }

    $currentdate = date('Y-m-d');
    foreach ($result as $result){
        if($result['maildate'] == $currentdate ){
            $Email_Body = '';
            if($result['parent_course_name']!='')
                $coursename = $result['parent_course_name']." - ".$result['course_name'];
            else
                $coursename = $result['course_name'];

            $Email_Body="<pre>";
            $Email_Body=$Email_Body. "Dear ADHI Student,"." \n\n";
            $Email_Body=$Email_Body. "Your time is almost up to finish up your courses by taking the open book final exam. Please take the time to study and attempt the exam before your time is up! We know how important it is for you to obtain your certificates of completion and to move on to the next step."." \n";
            $Email_Body=$Email_Body. "If you have any questions or concerns, please let us know. We are rooting for you to finish up!\n\n";
            $Email_Body=$Email_Body. "ADHI Schools, LLC \n 888-768-6285\n\n <div style='clear:both;'></div><br/><br/> ";

            $Email_Body=$Email_Body. '<img alt="I Passed!" class="img-responsive" src="https://www.adhischools.com/images/reskin/i-passed.png"/>\n\n';
            $Email_Body=$Email_Body. '<div>
                                        <a href="https://twitter.com/adhischools/" target="_blank"><img alt="Twitter" src="https://www.adhischools.com/images/twitter.png"/></a>
                                        <a href="https://facebook.com/adhischools/" target="_blank"><img alt="Facebook" src="https://www.adhischools.com/images/face_book.png"/></a>
                                        <a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank"><img alt="Youtube" src="https://www.adhischools.com/images/youtube.png"/></a>
                                        <a href="https://www.instagram.com/adhischools/" target="_blank"><img alt="Instagram" src="https://www.adhischools.com/images/instagram.png" width="35"/></a>
                                        <a href="https://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank"><img alt="Yelp" src="https://www.adhischools.com/images/yelp.png"/></a> 
                                        <a href="https://www.adhischools.com/blog/" target="_blank"><img alt="Blog" src="https://www.adhischools.com/images/blog.png"/></a> </div>';
            //$Email_Body=$Email_Body. "Course Name :- ".$coursename." \n";
            //$Email_Body=$Email_Body. "Expire Date :-  ". $result['expiredate']." \n";

            $mail               = new PHPMailer();
            $mail->From         = constant ('_SMTP_FROM');
            $mail->FromName     = constant ('_SMTP_FROMNAME');
            $mail->Subject      = 'Course Expiration Details';
            $mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

            $mail->MsgHTML ($Email_Body);
            $mail->AddAddress ($result['emailid'] , $result['firstname']);

            $mail->IsSMTP ();
            $mail->Host 							= 	constant ('_SMTP_HOST');
            $mail->SMTPAuth 						= 	true;
            $mail->Username 						= 	constant ('_SMTP_USER');
            $mail->Password 						= 	constant ('_SMTP_PASS');
            $mail->Port = 465;
            if (!$mail->Send ()){
                echo  "mail not delivered";
            }else{
                echo 'Mail successfully sent!';
            }
        }
    }
}
mysqli_close($mysql_con);
?>