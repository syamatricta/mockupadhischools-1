<?php

$dbcon = mysql_connect("localhost", "adhischools", "Adh86PAB6CA") or die(mysql_error());
//$dbcon = mysql_connect("localhost", "adsbetauser", "Dee34wwaqwa") or die(mysql_error());
//$dbcon = mysql_connect("192.168.0.117", "root", "") or die(mysql_error());

mysql_select_db("adhischools", $dbcon);
 
$result = mysql_query("SELECT * FROM adhi_exam_questions") or die(mysql_error());  
//$result = mysql_query("SELECT * FROM adhi_exam_answers") or die(mysql_error());  
//$result = mysql_query("SELECT * FROM adhi_quiz_questions") or die(mysql_error());  
//$result = mysql_query("SELECT * FROM adhi_quiz_answers") or die(mysql_error());  

while($row = mysql_fetch_array($result)){
	if($row['id']!=''){
		$answer = str_replace('"',"'", $row['questions']);
		$result1 = mysql_query('UPDATE adhi_exam_questions SET questions = "'.$answer.'" WHERE id ='.$row['id']) or die(mysql_error());
		
		//$answer = str_replace('"',"'", $row['answers']);
		//$result1 = mysql_query('UPDATE adhi_exam_answers SET answers = "'.$answer.'" WHERE id ='.$row['id']) or die(mysql_error());
		
		//$answer = str_replace('"',"'", $row['questions']);
		//$result1 = mysql_query('UPDATE adhi_quiz_questions SET questions = "'.$answer.'" WHERE id ='.$row['id']) or die(mysql_error());
		
		//$answer = str_replace('"',"'", $row['answers']);
		//$result1 = mysql_query('UPDATE adhi_quiz_answers SET answers = "'.$answer.'" WHERE id ='.$row['id']) or die(mysql_error());
		echo "1";
		
	}
}

?>