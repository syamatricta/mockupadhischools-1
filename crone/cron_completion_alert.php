<?php

include("dbconfig.php");
include("time_helper.php");
include_once('class.phpmailer.php');
include_once('mailconfig.php');

$started_date = "2018-10-18"; // Just for reference

// Passed all courses
$yesterday = date('Y-m-d',strtotime("-1 days"));

$query = "SELECT AUC.last_attemptdate,US.firstname,US.lastname,US.emailid,US.phone,AC.course_type 
          FROM adhi_user_course AS AUC 
          JOIN adhi_user as US on US.id = AUC.userid 
          JOIN adhi_user_course_types as AC on AC.id = US.course_user_type 
          WHERE AUC.status = 'P' AND AUC.last_attemptdate = date_format( DATE_SUB( NOW( ) , INTERVAL 1 DAY) , '%Y-%m-%d' )  ORDER BY AUC.userid DESC;";

$resul = mysql_query($query);

if($resul){
        $result_array = array();
        while ($row = mysql_fetch_array($resul)){
            $result_array[] = $row;
        }
        
        $result = array();

        if(count($result_array)>0){
            $content = "<table border='1'>"
                        . "<tr>"
                             ."<th> Name </th>"
                             ."<th> Email </th>"
                             ."<th> Phone </th>"
                             ."<th> Course Type </th>"
                        ."</tr>";
            
            foreach ($result_array as $cou => $result){
                $content .= "<tr>"
                             ."<td> ".ucfirst($result['firstname'])." ".ucfirst($result['lastname'])." </td>"
                             ."<td> ".$result['emailid']." </td>"
                             ."<td> ".$result['phone']." </td>"
                             ."<td> ".$result['course_type']." </td>"
                        . "</tr>";
            }
            $content      .= "</table><br/><br/>";
            $Email_Body = "<div style='font-size:17px; font-family: 'Times New Roman', Times, serif;'>";
            $Email_Body = $Email_Body. "Dear Admin, <br/><br/>";
            $Email_Body = $Email_Body. "Following are the list of students who have passed all the courses in their account as on ".date('m-d-Y',strtotime("-1 days"))." <br/><br/>";
            $Email_Body = $Email_Body.$content;
            $Email_Body = $Email_Body. "ADHI Schools, LLC <br/>888-768-6285<br/><br/> <div style='clear:both;'></div><br/><br/> ";
            ;

            include_once('class.phpmailer.php');
            include_once('mailconfig.php');			
            $mail               = new PHPMailer();
            $mail->From         = constant ('_SMTP_FROM'); 
            $mail->FromName     = constant ('_SMTP_FROMNAME'); 
            $mail->Subject      = 'All Course Pass Student List For - '.date('m/d/Y',strtotime("-1 days"));
            $mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

            $mail->MsgHTML ($Email_Body);
            $mail->AddAddress ("nidhin@tricta.com" ,"Adhischools");
            //$mail->AddAddress ("kartik@adhischools.com","Kartik");
            //$mail->AddAddress ("sophia@adhischools.com","Sophia");
            //$mail->AddAddress ("crystal@adhischools.com","Crystal");

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

// Not passed any of the courses since 3 months of enrollment
$query = "SELECT US.id,US.firstname,US.lastname,US.emailid,US.phone,AC.course_type   
          FROM adhi_user_course AS AUC 
          JOIN adhi_user as US on US.id = AUC.userid 
          JOIN adhi_user_course_types as AC on AC.id = US.course_user_type 
          WHERE AUC.enrolled_date = date_format( DATE_SUB( NOW( ) , INTERVAL 90 DAY) , '%Y-%m-%d' )   AND AUC.status != 'P' ORDER BY AUC.id ASC;";


$resul1 = mysql_query($query);
if($resul1){
        while ($row = mysql_fetch_array($resul1)){
                $result_array[] = $row;
        }
        
        $result = array();
        $email_arr = array();
        $k = 0;

        if(count($result_array)>0){
            $content = "<table  border='1'>"
                        . "<tr>"
                             ."<th> Name </th>"
                             ."<th> Email </th>"
                             ."<th> Phone </th>"
                             ."<th> Course Type </th>"
                        ."</tr>";
            
            foreach ($result_array as $cou => $result){
                if(!in_array($result['emailid'],$email_arr)){
                    $email_arr[$k++] = $result['emailid'];
                    $content .= "<tr>"
                             ."<td> ".ucfirst($result['firstname'])." ".ucfirst($result['lastname'])." </td>"
                             ."<td> ".$result['emailid']." </td>"
                             ."<td> ".$result['phone']." </td>"
                             ."<td> ".$result['course_type']." </td>"
                        . "</tr>";
                    
                    $mail               = new PHPMailer();
                    $mail->From         = constant ('_SMTP_FROM'); 
                    $mail->FromName     = constant ('_SMTP_FROMNAME'); 
                    $mail->Subject      = 'List of Students With Courses Uncompleted For Enrolled Date - '.date('m/d/Y',strtotime("-1 days"));
                    $mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

                    $mail->MsgHTML ($Email_Body);
                    $mail->AddAddress ($result['emailid'] ,$result['firstname']);
                    $mail->Subject = "Finish Your Courses Today! You Are Eligible To Complete Your Courses.";
                    $student_content = 
                                "<div style='font-size:17px; font-family: 'Times New Roman', Times, serif;'>
                                    Hello ".ucfirst($result['firstname'])." ".ucfirst($result['lastname']).","." <br/><br/>
                                    It's been 3 months since you received your materials from us here at ADHI Schools. 
                                    Did you know that you could be done with the program already?
                                    We know finishing these courses and getting set up with the state exam is very important to you, 
                                    so please let us know how we can help! <br/><br/>
                                    Please let us know if you have any questions. <br/><br/>

                                    ADHI Schools, LLC <br/>888-768-6285<br/><br/> <div style='clear:both;'></div><br/><br/>
                                    <table>
                                        <tr>
                                            <td><a href='https://twitter.com/adhischools/' style='display:block;float:left;' target='_blank'><img alt='Twitter' src='/home/mockup-adhischool/public_html/crone/images/twitter.png'/></a> </td>
                                            <td><a href='https://facebook.com/adhischools/' style='display:block;float:left;' target='_blank'><img alt='Facebook' src='/home/mockup-adhischool/public_html/crone/images/face_book.png'/></a> </td>
                                            <td><a href='https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ' style='display:block;float:left;'  target='_blank'><img alt='Youtube' src='/home/mockup-adhischool/public_html/crone/images/youtube.png'/></a> </td>
                                            <td><a href='https://www.instagram.com/adhischools/' style='display:block;float:left;'  target='_blank'><img alt='Instagram' src='/home/mockup-adhischool/public_html/crone/images/instagram.png' width='35'/></a> </td>
                                            <td><a href='https://www.yelp.com/biz/adhi-schools-newport-beach' style='display:block;float:left;' target='_blank'><img alt='Yelp' src='/home/mockup-adhischool/public_html/crone/images/yelp.png'/></a> </td>
                                            <td><a href='https://www.adhischools.com/blog/' style='display:block;float:left;' target='_blank'><img alt='Blog' src='/home/mockup-adhischool/public_html/crone/images/blog.png'/></a></td>
                                        </tr>
                                    </table>
                                </div>";
                        $mail->MsgHTML ($student_content);
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
            
            $content      .= "</table><br/><br/>";
            $Email_Body = "<div style='font-size:17px; font-family: 'Times New Roman', Times, serif;'>";
            $Email_Body = $Email_Body. "Dear Admin, <br/><br/>";
            $Email_Body = $Email_Body. "Following are the list of students who has not completed any of the courses in their account since three months of enrollment. Enrolled Date :  ".date('m-d-Y',strtotime("-90 days"))." <br/><br/>";
            $Email_Body = $Email_Body.$content;
            $Email_Body = $Email_Body. "ADHI Schools, LLC <br/>888-768-6285<br/><br/> <div style='clear:both;'></div><br/><br/> ";
            ;

            			
            $mail               = new PHPMailer();
            $mail->From         = constant ('_SMTP_FROM'); 
            $mail->FromName     = constant ('_SMTP_FROMNAME'); 
            $mail->Subject      = 'List of Students With Courses Uncompleted For Enrolled Date - '.date('m/d/Y',strtotime("-1 days"));
            $mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

            $mail->MsgHTML ($Email_Body);
            $mail->AddAddress ("nidhin@tricta.com" ,"Adhischools Admin");
            
            //$mail->AddAddress ("kartik@adhischools.com","Kartik");
            //$mail->AddAddress ("sophia@adhischools.com","Sophia");
            //$mail->AddAddress ("crystal@adhischools.com","Crystal");

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
?>
