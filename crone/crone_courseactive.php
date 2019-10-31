<?php

include("dbconfig.php");
$query="SELECT c.course_code,  
		date_format(u.effective_date,'%m/%d/%Y')as effectivedate, u.courseid,u.userid,us.firstname,us.lastname,us.emailid,
		(SELECT IF((c.parent_course_name =''),(select course_name from adhi_courses  where id = u.courseid),(select parent_course_name from adhi_courses  where id = u.courseid)))as coursename,
		
		 date_format( u.enrolled_date, '%d/%m/%Y' ) AS enrolleddate, DATE_SUB(u.effective_date, INTERVAL 2 DAY) as maildate  
		FROM adhi_user_course AS u JOIN adhi_user as us on us.id = u.userid JOIN adhi_courses AS c ON c.id = u.courseid where  DATE_SUB(u.effective_date, INTERVAL 2 DAY) = date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y/%m/%d' )  AND u.status != 'P' ";
//  DATE_SUB(u.effective_date, INTERVAL 2 DAY) !=''
	//echo $query;	
	$resul=mysql_query($query);
	
if($resul){
	while ($row = mysql_fetch_array($resul)){
			$result_array[] = $row;
		}

	  if(count($result_array)>0){
		foreach ($result_array as $result_array){

	   $Email_Body = '';
	   $Email_Body="<pre>";
	   $Email_Body=$Email_Body. "Exam Schedule"." \n";
	   $Email_Body=$Email_Body. "--------------------------------------"." \n";
	   $Email_Body=$Email_Body. "Course Name :- ".$result_array['coursename']." \n";
	   $Email_Body=$Email_Body. "You can start exam from :-  ". $result_array['effectivedate']." \n";

		include_once('class.phpmailer.php');
		include_once('mailconfig.php');			
		$mail               = new PHPMailer();
		$mail->From         = constant ('_SMTP_FROM'); 
		$mail->FromName     = constant ('_SMTP_FROMNAME'); 
		$mail->Subject      = 'Exam Schedule';
		$mail->AltBody      = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML ($Email_Body);
		$mail->AddAddress ($result_array['emailid'] , $result_array['firstname']);
		
		$mail->IsSMTP ();
		$mail->Host 							= 	constant ('_SMTP_HOST');
		$mail->SMTPAuth 						= 	true;
		$mail->Username 						= 	constant ('_SMTP_USER');
		$mail->Password 						= 	constant ('_SMTP_PASS');
		$mail->Port = 465;
		if (!$mail->Send ())
		{
		echo  "mail not delivered";
		}
		else
		{
		
		echo 'Mail successfully sent!';   
		}
	}
 }
}
?>
