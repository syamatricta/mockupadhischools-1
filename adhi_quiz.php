<?php

/*
insert into adhi_quiz_list (course_id,edition,quiz_name,xls_path,quiz_status,topic)
select course_id,9 as edition,quiz_name,xls_path,quiz_status,topic from adhi_quiz_list where course_id=6 order by id


delete from adhi_quiz_questions where list_id in(select id from adhi_quiz_list where course_id=6 and edition = 9)


delete from adhi_quiz_answers where question_id in(select id from adhi_quiz_questions where list_id in(select id from adhi_quiz_list where course_id=6 and edition = 9))
*/
####################################################################################

$con=mysqli_connect("localhost","adhischools","Adh86PAB6CA","adhischools");
//$con=mysqli_connect("192.168.0.127","root","","adhischools");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

####################################################################################
/*
$result = mysqli_query($con,"select list_id,questions,video from adhi_quiz_questions where list_id in(select id from adhi_quiz_list where course_id=6 order by id) order by list_id,id");
$result2 = mysqli_query($con,"select id from adhi_quiz_list where course_id=6 and edition=9 order by id");

$new_id_arr = array();
$qns_arr = array();

while($row2 = mysqli_fetch_array($result2)) {
	$new_id_arr[] = $row2['id'];
}

$temp = $i = 0;
$j=0;
while($row = mysqli_fetch_array($result)) {
	$j++;
	if ($temp!=$row['list_id']) {
		$newid = $new_id_arr[$i];
		$temp = $row['list_id'];
		$i++;
	}

	$qry = "insert into adhi_quiz_questions (list_id, questions,video) values ('".$newid."','". addslashes($row['questions'])."','".$row['video']."')";
	echo "<br>";
	$result3 = mysqli_query($con,"$qry");
	if ($result3) {
   	 echo 'success';
	} else {
		echo $qry;
	    echo 'failure' . mysql_error();
	}
}
*/

#################################################################
/*
$result = mysqli_query($con,"select question_id,answers,answer_option from adhi_quiz_answers where question_id in (select id from adhi_quiz_questions where list_id in(select id from adhi_quiz_list where course_id=6 and edition = 2)) order by question_id");
$result2 = mysqli_query($con,"select id from adhi_quiz_questions where list_id in(select id from adhi_quiz_list where course_id=6 and edition=9) order by id");

$new_id_arr = array();
$qns_arr = array();

while($row2 = mysqli_fetch_array($result2)) {
	$new_id_arr[] = $row2['id'];
}

$temp = $i = 0;
while($row = mysqli_fetch_array($result)) {
	if ($temp!=$row['question_id']) {
		$newid = $new_id_arr[$i];
		$temp = $row['question_id'];
		$i++;
	}
	
	$qry = "insert into adhi_quiz_answers (question_id,answers,answer_option) values ('".$newid."','".addslashes($row['answers'])."','".$row['answer_option']."')";
	echo "<br>";
	$result3 = mysqli_query($con,"$qry");
	if ($result3) {
   	 echo 'success';
	} else {
		echo $qry;
	    echo 'failure' . mysql_error();
	}
}
*/

################################ '".addslashes($row['answers'])."'
$res = mysqli_query($con,"select l.id as list_id,qns.id qn_id,ans.id as ans_id, l.course_id ,l.edition,quiz_name,l.xls_path,l.quiz_status,l.topic,qns.questions,qns.video,answers,answer_option
	from adhi_quiz_list l
	left join adhi_quiz_questions qns on qns.list_id = l.id
	left join adhi_quiz_answers ans on ans.question_id = qns.id
	where l.course_id = 6 AND l.edition=2
	order by l.id, qns.id, ans.id");

$temp_list_id = 0;
$temp_qn_id = 0;
$temp_ans_id = 0;
while($row = mysqli_fetch_array($res)) {
	if ($temp_list_id!=$row['list_id']) {
		$qry1 = "insert into adhi_quiz_list (course_id,edition,quiz_name,xls_path,quiz_status,topic) values ('6','9','".addslashes($row['quiz_name'])."','".addslashes($row['xls_path'])."','".addslashes($row['quiz_status'])."','".addslashes($row['topic'])."')";
		$result1 = mysqli_query($con,"$qry1");
		$list_id = mysqli_insert_id($con);
		$temp_list_id = $row['list_id'];
	}
	if ($temp_qn_id!=$row['qn_id']) {
		$qry2 = "insert into adhi_quiz_questions (list_id, questions,video) values ($list_id,'".addslashes($row['questions'])."','".addslashes($row['video'])."')";
		$result2 = mysqli_query($con,"$qry2");
		$qn_id = mysqli_insert_id($con);
		$temp_qn_id = $row['qn_id'];
	}
	if ($temp_ans_id!=$row['ans_id']) {
		$qry3 = "insert into adhi_quiz_answers (question_id,answers,answer_option) values ($qn_id,'".addslashes($row['answers'])."','".addslashes($row['answer_option'])."')";
		$result3 = mysqli_query($con,"$qry3");
		$temp_ans_id = $row['ans_id'];
	}
}

mysqli_close($con);

?> 