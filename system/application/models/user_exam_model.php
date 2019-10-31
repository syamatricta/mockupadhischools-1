<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin exam functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class User_exam_model extends Model{
	
	function User_exam_model (){
		parent::Model ();
		
		//$this->output->enable_profiler();
	}  
	/**
	 * function to save the exam details
	 *
	 * @return id
	 */
	function get_course ($id) {
		
		if(isset ($id) && '' != $id){
			$sql="SELECT c.course_name,c.exam_status,c.course_code,c.id, l.attempt_count_reenroll, l.need_to_reenroll from  adhi_courses as c join adhi_user_course as l on 
				l.courseid = c.id  where l.id ='".$id."'";
				
				$query= $this->db->query($sql);
				return $query->result_array();
		}else 
			return FALSE;
		
		
	}
	
	function getquestionid($id,$edition, $where_in_ids = array(), $enable_random_selection = true){
		
		if(isset ($id) && '' != $id){
            $and_where = '';
            $order_by = '';
		    if(is_array($where_in_ids) && count($where_in_ids) > 0){
                $and_where = ' AND c.id IN('.implode(',', $where_in_ids).')';
            	$order_by = ' ORDER BY FIELD(c.id, '.implode(',', $where_in_ids).') ASC';
            }
            if($enable_random_selection){
                $order_by = ' ORDER BY RAND() ';
            }
            //AND c.edition=".$edition."
			$sql="SELECT c.id ,l.id as ansid,c.questions as question from  adhi_exam_questions as c join adhi_exam_answers as l on 
				c.id = l.question_id  where c.course_id ='".$id."'  AND l.answer_option='Y' 
				".$and_where."
				".$order_by."
				  limit 0,100";
			//	echo $sql;die();
				$query= $this->db->query($sql);
				
				return $query->result_array();
		}else 
			return FALSE;

	}
	
	function getquestion_ans($id){
		
		if(isset ($id) && '' != $id){
			$sql="SELECT c.id ,c.questions,l.answers,l.answer_option ,l.id as ansid from  adhi_exam_questions as c join adhi_exam_answers as l on 
				c.id = l.question_id  where c.id ='".$id."'";
				
				$query= $this->db->query($sql);
				return $query->result_array();
		}else 
			return FALSE;

	}
	/* notneed */
	/*
	function update_scoreplus($id){
		
		$sql="update  adhi_user_exam_details set exam_score=exam_score+1 where id='".$id."'";
		$query= $this->db->query($sql);
	}
	*/
	
	
	/**
	 * function to update the score status
	 *
	 */
	/* notneed */
	/*
	function update_score_status($id,$score){
		
		$array = array('exam_score' => $score);
		$this->db->set($array);
		
		$this->db->where('id',$id);
		
		$this->db->update('adhi_user_exam_details');
		
		return true;
	}
	*/
	
	
	/* notneed */
	/*
	function insert_score($course_id,$user_course_id,$user_id,$score){
		$date = convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"));
		$sql="insert into  
					adhi_user_exam_details 
			  	set course_id='".$course_id."',
			  		user_course_id='".$user_course_id."',
			  		exam_score='".$score."',
			  		exam_date='".$date."',
			  		user_id='".$user_id."'";
		$query= $this->db->query($sql);
		$exam_id = $this->db->insert_id ();//getting the inserted id
		return $exam_id;
	}
	*/
	
	
	//notneed
	/*
	function update_scoreminus($id){
		
		$sql="update  adhi_user_exam_details set exam_score=exam_score-1 where id='".$id."'";
		$query= $this->db->query($sql);
	}
	*/
	
	//notneed
	/*
	function get_score($id){
		
		if(isset ($id) && '' != $id){
			$this->db->select("exam_score");
			$this->db->from('adhi_user_exam_details');
			
			$this->db->where('id', $id);
			
			$query = $this->db->get();
			
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
		}else 	
			return FALSE;
	}
	*/
	
	
	function save_user_exam($course_id,$user_id){
		$examstart = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
		$examend	= convert_UTC_to_PST_datetime(date('Y-m-d H:i:s',time()+9000));
		$examtime	=	convert_UTC_to_PST_timeonly();
		if(isset ($course_id) && '' != $course_id && isset ($user_id) && '' != $user_id ){
			$ua=getBrowser();
			$yourbrowser= $ua->browser.' '.$ua->version.' '.$ua->platform;
			$array = array('course_id' => $course_id,'user_id'=>$user_id,'exam_start'=>$examstart,'exam_end'=>$examend,'exam_time'=>$examtime,'browser'=>$yourbrowser);
			$this->db->set($array);
			$this->db->insert('adhi_user_exam');
			$id = $this->db->insert_id();
			if($id)
				return $id;
			else 
				return FALSE;
				
		}else 
			return FALSE;
	
	}
	
	/***** OLD function *****/
	/*function change_effective_date($user_id,$usercourseid,$type){
		$date =convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
		if(isset($user_id) && '' != $user_id){
			if($type=='othercourse'){
				
				
				$sql_effective= "select effective_date , delivered_date , effective_date_status , last_attemptdate from adhi_user_course where  userid ='".$user_id."' and  id='".$usercourseid."'";
				$query_effective	=	$this->db->query($sql_effective);
				$effective			=	$query_effective->row_array();
						
				//$sql		=	" UPDATE `adhi_user_course` SET `effective_date` = DATE_ADD(effective_date, INTERVAL 17 DAY ) where userid ='".$user_id."' AND id !='".$usercourseid."' AND delivered_date='".$effective['delivered_date']."' AND last_attemptdate='0000-00-00'";

				if($effective['effective_date_status']!='C' || $effective['last_attemptdate']=='0000-00-00' ){
					$sql		=	" UPDATE `adhi_user_course` SET `effective_date` = DATE_ADD(effective_date, INTERVAL 17 DAY ) where userid ='".$user_id."' AND id !='".$usercourseid."' AND delivered_date='".$effective['delivered_date']."' AND last_attemptdate='0000-00-00'";
					$this->db->query($sql);
				}
			
			}elseif($type=='samecourse'){

				$sql	=	" UPDATE `adhi_user_course` SET `effective_date` = DATE_ADD(date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d') , INTERVAL 17 DAY ) , last_attemptdate='".$date."' where userid ='".$user_id."' AND id='".$usercourseid."'";	
				$query= $this->db->query($sql);
			}
			
		}else 
			return FALSE;
	}*/
	
	/****OLD ENDS**********/
	
	function change_effective_date($user_id,$usercourseid,$type){
		$date =convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
		if(isset($user_id) && '' != $user_id){
			if($type=='othercourse'){
				
				
				$sql_effective= "select effective_date , delivered_date ,effective_date, effective_date_status,last_attemptdate from adhi_user_course where  userid ='".$user_id."' and  id='".$usercourseid."'";
				$query_effective	=	$this->db->query($sql_effective);
				$effective			=	$query_effective->row_array();
				
				
				
				
				$sql_date	=	"select DATE_ADD('".$effective['effective_date'] ."', INTERVAL 18 DAY ) as new_date";
				$query_date = 	$this->db->query($sql_date);
				$res_date	=	$query_date->row_array();
				
				$new_date	=	$res_date['new_date'];
				
						
				//$sql		=	" UPDATE `adhi_user_course` SET `effective_date` = DATE_ADD(effective_date, INTERVAL 17 DAY ) where userid ='".$user_id."' AND id !='".$usercourseid."' AND delivered_date='".$effective['delivered_date']."' AND last_attemptdate='0000-00-00'";

				if($effective['effective_date_status']!='C' || $effective['last_attemptdate'] == '0000-00-00'){
					
					$sql		=	" UPDATE `adhi_user_course` SET `effective_date` = '".$new_date ."' where userid ='".$user_id."' AND id !='".$usercourseid."' AND last_attemptdate='0000-00-00' AND (effective_date>='".$effective['effective_date'] ."' AND effective_date<='".$new_date ."')" ;
					$this->db->query($sql);
					
					
					$sql		=	" UPDATE `adhi_user_course` SET `effective_date` = DATE_ADD(effective_date, INTERVAL 18 DAY ) where userid ='".$user_id."' AND id !='".$usercourseid."' AND last_attemptdate='0000-00-00' AND effective_date <'".$effective['effective_date']."'";
					$this->db->query($sql);
				}
			
			}elseif($type=='samecourse'){

				$sql	=	" UPDATE `adhi_user_course` SET `effective_date` = DATE_ADD(date_format( DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d') , INTERVAL 18 DAY ) , last_attemptdate='".$date."' where userid ='".$user_id."' AND id='".$usercourseid."'";	
				$query= $this->db->query($sql);
			}
			
		
				
		}else 
			return FALSE;
	}
	
	
	
	function already_exam_mode($user_id, $clear = 1){
		$examend = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
		if(isset($user_id) && '' != $user_id){
		
			$this->db->where('user_id',$user_id);
			$this->db->where('exam_end >',$examend);
			$this->db->order_by("exam_end", "desc");
			
			$this->db->select ("id,user_id,course_id,exam_start");
			
			$query	=	$this->db->get('adhi_user_exam');
			if($query->row()){
                                if($clear){
                                    if($this->clear_already_exam_mode($query->row())){
                                        return FALSE;
                                    } else {
                                        return $query->row();
                                    }
                                } else {
                                    return $query->row();
                                }
                        }else
				return FALSE;
				
		}else 
			return FALSE;
	}
        
        function clear_already_exam_mode($log_data = array()){
		if(!empty($log_data)){
                        $this->db->select ("started_at");
			$this->db->where('user_id',$log_data->user_id);
			$this->db->where('course_id',$log_data->course_id);
			$this->db->order_by("id", "desc");
                        $this->db->limit(1);
			$query	=	$this->db->get('adhi_exam_tracking');
                      
			if($query->row()){
                            $track_data =  $query->row();
                            if(find_date_diff($log_data->exam_start, $track_data->started_at) > 1 ){
                                    $set = 1;
                            } else {
                                $set = 0;
                            }
                        } else {
                            $set = 1;
                        }
                        
                        if($set){
                            $this->db->set(array('exam_end' => $log_data->exam_start));
                            $this->db->where('id',$log_data->id);
                            $this->db->update('adhi_user_exam');
                            return TRUE;
                        } else {
                            return FALSE;
                        }
		}
	}
	
	
	function get_grade($score){
		if($score<= 100 and $score >=90){
			 return 'A';
		}
		else if($score<= 89 and $score >=80){
			 return 'B';
		}
		else if($score<= 79 and $score >=70){
			 return 'C';
		}
		else if($score<= 69 and $score >=60){
			 return 'D';
		}
		else 	
			return FALSE;
	
	}
	function get_userinfo($id,$courseid){
		
		$query= $this->db->query("select u.firstname,u.lastname, u.name_on_certificate, u.address,u.city,u.state,u.zipcode, date_format( uc.enrolled_date,'%m/%d/%Y' )as enrolleddate ,
		date_format(uc.delivered_date,'%m/%d/%Y' )as startdate ,uc.final_score ,
		date_format( uc.last_attemptdate,'%m/%d/%Y' )as attemptdate
		,(SELECT IF((c.parent_course_name =''),(select course_name from adhi_courses  where id = uc.courseid),(select parent_course_name from adhi_courses  where id = uc.courseid)))as coursename,
		c.parent_course_name,c.course_code,c.course_name,c.course_code_new,c.updated_date 
		 from adhi_user as u join adhi_user_course as uc on uc.userid = u.id 
	 join adhi_courses  as c on c.id = uc.courseid where  c.id  = '$courseid' and u.id ='$id'
		   ");
		   	if($query->row())
				return $query->row();
			else
				return FALSE;
	}


	function create_pdf($arr,$unam=''){
				$userarray=$this->get_userinfo($arr['userid'],$arr['courseid']);
				$length = strlen ($userarray->coursename);
				///print_r($userarray);
                                $this->save_download_history($arr['userid'],$arr['courseid'],$userarray);
				$this->load->library('fpdf');
				define('FPDF_FONTPATH',$this->config->item('fonts_path'));
				$this->fpdf->Open();
				$this->fpdf->AddPage('P','mm','A4');
				/*$this->fpdf->SetFont('Arial','B',14);
				$this->fpdf->SetY(30);
				$this->fpdf->Cell(40,10,'Hello World!');*/
				$cr_date=convert_UTC_to_PST_date_slash_pdf(date('d/m/Y H:i:s'));
			
				$this->fpdf->SetFont('Arial','B','11');
				$this->fpdf->Cell(100);
				$this->fpdf->cell(100,10,"1063 West 6th Street",0,0,'C');
				$this->fpdf->Ln(5);
                                
				$this->fpdf->Cell(100);
				$this->fpdf->SetFont('Arial','B','11');
				$this->fpdf->cell(100,10,"Second floor",0,0,'C');
				
				$this->fpdf->Ln(5);
				$this->fpdf->Cell(100);				
				$this->fpdf->cell(100,10,"Ontario, CA 91762",0,0,'C');

				$this->fpdf->Ln(5);
				$this->fpdf->Cell(100);				
				$this->fpdf->cell(100,10,"Tel : (888) 768-5285",0,0,'C');

				$this->fpdf->Ln(5);
				$this->fpdf->Cell(100);				
				$this->fpdf->cell(100,10,"Fax : (800) 598-3258",0,0,'C');

				$this->fpdf->Ln(5);
				$this->fpdf->Image($this->config->item('site_basepath').'images/adhi_logo.jpg',10,12,30,0,'','https://www.adhischools.com');
				$this->fpdf->Ln(5);
				$this->fpdf->SetFont('Arial','B','11');
				$this->fpdf->SetX(20);
				$this->fpdf->SetY(45); 
				$this->fpdf->cell(30,10,"Since 2003",0,0,'C');
				$this->fpdf->SetDrawColor(255,255,255);
				$this->fpdf->SetFillColor(255,255,255);
				$this->fpdf->SetFont('Arial','B','13');
				$this->fpdf->Ln(10);
				$this->fpdf->Cell(100);
				$this->fpdf->SetX(20);
				$this->fpdf->SetY(55); 
				$heading="Statutory Course Completion Certificate for CalBRE Approved Courses";
                                
				$this->fpdf->printMiddle($heading);
				$this->fpdf->Ln(6);

				$this->fpdf->SetFont('Times','','11');
				$this->fpdf->Cell(20);
				$this->fpdf->cell(20,10,"Student Information:",0,0,'L');
				$this->fpdf->Ln(5);
				$this->fpdf->Cell(20);
				//$this->fpdf->cell(20,10,$userarray->firstname." ".$userarray->lastname,0,0,'L');
				$this->fpdf->cell(20,10,$userarray->name_on_certificate,0,0,'L');
				
				$this->fpdf->Ln(5);
			
				$this->fpdf->Cell(20);
				$this->fpdf->cell(20,10,$userarray->address,0,0,'L');
				$this->fpdf->Ln(5);
				
				$this->fpdf->Cell(20);
				$this->fpdf->cell(20,10,$userarray->city.",".$userarray->state." ".$userarray->zipcode,0,0,'L');
				$this->fpdf->Ln(10);
				
				$this->fpdf->Cell(20);
				$this->fpdf->cell(20,10,"Record of Course Completed:",0,0,'L');
				$this->fpdf->Ln(10);
				$this->fpdf->SetFillColor(255,0,0);
				$this->fpdf->SetTextColor(255);
				$this->fpdf->SetDrawColor(128,0,0);
				
			  
 				$this->fpdf->Ln(2);
				$this->fpdf->SetFont('Times','','9');
				$this->fpdf->SetFillColor(255,255,255);
				$this->fpdf->SetDrawColor(0,0,0);
				$this->fpdf->SetTextColor(0,0,0);
				$this->fpdf->Cell(20);
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$y1 = $this->fpdf->GetY();
				$this->fpdf->MultiCell(25, 4, 'Date of Registration', 1,1);		
				$y2 = $this->fpdf->GetY();
				$yH = $y2 - $y1;
				$this->fpdf->SetXY($x + 25, $this->fpdf->GetY() - $yH);
				
				$this->fpdf->Cell(20, $yH, 'Live/Corr.', 1,1);			
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 65, $this->fpdf->GetY()-$yH);
				$this->fpdf->MultiCell(18, 4, 'CalBRE Approval', 1,1);
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 83, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(20, $yH, 'Course Name', 1,1);	
				
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 103, $this->fpdf->GetY()-$yH);
				$this->fpdf->MultiCell(18, 4, 'Date Started      ', 1,1);	
				
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 121, $this->fpdf->GetY()-$yH);
				$this->fpdf->MultiCell(20, 4, 'Date Final Exam Taken', 1,1);	

				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 141, $this->fpdf->GetY()-$yH);
				$this->fpdf->MultiCell(20, 4, 'Number of Course Hours', 1,1);	
				
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 161, $this->fpdf->GetY()-$yH);
				$this->fpdf->MultiCell(15, 4, 'Final Grade', 1,1);	
				$this->fpdf->SetFont('Times','','8');
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$y1 = $this->fpdf->GetY();
				$this->fpdf->SetXY(30, $this->fpdf->GetY());
				$this->fpdf->MultiCell(25, 8,$userarray->enrolleddate , 1,1);		
				
			    $y2 = $this->fpdf->GetY();
				$yH = $y2 - $y1;
				
				$x = $this->fpdf->GetX();
				$x4=$x;
				$y = $this->fpdf->GetY();
				$y4 = $y;
				$this->fpdf->SetFont('Times','','8');
				$this->fpdf->SetXY($x + 35, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(5, $yH-4, '1', 0,0);
				
				$this->fpdf->SetXY($x4 +45, $y4 - $yH);				
				$this->fpdf->Cell(20, $yH, 'Corr.', 1,1);		
				
				$x = $this->fpdf->GetX();
				$x3=$x;
				$y = $this->fpdf->GetY();
				$y3 = $y;
				$this->fpdf->SetFont('Times','','8');
				$this->fpdf->SetXY($x + 52, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(5, $yH-4, '2', 0,0);
	
			    /*$y2 = $this->fpdf->GetY();
				$yH = $y2 - $y1;*/
				$this->fpdf->SetXY($x3 +65, $y3 - $yH);				
				$date_diff = find_date_diff(date('Y-m-d', strtotime($userarray->enrolleddate)),$userarray->updated_date);
                                if($date_diff < 0){
                                    $this->fpdf->Cell(18, $yH, $userarray->course_code, 1,1);	
                                }else{
                                    $this->fpdf->Cell(18, $yH, $userarray->course_code_new, 1,1);	
                                }		

				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 83, $this->fpdf->GetY()-$yH);
				if($length<10)
				$this->fpdf->Cell(20, $yH, $userarray->coursename, 1,1);	
				else
				$this->fpdf->MultiCell(20, 4, $userarray->coursename, 1,1);	
		
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 103, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(18, $yH, $userarray->startdate , 1,1);	

				$x = $this->fpdf->GetX();
				$x2=$x;
				$y = $this->fpdf->GetY();
				$y2 = $y;
				$this->fpdf->SetFont('Times','','8');
				$this->fpdf->SetXY($x + 118, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(5, $yH-4, '3', 0,0);
				
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x2 + 121, $y2-$yH);
				$this->fpdf->Cell(20, $yH, $userarray->attemptdate , 1,1);	
				
				$x = $this->fpdf->GetX();
				$x1=$x;
				$y = $this->fpdf->GetY();
				$y1 = $y;
				$this->fpdf->SetFont('Times','','8');
				$this->fpdf->SetXY($x + 135, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(5, $yH-4, '4', 0,0);

				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x1 + 141, $y1-$yH);
				$this->fpdf->Cell(20, $yH, '45' , 1,1);	
				$x = $this->fpdf->GetX();

				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x + 161, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(15, $yH, $this->get_grade($userarray->final_score), 1,1);	
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetFont('Times','','8');
				$this->fpdf->SetXY($x + 163, $this->fpdf->GetY()-$yH);
				$this->fpdf->Cell(5, $yH-4, '5', 0,0);
				
				$this->fpdf->Ln(10);
				$this->fpdf->SetFont('Times','','10');
				$this->fpdf->Cell(20);
				$this->fpdf->MultiCell(155, 2, "This Certificate contains the information needed for submittal to the California Bureau of Real Estate.",0,1,'L');
                                
				
				$this->fpdf->Ln(5);
				$this->fpdf->Cell(20);
				$this->fpdf->cell(100,5,"Legend:",0,0,'L');
				$this->fpdf->Ln(5);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(15,4,"1"); 
				$this->fpdf->MultiCell(120,4,"The date the course was received by ADHI Schools LLC.",0,1,'L');
				$this->fpdf->Ln(2);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(15,4,"2"); 
				$this->fpdf->MultiCell(120,4,"Whether the course was live instruction or correspondence in nature.",0,1,'L');
				$this->fpdf->Ln(2);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(15,4,"3"); 
				$this->fpdf->MultiCell(120,4,"The date the student started the class, or in the case of correspondence, the date the student received materials.",0,1,'L');
				
				$this->fpdf->Ln(2);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(15,4,"4"); 
				$this->fpdf->MultiCell(120,4,"The date the final exam was administered to the student. This is not necessarily the date the exam was graded by ADHI Schools LLC.",0,1,'L');

				$this->fpdf->Ln(2);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(15,4,"5"); 
				$this->fpdf->MultiCell(120,4,"A Score of 60% or greater is required to credit. The grade given is based solely on the student's perfomance on the final exam.",0,1,'L');
				
				$this->fpdf->Ln(5);
				$this->fpdf->Cell(20);
				$this->fpdf->cell(100,5,"Below is how we calculated your grade:",0,0,'L');

				$this->fpdf->Ln(5);
				$this->fpdf->Cell(20);
				$this->fpdf->MultiCell(100,5,"100% - 90%          - A",0,1,'L');
				$this->fpdf->Cell(20);
				$this->fpdf->MultiCell(100,5,"89% - 80%            - B",0,1,'L');
				$this->fpdf->Cell(20);
				$this->fpdf->MultiCell(100,5,"79% - 70%            - C",0,1,'L');
				$this->fpdf->Cell(20);
				$this->fpdf->MultiCell(100,5,"69% - 60%            - D",0,1,'L');
				
				$this->fpdf->Ln(5);
				$this->fpdf->Cell(20);
				$this->fpdf->cell(100,5,"School Certification:",0,0,'L');
				
				$this->fpdf->Ln(8);
				$this->fpdf->Cell(25);
				$this->fpdf->MultiCell(150,4,"I hereby certify that this Certificate reflects the permanent record of the above named student.",0,1,'L');

				$this->fpdf->Ln(3);
				$this->fpdf->Cell(25);
				$this->fpdf->MultiCell(160,4,"Successfully completed the correspondence course and passed the final exam with a score of 60% or better.",0,1,'L');
				
				$this->fpdf->Ln(8);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(80,4,"Signature of authorized individual:");
				$this->fpdf->Cell(60,4,"Date Signed:",0,1,'L');
				
				$this->fpdf->Ln(5);
				
				$x = $this->fpdf->GetX();
				$y = $this->fpdf->GetY();
				$this->fpdf->SetXY($x,$y);
				
				$this->fpdf->Image($this->config->item('site_basepath').'images/adhi_sign.jpg',40,$y-5,20,20,'');
				$this->fpdf->Cell(45);
				$this->fpdf->Cell(80,4,$userarray->attemptdate,0,1,'R');
				$this->fpdf->Ln(10);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(35,4,"Kartik Subramaniam");
				$this->fpdf->Ln(3);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(35,4,"ADHI Schools LLC");

				$this->fpdf->Ln(10);
				
				$this->fpdf->Cell(10);
				$this->fpdf->SetFont('Times','IB','8');
				$this->fpdf->Cell(180,2,"La Jolla  . Inland Empire  . Santa Monica ",0,1,'C');
				$this->fpdf->Ln(1);
				$this->fpdf->SetFillColor(0,0,0);
				$this->fpdf->SetDrawColor(0,0,0);
				
				$this->fpdf->SetTextColor(255);
				$this->fpdf->Cell(10);
				$this->fpdf->Cell(180,4,"www.adhischools.com",1,1,'C',true);
                                if($unam !=''){
                                    $this->fpdf->Output($unam.'.pdf','D');

                                }else{
                                     $this->fpdf->Output('output.pdf','D');
                                }
	}
	function update_user_score($id,$score,$status){
		$date = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
		if(isset($id) && $id !='' && isset($score) && isset($status) ){
			
			$array = array('final_score' => $score ,'last_attemptdate'=>$date, 'status'=>$status);
			$this->db->set($array);
			
			$this->db->where('id',$id);
			
			if($this->db->update('adhi_user_course'))
				return TRUE;
			else 
				return FALSE;
		}else 
			return FALSE;
		
	}
	
	function ajax_update($id){
		
		if(isset($id) && $id !=''){
		$examtime	=	convert_UTC_to_PST_timeonly();
			$array = array('exam_time' => $examtime);
			$this->db->set($array);
			//$this->db->set('exam_time',time());
			
			$this->db->where('id',$id);
			
			if($this->db->update('adhi_user_exam'))
				return true;
			else 
				return FALSE;
			
		}else 
			return FALSE;

	}
	function get_status_detail($id){
		
		if(isset($id) && $id !=''){
			
			$this->db->select('exam_status');
			$this->db->where('id',$id);
			$query=$this->db->get('adhi_user_exam');
			return $query->row();
			
		}else 
			return FALSE;

	}
	
	function update_endexam_status($id='',$course_id='',$detail_id=''){
		$endexam	= convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
		$array 		= array('exam_status' =>1,'exam_end'=>$endexam);
		$this->db->set($array);
		if($detail_id){
			$this->db->where('id',$detail_id);	
		}else {
			$this->db->where('user_id',$id);
			$this->db->where('course_id',$course_id);
		}
		$this->db->update('adhi_user_exam');
		return true;
	}
	
	function updateuserstatus($id,$status){
		

			$this->db->set('exam_status',$status);
			
			$this->db->where('id',$id);

			$this->db->update('adhi_user');
			return true;
	}
	
	function get_user_status($id){
		
		$this->db->select('id');
		$this->db->where('id',$id);
		$this->db->where('exam_status','Y');
		
		$query=$this->db->get('adhi_user');
		if($query->row())
			return true;
		else 	
			return false;
	}
	
	/**
	 * function used to get all 100 questions options
	 *
	 */
	
	function fncGetQuestionsOptions($arr_question){
		
		if(!empty($arr_question)){
			if(isset ($arr_question) && '' != $arr_question){
				$this->db->select("answers, question_id, id AS answer_id");
				$this->db->from('adhi_exam_answers');
				
				$this->db->where_in('question_id', $arr_question);
				$this->db->order_by('question_id','ASC');
				$this->db->order_by('id','ASC');
				
				$query = $this->db->get();
				
				if($query->result())
					return $query->result();
				else 	
					return FALSE;
			}else 	
				return FALSE;
		}else {
			return FALSE;
		}
	}
	
	function get_score_user($id){
		
		if(isset ($id) && '' != $id){
			$this->db->select("final_score as exam_score");
			$this->db->from('adhi_user_course');
			
			$this->db->where('id', $id);
			
			$query = $this->db->get();
			
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
		}else 	
			return FALSE;
	}
        function get_user_cert($id){

		if(isset ($id) && '' != $id){
			$this->db->select("firstname,lastname");
			$this->db->from('adhi_user');

			$this->db->where('id', $id);

			$query = $this->db->get();

			if($query->row())
				return $query->row();
			else
				return FALSE;
		}else
			return FALSE;
	}
	
	/**
	 * Insert exam tracking data at the time of exam start
	 *
	 * @param array $data
	 * @return int or false
	 */
	
	function start_exam_tracking($data){
		$this->db->set($data);
		$this->db->insert('adhi_exam_tracking');
		return $this->db->insert_id();
	}
	
	/**
	 * Update exam tracking data
	 *
	 * @param in $tracking_id
	 * @param array $data
	 * @return bool
	 */
	function update_exam_tracking($tracking_id, $data){
		$this->db->set($data);
		$this->db->where('id', $tracking_id);
		return $this->db->update('adhi_exam_tracking');
	}
	
	/**
	 * Get exam tracking data using tracking id
	 *
	 * @param int $tracking_id
	 * @return obj
	 */
	function get_exam_tracking($tracking_id){
		$this->db->where('id', $tracking_id);
		$result	= $this->db->get('adhi_exam_tracking');
		return $result->row();
	}
	
	/**
	 * Is user attended the specific course exam
	 *
	 * @param int $user_id
	 * @param int $course_id
	 * @return bool
	 */
	function isUserAttendedCourse($user_id, $course_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('course_id', $course_id);
		$result	= $this->db->get('adhi_exam_tracking');
		return ($result->num_rows()) ? true : false;
	}
	
	/**
	 * User attended exam details
	 *
	 * @param int $user_id
	 * @param int $course_id
	 * @return obj
	 */
	function getUserAttendedDetails($user_id, $course_id = ''){
		$this->db->where('user_id', $user_id);
		$this->db->where('is_latest', TRUE);
		if('' != $course_id && $course_id > 0){
			$this->db->where('course_id', $course_id);
		}
		$result	= $this->db->get('adhi_exam_tracking');
                
                if($result->num_rows()){
                   if($this->check_the_status_on_marks($result->row())){
                        $value = $result->row();
                        $value->status = 'P';
                        return $value;
                    } else {
                        return $result->row();
                    }
                } else {
                    return  false;
                }
	}
        
        /**
	 * Change exam pass/fail status based on marks
	 *
	 * @param array $value
	 * @return bool
	 */
	function check_the_status_on_marks($value = array()){
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
                    
                    return true;
                    
                }
                
                return false;
	}
	
	/**
	 * User attended exam details
	 *
	 * @param int $user_id
	 * @param int $course_id
	 * @return obj
	 */
	function deleteUserAttendedDetails($user_id, $course_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('course_id', $course_id);
		return $this->db->delete('adhi_exam_tracking');
	}
	
	/**
	 * Get all exam tracking data before a specific date
	 *
	 * @param string $past_date
	 * @param array $where
	 */
	function deleteExamDataPastDate($past_date, $where, $return_deleted_data = false){
		$deleted_data	= false;
		if($return_deleted_data){
			$this->db->select('u.name_on_certificate, c.course_name, t.started_at');
			$this->db->join('adhi_user u', 'u.id=t.user_id');
			$this->db->join('adhi_courses c', 'c.id=t.course_id');
			$this->db->where($where);
			$this->db->where("t.started_at < '#{$past_date}'", NULL, FALSE);
			$result	= $this->db->get('adhi_exam_tracking t');
			$deleted_data	= ($result->num_rows()) ? $result->result(): false;		
		}
		$this->db->where($where);
		$this->db->where("started_at < '#{$past_date}'", NULL, FALSE);
		$result	= $this->db->delete('adhi_exam_tracking');
		return ($return_deleted_data) ? $deleted_data : $result;
	}
	
	/**
	 * User Other exam details
	 *
	 * @param int $user_id
	 * @param int $course_id
	 * @return obj
	 */
	function getUserOtherAttendedDetails($user_id, $course_id){
		$this->db->select('c.course_name, t.score, t.course_id');
		$this->db->where('t.user_id', $user_id);
		$this->db->where("t.course_id <> $course_id", NULL, false);
		$this->db->join('adhi_courses c', 'c.id=t.course_id');
		$result	= $this->db->get('adhi_exam_tracking t');
		return ($result->num_rows() > 0) ? $result->result(): false;
	}
	
	/**
	 * Get course details
	 *
	 * @param int $id
	 * @return obj
	 */
	function getMainCourseDetails($id){
		$this->db->select('id, course_name');
		$this->db->where('id', $id);
		$result	= $this->db->get('adhi_courses');
		return ($result->num_rows() > 0) ? $result->row(): false;
	}
	
	/**
	 * Update user course data, like score, exam status etc..
	 *
	 * @param array $where
	 * @param array $data
	 * @return bool
	 */
	function updateUserCourseDetails($where, $data){
		$this->db->set($data);
		$this->db->where($where);
		return $this->db->update('adhi_user_course');
	}
        
        function updateExamOngoing($current_date, $exam_ongoing_duration){
            $this->db->select('id, score');
            $this->db->where('status','O');
            $this->db->where("updated_at <= '".$current_date."' - INTERVAL $exam_ongoing_duration");
            $query = $this->db->get('adhi_exam_tracking');
            $datas = $query->result_array();
            foreach($datas as $data) {
                if($data['score'] > 60) {
                    $this->db->set('status','P');
                } else {
                    $this->db->set('status','F');
                }
                $this->db->where('id',$data['id']);
                $this->db->update('adhi_exam_tracking');
            }
        }
        
        function isRenewExpired ($user_course_id = '') {
		
		if(isset ($user_course_id) && '' != $user_course_id){
                    $this->db->order_by("id", "desc");
                    $query = $this->db->get_where('adhi_user_renewdetails', array('reg_courseid' => $user_course_id));
                    
                    if($query ->num_rows() > 0){
                        $result = $query->result_array();
                        foreach($result as $res){
                           $date_diff = find_date_diff(date('Y-m-d', strtotime($res['renew_date'])),convert_UTC_to_PST_date(date('Y-m-d')));
                           if($date_diff < 0){
                               return 'Y';
                           }
                        }
                    }
		}
                
		return 'N';
	}

	function distinctQuestionIds($user_id, $course_id, $edition){
        $ids = array();
        $count = $this->getExamCount($user_id, $course_id);
        if(10137 == s('USERID')){/*echo '$count = '.$count.'<br/>';*/}
        if($count == 1){
            $this->db->select('ordered_question_ids');
            $this->db->where('user_id', $user_id);
            $this->db->where('course_id', $course_id);
            $this->db->order_by('started_at', 'ASC');
            $this->db->limit(1);
            $result	= $this->db->get('adhi_exam_tracking');
            if($result->num_rows() > 0){
                $ids    = json_decode($result->row()->ordered_question_ids, true);
                $ids    = array_values($ids);
            }
            $ids = $this->getQuestionIdsExcept($course_id, $edition, $ids);
        }else if($count > 1){
            if($no = $this->getNextQuestionSetNo($user_id, $course_id)){
            	//if(10137 == s('USERID')){echo 'IF $no = '.$no.'<br/>';}
                $this->db->select('ordered_question_ids');
                $this->db->where('user_id', $user_id);
                $this->db->where('course_id', $course_id);
                $this->db->order_by('started_at', 'ASC');
                $this->db->limit(1, $no - 1 );
                $result	= $this->db->get('adhi_exam_tracking');
                //if(10137 == s('USERID')){echo 'num_rows = '.$result->num_rows().'<br/>';}
                if($result->num_rows() > 0){
                    $ids    = json_decode($result->row()->ordered_question_ids, true);
                    $ids    = array_values($ids);
                    //if(10137 == s('USERID')){echo '$ids count = '.count($ids).'<br/>';}
                    //if(10137 == s('USERID')){echo implode(', ', $ids).'<br/>';}
                    //if(10137 == s('USERID')){echo 'count after unique = '.count(array_unique($ids)).'<br/>';}
                }
            }else{/*if(10137 == s('USERID')){echo 'ELSE $no = '.$no.'<br/>';}*/}
        }


        return $ids;

    }

    function getNextQuestionSetNo($user_id, $course_id){
        $no     = false;
        $count = $this->getExamCount($user_id, $course_id);
        if($count > 0) {
            $no  = (0 == ($count % 2)) ? 1: 2;
        }
        return $no;
    }
    function getExamCount($user_id, $course_id){
        $this->db->select('count(user_id) count', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $result	= $this->db->get('adhi_exam_tracking');
        $count     = 0;
        if($result->num_rows() > 0) {
            $count = $result->row()->count;
        }
        return $count;
    }

    function getQuestionIdsExcept($course_id, $edition, $ids){
        $this->db->select('q.id as id', FALSE);
        $this->db->where('q.course_id', $course_id);
        //$this->db->where('q.edition', $edition);
        $this->db->where('a.answer_option', 'Y');
        $this->db->where_not_in('q.id', $ids);
        $this->db->limit(100);
        $this->db->join('adhi_exam_answers a', 'q.id=a.question_id');
        $result	= $this->db->get('adhi_exam_questions q');
        if($result->num_rows() > 0) {
            $ids = $result->result_array();
            $ids = array_column($ids, 'id');
            if($result->num_rows() < 100) {
                $fill_count = 100 - $result->num_rows();

                $this->db->select('q.id as id', FALSE);
                $this->db->where('q.course_id', $course_id);
                $this->db->where('q.edition', $edition);
                $this->db->where('a.answer_option', 'Y');
                $this->db->where_not_in('q.id', $ids);
                $this->db->limit($fill_count);
                $this->db->join('adhi_exam_answers a', 'q.id=a.question_id');
                $result = $this->db->get('adhi_exam_questions q');
                if ($result->num_rows() > 0) {
                    $fill_ids = $result->result_array();
                    $fill_ids = array_column($fill_ids, 'id');
                    $ids = array_merge($ids, $fill_ids);
                }
            }
        }
        return $ids;
    }

    /**
     * Make all user course exam is_latest false
     *
     * @param int $user_id
     * @param int $course_id
     * @return obj
     */
    function makeUserAttendedExamsPast($user_id, $course_id){
        $this->db->set('is_latest', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        return $this->db->update('adhi_exam_tracking');
    }

    function modifyCourseReenrollStatus($user_id, $course_id){
        $course = $this->getUserCourseDetails($user_id, $course_id);
        if($course){
            $updateData = array();
            if('P' == $course->status){
                $updateData['need_to_reenroll'] = 0;
            }else if('F' == $course->status && 2 == $course->attempt_count_reenroll){
                $updateData['need_to_reenroll'] = 1;
            }
            if(count($updateData) > 0){
                $this->db->set($updateData);
                $this->db->where('userid', $user_id);
                $this->db->where('courseid', $course_id);
                return $this->db->update('adhi_user_course');
            }
        }

        //need_to_reenroll
    }

    /**
     * Archive old exam tracking, it will only archive when question set updated
     * and user attending exam with new question set
     * @param $data
     */
    function archiveOldExamTracking($user_id, $course_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $result	= $this->db->get('adhi_exam_tracking');
        if($result->num_rows() > 0) {
            foreach ($result->result() as $row){
                $ids    = json_decode($row->ordered_question_ids, true);
                $ids    = array_values($ids);

                $this->db->select('q.id as id', FALSE);
                $this->db->where('q.course_id', $course_id);
                $this->db->where('a.answer_option', 'Y');
                $this->db->where_in('q.id', $ids);
                $this->db->join('adhi_exam_answers a', 'q.id=a.question_id');
                $resultSet	= $this->db->get('adhi_exam_questions q');
                $noOfQuestions = $resultSet->num_rows();
                if($noOfQuestions < 100){
                    $insert_data = array(
                        'course_id' => $row->course_id,
                        'user_id' => $row->user_id,
                        'started_at' => $row->started_at,
                        'will_end_at' => $row->will_end_at,
                        'exam_ended' => $row->exam_ended,
                        'ended_at' => $row->ended_at,
                        'total_question' => $row->total_question,
                        'ordered_question_ids' => $row->ordered_question_ids,
                        'attended_details' => $row->attended_details,
                        'score' => $row->score,
                        'is_latest' => $row->is_latest,
                        'updated_at' => $row->updated_at,
                        'offline_times' => $row->offline_times,
                        'status' => $row->status,
                        'ip' => $row->ip,
                        'user_agent' => $row->user_agent,
                        'archived_at' => $row->user_agent,
                    );
                    $this->db->set($insert_data);
                    $this->db->insert('adhi_exam_tracking_archive');

                    $tracking_id    = $row->id;
                    $this->db->where('id', $tracking_id);
                    $this->db->delete('adhi_exam_tracking');
                }


            }
        }


    }
    function logExamAndChangeAttemptCount($data, $attempt_count){
        $this->db->set($data);
        $this->db->insert('user_exam_attended_log');
        if($this->db->insert_id()){
            $attempt_count  = ($attempt_count == 0 || $attempt_count >= 2) ? 1 : 2;
            $this->db->set('attempt_count_reenroll', $attempt_count);
            $this->db->where('userid', $data['user_id']);
            $this->db->where('courseid', $data['course_id']);
            return $this->db->update('adhi_user_course');
        }
    }

    function getUserCourseDetails($user_id, $course_id){
        $this->db->where('userid', $user_id);
        $this->db->where('courseid', $course_id);
        $result	= $this->db->get('adhi_user_course');
        return $result->row();
    }
    function getCourseReenrollStatus($user_id, $course_id){
        $this->db->select('need_to_reenroll');
        $this->db->where('userid', $user_id);
        $this->db->where('courseid', $course_id);
        $result	= $this->db->get('adhi_user_course');
        $row = $result->row();
        return ($row) ? $row->need_to_reenroll : 0;
    }
    function save_download_history($user_id,$course_id,$userarray = array()){
        
        if("" != $user_id && "" != $course_id && !empty($userarray)){
            $date_diff = find_date_diff(date('Y-m-d', strtotime($userarray->enrolleddate)),$userarray->updated_date);
            
            if($date_diff < 0){
                $course_code = $userarray->course_code;
            }else{
                $course_code = $userarray->course_code_new;
            }
            $insert_arr = array(
                "user_id" => $user_id,
                "course_id" => $course_id,
                "course_code" => $course_code,
                "enrolled_date" => date("Y-m-d",strtotime($userarray->enrolleddate)),
                "passed_date" => date("Y-m-d",strtotime($userarray->attemptdate)),
                "download_date" => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
            );
            
            $this->db->set($insert_arr);
            $this->db->insert('adhi_certificate_downloads');
        }
    }
    
    /**
    * User attended exam details
    *
    * @param int $user_id
    * @param int $course_id
    * @return obj
    */
   function getUserPreviousAttendedDetails($user_id, $course_id = '', $track_id = ''){
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $track_id);
        if('' != $course_id && $course_id > 0){
                $this->db->where('course_id', $course_id);
        }
        $result	= $this->db->get('adhi_exam_tracking');

        if($result->num_rows()){
           if($this->check_the_status_on_marks($result->row())){
                $value = $result->row();
                $value->status = 'P';
                return $value;
            } else {
                return $result->row();
            }
        } else {
            return  false;
        }
   }


    /**
     * User attended exam details
     *
     * @param int $user_id
     * @param int $course_id
     * @return obj
     */
    function getPreviousAttempts($user_id, $course_id = ''){
        $this->db->where('user_id', $user_id);
        $this->db->where('is_latest', FALSE);
        if('' != $course_id && $course_id > 0){
            $this->db->where('course_id', $course_id);
        }
        $result	= $this->db->get('adhi_exam_tracking');

        if($result->num_rows()){
           return $result->result();
        } else {
            return  false;
        }
    }

}