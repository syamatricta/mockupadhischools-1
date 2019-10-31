<?php 
class Course_model extends Model {

  
    function Course_model()
    {
        // Call the Model constructor
        parent::Model();
    }
	function get_courselist($userid){
                $span = ($this->isOneYearEnrollment($userid) ? "1 YEAR" : "2 YEAR");

		$query= $this->db->query("SELECT c.course_name, c.course_code, c.parent_course_name, c.	parent_course_id,  c.exam_status, 
		date_format(u.effective_date,'%d/%m/%Y')as effectivedate, u.delivered_date, u.orderid, u.courseid,u.id,
		 date_format( u.enrolled_date, '%d/%m/%Y' ) AS enrolleddate, date_format( DATE_ADD( u.enrolled_date, INTERVAL ".$span." ) , '%d/%m/%Y' ) AS expiredate,
		 u.renewal_status, (select DATEDIFF( DATE_ADD( u.enrolled_date, INTERVAL ".$span." ),date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d' ))as active
		 , (select DATEDIFF(date_format(DATE_SUB( NOW( ), INTERVAL 8 HOUR ), '%Y-%m-%d') ,u.effective_date))as effective, 
		 (SELECT IF((u.renewal_status='Y'),(select renew_date from adhi_user_renewdetails where reg_courseid = u.id ORDER BY renew_date DESC LIMIT 0,1 ),'') )as renewaldate,		 
		 (select IF ((renewaldate = NULL),'', date_format(DATE_ADD(renewaldate, INTERVAL ".$span." ) , '%d/%m/%Y'))) as rexpiredate,
		 (select DATEDIFF( DATE_ADD(renewaldate, INTERVAL ".$span." ),date_format( DATE_SUB( NOW( ), INTERVAL 8 HOUR), '%Y-%m-%d' )) )as ractive
		 ,(select current_location from adhi_orderdetails as o where o.id = u.orderid) as tracklocation,
		 (select date_format(last_trackdate,'%d/%m/%Y')as trackdate from adhi_orderdetails as o where o.id = u.orderid) as lasttrackdate,
		 (select count(id) from adhi_exam_questions where course_id = u.courseid) as examcount FROM adhi_user_course AS u JOIN adhi_courses AS c ON c.id = u.courseid 

		WHERE userid = '$userid' and  u.status !='P'");
		return($query->result());
	}
	
	function get_passed_courselist($userid){
		//date_format(u.last_attemptdate,'%d/%m/%Y')as passeddate
			
		/*$query= $this->db->query("SELECT c.course_name, c.course_code, c.parent_course_name, c.	parent_course_id, u.id as regid,
		u.last_attemptdate as passeddate,u.final_score , u.orderid, u.courseid,u.enrolled_date,
		(select DATEDIFF( DATE_ADD(enrolled_date, INTERVAL 50 YEAR ),date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR), '%Y-%m-%d')))as expired
		FROM adhi_user_course AS u
		JOIN adhi_courses AS c ON c.id = u.courseid 
		
		WHERE userid = '$userid' and  u.status ='P'");*/
		
		
		//select passed exam result
		// 1. Passed status in main table and null in exam tracking table - for old data ; since the exam tracking table is new one
		// 2. Passed status in exam tracking and exam ended(exam_ended = 1) or tracked browser closing (exam_ended = 2),  no ending data from user side (either user refreshed below 10 sec after closing browser)
		
		$cur_time	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
		$query= $this->db->query("SELECT c.course_name, c.course_code, c.parent_course_name, c.	parent_course_id, u.id as regid,
		u.last_attemptdate as passeddate,u.final_score , u.orderid, u.courseid,u.enrolled_date,
		(select DATEDIFF( DATE_ADD(enrolled_date, INTERVAL 50 YEAR ),date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR), '%Y-%m-%d')))as expired
		FROM adhi_user_course AS u
		JOIN adhi_courses AS c ON c.id = u.courseid 
		LEFT JOIN  adhi_exam_tracking as et ON u.courseid = et.course_id AND u.userid=et.user_id AND is_latest = 1 
		
		WHERE 
			userid = '$userid' AND 
			(
				(u.status ='P' AND ISNULL(et.status))
				
				OR 
				
				(
					'P' = et.status 
					AND 
					(
						et.exam_ended != 0 
						OR 
						(et.exam_ended = 0 AND et.will_end_at < '$cur_time')
					)
				)
				
			)
		");
		return($query->result());
	}
	
	function get_courselistQuiz($userid){
                $span = ($this->isOneYearEnrollment($userid) ? "1 YEAR" : "2 YEAR");
		
		$sql=	"SELECT c.course_name, c.course_code, c.parent_course_name, c.parent_course_id,c.id, date_format( u.enrolled_date, '%d/%m/%Y' ) AS enrolleddate, date_format( DATE_ADD( u.enrolled_date, INTERVAL ".$span." ) , '%d/%m/%Y' ) AS expiredate, 
			u.renewal_status, (SELECT DATEDIFF( DATE_ADD( u.enrolled_date, INTERVAL ".$span." ) , date_format(DATE_SUB(NOW( ),INTERVAL 8 HOUR ), '%Y-%m-%d'))
			) AS active, (SELECT IF( (
			u.renewal_status = 'Y'
			), (
			
			SELECT renew_date
			FROM adhi_user_renewdetails
			WHERE reg_courseid = u.id
			ORDER BY renew_date DESC
			LIMIT 0 , 1
			), '' )
			) AS renewaldate, (
			
			SELECT IF( (
			renewaldate = NULL
			), '', date_format( DATE_ADD( renewaldate, INTERVAL ".$span." ) , '%d/%m/%Y' ) )
			) AS rexpiredate, (
			
			SELECT DATEDIFF( DATE_ADD( renewaldate, INTERVAL ".$span." ) , date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d' ) )
			) AS ractive
			FROM adhi_user_course AS u
			JOIN adhi_courses AS c ON c.id = u.courseid
			WHERE userid ='".$userid."'";
		$query=$this->db->query($sql);
		
		return ($query->result());
	}
	
	/**
	 * Change exam pass/fail status based on marks
	 *
	 * @param array $userid
	 * @return bool
	 */
	function check_the_status_on_marks($userid = ''){
                $this->db->where('user_id', $userid);
		$result	= $this->db->get('adhi_exam_tracking');
                
                if($result->num_rows()){
                    $val = $result ->result();
                    
                    foreach($val as $value){
                        if($value->score > 60 && $value->status == 'F'){
                            $this->db->where('user_id', $value->user_id);
                            if('' != $value->course_id && $value->course_id > 0){
                                $this->db->where('course_id', $value->course_id);
                            }
                            
                            $this->db->set('status', 'P');
                            $this->db->update('adhi_exam_tracking');
                            
                            $this->db->where('userid', $value->user_id);
                            if('' != $value->course_id && $value->course_id > 0){
                                $this->db->where('courseid', $value->course_id);
                            }
                            $this->db->set('status', 'P');
                            $this->db->update('adhi_user_course');
                            
                            
                            $arr = array(
                                'user_id' => $value->user_id,
                                'course_id' => $value->course_id,
                                'created_date' => date('Y-m-d H:i:s',strtotime('-8 hour')),
                                'score' => $value->score
                            );
                            $this->db->insert('adhi_exam_status_change_log',$arr);

                        }
                    }
                }
                
                return true;
                
	}
	
	
	function get_examlist($userid){
                $span = ($this->isOneYearEnrollment($userid) ? "1 YEAR" : "2 YEAR");
                $this->check_the_status_on_marks($userid);
		// select following exam details (not ended or failed)
		// 1. Not exsting exam tracking data is null and main exam status is not 'P' - for old data; since exam tracking is new table
		// 2. Tracking status is 'P' but exam not ended (exam_ended is zero or will_end_at less than current time)
				
		$cur_time	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
		$sql	= "SELECT c.course_name , c.id ,  c.course_code , c.exam_status ,  c.parent_course_name ,u.courseid , u.enrolled_date ,u.effective_date_status, u.effective_date , u.delivered_date , u.final_score , u.renewal_status , u.id as regid
					, u.status , 
					u.last_attemptdate,u.orderid,(select DATEDIFF( DATE_ADD( u.enrolled_date, INTERVAL ".$span." )  , 
					date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d' ) )) AS ex_date ,
					(select DATEDIFF( u.effective_date , date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d' )  )) AS effective,
					et.id as tracking_id ,
					et.exam_ended ,
					et.will_end_at, u.reinstate_status
					 FROM adhi_courses as c 
					 JOIN  adhi_user_course as u on u.courseid = c.id 
					 LEFT JOIN  adhi_exam_tracking as et ON u.courseid = et.course_id AND u.userid=et.user_id AND is_latest = 1 
					 WHERE 
					 		(
					 			(u.status!='P' AND ISNULL(et.status)) 
					 			OR 
					 			('P' != et.status) 
					 			OR
					 			('P' = et.status AND et.exam_ended = 0 AND et.will_end_at > '$cur_time')
					 		)
					 		AND 
					 		u.userid='".$userid."'";
		
		
		
		
		$query	=	$this->db->query($sql);
		if($result=$query->result_array()){
			//echo  count($result);die();
			for($i=0;$i<count($result);$i++){
				$result[$i]['disable_status']='';
				
				
				$this->db->where('course_id',$result[$i]['id']);
				$this->db->from('adhi_exam_questions');
				$result[$i]['exam_count']=$this->db->count_all_results();
				
				
				
				if(isset($result[$i]['delivered_date']) && $result[$i]['delivered_date']=='0000-00-00' and  $result[$i]['effective_date_status'] !='C'){
					
					 $sql_track			=	" SELECT  last_trackdate,current_location FROM adhi_orderdetails WHERE userid='".$userid."' and id='".$result[$i]['orderid']."'";
					$query_track		=	$this->db->query($sql_track);
					$result_track		=	$query_track->row_array();
					
					if($result_track){
						
							
						$result[$i]['disable_status']	=	'notdeliver';
						$result[$i]['tracklocation']	=	$result_track['current_location'];
						$result[$i]['lasttrackdate']	=	$result_track['last_trackdate'];
					}
					
				}
				//echo $result[$i]['delivered_date'];die();
				
				if( isset($result[$i]['ex_date']) && $result[$i]['ex_date']<0 && isset($result[$i]['renewal_status']) && $result[$i]['renewal_status']){
					
					$sql_reniew			=	" SELECT renew_date , (select DATEDIFF( DATE_ADD( renew_date, INTERVAL ".$span." )  , date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d' ) )) AS reniew from adhi_user_renewdetails WHERE reg_courseid='".$result[$i]['regid']."'";

					$query_reniew		=	$this->db->query($sql_reniew);
					$result_reniew		=	$query_reniew->row_array();
					if($result_reniew){
						if($result_reniew['reniew']<0){
							
							$result[$i]['disable_status']	=	'reniew';
						}
					}
				}
				elseif( isset($result[$i]['ex_date']) && $result[$i]['ex_date']<0){
					
					$result[$i]['disable_status']	=	'reniew';
				}
				
				if(isset($result[$i]['disable_status']) && (!$result[$i]['disable_status'])){
					
					if(isset($result[$i]['effective']) && $result[$i]['effective']> 0)
						$result[$i]['disable_status']	=	'effective';
					 elseif(isset($result[$i]['exam_status']) && $result[$i]['exam_status']=='D'){
					 	$result[$i]['disable_status']	=	'disable';
					 }
			
				}
			}//print_r($result);die();die();
					
			return $result;
			
		}
	
	
	}
	// check add course 
	function check_addcourse($userid,$type,$course_user_type,$package_type="",$admin=""){
              if(1==$course_user_type){
					$course_user_type =2;
				}else if(3==$course_user_type){
					$course_user_type =4;
				}else if(5==$course_user_type){
					$course_user_type =6;
				}else if(7==$course_user_type){
					$course_user_type =8;
				}else {
					$course_user_type =$course_user_type;
				}         
			   /* New Package */
                                
                           if($type =='S' && $package_type == 1)
                           {
                               $query= $this->db->query("SELECT count(u.courseid) as ocnt
					FROM adhi_user_course AS u
					JOIN adhi_course_price AS acp ON acp.course_id = u.courseid
					WHERE u.userid = '$userid' and acp.course_sel_type = 'O' and acp.course_type_id = '$course_user_type' ");
					
					$result = $query->result_array();
                               
                                $queryM = $this->db->query("SELECT count(u.courseid) as ocnt
					FROM adhi_user_course AS u
					JOIN adhi_course_price AS acp ON acp.course_id = u.courseid
					WHERE u.userid = '$userid' and acp.course_sel_type = 'M' and acp.course_type_id = '$course_user_type' ");
                                
                                        $resultM = $queryM->result_array();
                                        
                                        if($admin == 1 && $resultM[0]['ocnt']<=1) {
                                            $result['add_status'] = true;	
                                            return $result['add_status'];
                                        }
                                        elseif($result[0]['ocnt'] == 0){
                                            $result['add_status'] = true;	
                                            return $result['add_status'];
                                        }
                           }
                           elseif($type =='S'){

					$query= $this->db->query("SELECT count(u.courseid) as ocnt
					FROM adhi_user_course AS u
					JOIN adhi_course_price AS acp ON acp.course_id = u.courseid
					WHERE u.userid = '$userid' and acp.course_sel_type = 'O' and acp.course_type_id = '$course_user_type' ");
					
					$result = $query->result_array();
					if($result[0]['ocnt'] == 1){
					
					$query= $this->db->query("SELECT ac.course_name,ac.course_code,ac.id,acp.amount,ac.wieght from  adhi_courses ac  JOIN adhi_course_price AS acp ON acp.course_id = ac.id where ac.id  in (select u.courseid from adhi_user_course as u where u.userid = '$userid') and acp.course_type_id = '$course_user_type' ");
					//echo "SELECT course_name,course_code,id,amount,wieght from  adhi_courses  where parent_course_id !=0 and  id  in (select u.courseid from adhi_user_course as u where u.userid = '$userid') ";
					//echo $this->db->last_query();
                                        $result = $query->result_array();
					if($query->num_rows()<1){
					//echo "hii";
						$result['add_status'] = true;
						return $result['add_status'];
					}
					else{
						$query= $this->db->query("SELECT count( u.courseid ) AS cnt
						FROM adhi_user_course AS u
						JOIN adhi_course_price AS acp ON acp.course_id = u.courseid
						WHERE u.userid = '$userid'
						AND acp.course_sel_type = 'M' and acp.course_type_id = '$course_user_type' ");
						/*echo "SELECT count( u.courseid ) AS cnt
						FROM adhi_user_course AS u
						JOIN adhi_license_course AS l ON l.course_id = u.courseid
						WHERE u.userid = '$userid'
						AND l.course_type = 'M'
						AND l.licensetype = '$type' ";*/
						$result = $query->result_array();
							if($result[0]['cnt']<2 ){
								$result['add_status'] = true;								
								return $result['add_status'];
							}
							else{
								$result['add_status'] = false;	
								return $result['add_status'];					
							}
					
					}
				}else{
					$result['add_status'] = true;	
					return $result['add_status'];					
				}
			}
			if($type =='B'){
			//$query= $this->db->query("SELECT ac.course_name,ac.course_code,ac.id,acp.amount,ac.wieght from  adhi_courses  ac JOIN adhi_course_price AS acp ON acp.course_id = ac.id where ac.id not in (select u.courseid from adhi_user_course as u where u.userid = '$userid') and acp.course_type_id = '$course_user_type'");
					//echo "SELECT course_name,course_code,id,amount,wieght from  adhi_courses  where parent_course_id !=0 and  id not in (select u.courseid from adhi_user_course as u where u.userid = '$userid') ";
			//echo $this->db->last_query();
                    //    $result = $query->result_array();
					//if($query->num_rows()<1){
					//echo "hii";
					//	$result['add_status'] = true;
					//	return $result['add_status'];
					//}else{
						$query= $this->db->query("SELECT count( u.courseid ) AS cnt
						FROM adhi_user_course AS u
						JOIN adhi_course_price AS acp ON acp.course_id = u.courseid
						WHERE u.userid = '$userid'
						AND acp.course_sel_type = 'M' and acp.course_type_id = '$course_user_type' ");
						$result = $query->result_array();
						//echo $this->db->last_query();
						if($result[0]['cnt']< 8){
							$result['add_status'] = true;
							return $result['add_status'];
						}
						else{
						
						$result['add_status'] = false;	
						return $result['add_status'];	
							
						}
		         // }
			 }
	
	}
	function get_license($userid){
		$query= $this->db->query("select licensetype from  adhi_user where id = '$userid'");
		$result=$query->result_array();
		$licensetype=$result[0]['licensetype'];
		return 	$licensetype;
	}
        function get_user_course_types($userid){
		$query= $this->db->query("select course_user_type from  adhi_user where id = '$userid'");
		$result=$query->result_array();
		$course_user_type=$result[0]['course_user_type'];
		return 	$course_user_type;
	}
        function get_user_package_type($userid){
		$query= $this->db->query("select sales_new_package from  adhi_user where id = '$userid'");
		$result=$query->result_array();
		$package_user_type=$result[0]['sales_new_package'];
		return 	$package_user_type;
	}
	function check_ajaxupdate($id){
		if(isset ($id) && '' != $id){
			
			$this->db->where('id',$id);
			$this->db->where('exam_status !=','1');
			$this->db->select ("exam_time,user_id,course_id");
			$query	=	$this->db->get('adhi_user_exam');
			
			if($row=$query->row()){//$time=time()-$row->exam_time;
			
				return $row;
				
			}
			else
				return FALSE;
			
		}else 	
			return FALSE;
		
	}
	
	//notneed
	/*
	function get_exam_detail($id){
		if(isset ($id) && '' != $id){
			
			$this->db->where('user_id',$id);
			$this->db->select ("user_course_id,exam_score,id");
			$query	=	$this->db->get('adhi_user_exam_details');
			
			if($query->result())
				return $query->result();
			else
				return FALSE;
			
		}else 	
			return FALSE;
		
	}
	*/
	
	function update_score($id,$status,$user_courseid,$score,$id_detail=''){
		if(isset ($id) && '' != $id){
			
			$array = array('final_score' => $score, 'status' => $status);
			$this->db->set($array);
			$this->db->where('userid',$id);
			$this->db->where('id',$user_courseid);
			
			$this->db->update('adhi_user_course'); 
			
			//notneed
			/*
			if(isset($id_detail) && $id_detail)
				$this->delete_record($id_detail);
			*/
			
			
			return true;
		
		}else 	
			return FALSE;
		
	}
	function update_score_fail($id,$status,$user_courseid,$score){
		if(isset ($id) && '' != $id){
			
			$array = array('final_score' => $score, 'status' => $status);
			$this->db->set($array);
			$this->db->where('userid',$id);
			$this->db->where('courseid',$user_courseid);
			
			$this->db->update('adhi_user_course'); 

				
			return true;
		
		}else 	
			return FALSE;
		
	}
	
	
	//notneed
	/*
	function delete_record($id_detail){
		
		$this->db->where('id',$id_detail);
		$this->db->delete('adhi_user_exam_details');
		return true;
	}
	*/
	
	function delete_exam_date($id){
		
		$this->db->where('id',$id);
		$this->db->delete('adhi_user_exam');
		return true;
	}
	function get_score($usercourseid,$id){
		
		if(isset ($usercourseid) && '' != $usercourseid){
			
			$this->db->where('courseid',$usercourseid);
			$this->db->where('userid',$id);
			
			$this->db->select ("final_score");
			$query	=	$this->db->get('adhi_user_course');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
		
		}else 	
			return FALSE;
		
	}
	function get_effective_date($usercourseid){
		
			$this->db->where('effective_date <=',convert_UTC_to_PST_date(date('Y-m-d H:i:s')));
			$this->db->where('id',$usercourseid);
			
			$this->db->select ("id");
			$query	=	$this->db->get('adhi_user_course');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
		
	}
	function get_user_courses($user_id){
		$this->db->select('courseid');
		$this->db->where('userid', $user_id);
		$result	= $this->db->get('adhi_user_course');
		return $result->result_array();
	}
	
	function get_tracking_score($course_id,$user_id){
		$this->db->select('score,status');
		$this->db->where('user_id', $user_id);
		$this->db->where('is_latest', 1);
		$this->db->where('course_id', $course_id);
		$result	= $this->db->get('adhi_exam_tracking');
		return $result->row();
	}
	function update_score_from_tracking($course_id,$user_id,$score){			
		$array = array('final_score' => $score->score, 'status' => $score->status);
		$this->db->set($array);
		$this->db->where('userid',$user_id);
		$this->db->where('courseid',$course_id);			
		$this->db->update('adhi_user_course'); 
		
		$endexam = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
		$t_array = array('exam_status' =>1,'exam_end'=>$endexam);
		$this->db->set($t_array);
		$this->db->where('exam_status',0);				
		$this->db->where('user_id',$user_id);				
		$this->db->where('course_id',$course_id);
		$this->db->update('adhi_user_exam');
	}
        
        function hasAttendedAllExams($user_id, $staus = ''){
            $this->db->where('userid', $user_id);
            $query  = $this->db->get('adhi_user_course');
            $user_exam_count    = $query->num_rows();
            
            $this->db->where('userid', $user_id);
            if('' == $staus){
                $this->db->where_in('status', array('P', 'F'));
            }else{
                $this->db->where('status', 'P');
            }
            $query  = $this->db->get('adhi_user_course');
            $attended_exam_count    = $query->num_rows();
            
            if($attended_exam_count > 0 && $user_exam_count == $attended_exam_count){
                return TRUE;
            }
            return FALSE;
            
        }
        
        
        function isCrashCourseUser($email){
            $DB2    = $this->load->database('cco', TRUE);
            $DB2->where('ud_emailid', $email);
            $query  = $DB2->get('cc_user_details'); 
            $DB2->close();
            return ($query->num_rows() > 0) ? TRUE : FALSE;
        }
        
        function isOneYearEnrollment($userid = ""){
            
            if("" != $userid){
                $query_created = $this->db->query("select enrolled_date from adhi_user_course where userid = '$userid' ORDER BY id ASC");
                $result_created = $query_created->row_array();

                if(!empty($result_created) && "0000-00-00" != $result_created['enrolled_date']){
                    $user_enrolled_date = date("Y-m-d",strtotime($result_created['enrolled_date']));
                }else{
                    $user_enrolled_date = "0000-00-00";
                }

                if(("0000-00-00" == $user_enrolled_date) || (find_date_diff($this->config->item("cut_off_date"),$user_enrolled_date) > 0)){
                    return false;
                }else{
                    return true;
                }
            }
            
            return true;
        }
}
?>