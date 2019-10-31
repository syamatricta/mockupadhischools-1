<?php

$con=mysql_connect('localhost','root','');
mysql_select_db('test',$con);

	$action 												= 	'example.xls';
	if($action != "") @end();
	require_once './Excel/reader.php';
	$data 													= 	new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read('./UplodedFiles/'.$action);
	error_reporting(E_ALL ^ E_NOTICE);

	

	
	$q=0;$m=0;
	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
			$newData =$data->sheets[0]['cells'][$i][$j];
			if($i==1 || $i==$m+5){
					if(!empty($newData)){
						$sql="INSERT INTO questions SET question='".addslashes($newData)."'";
						mysql_query($sql);
						$q_id	=mysql_insert_id();
				}if($j==3){
					$q=$i;
					$m=$q;
				}
				
			}else{ 
					if(!empty($newData)){
						if($j==2){
							$sql	="INSERT INTO answers SET answer_option='".addslashes($newData)."',question_id='".$q_id."'";
							mysql_query($sql);
							$id	=mysql_insert_id();
						}
						else if($j==3){
							$sql	 ="UPDATE answers Set answer='".addslashes($newData)."' WHERE answer_id='".$id."'";
							mysql_query($sql);
						}
					}
				
			}
	
		}

	}
	
?>

