<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * Handles admin exam functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------


class Quiz_model extends Model {
	
	function Quiz_model() {
		parent::Model ();
	
		//$this->output->enable_profiler();
	}
	/**
	 * function to get quiz list
	 *
	 * @return id
	 */
	function get_quizlist($course_id, $user_id = '',$edition) 
	{
		
		if (isset ( $course_id ) && '' != $course_id) {
			$str = '';
			if (isset ( $user_id ) && $user_id != '') {
				$str = ' AND qu.user_id=' . $user_id;
			}
			
			$sql = "SELECT 
							c.course_name,
							l.id,l.quiz_name,
							l.quiz_status,
							l.topic,
							DATE_FORMAT((COALESCE(MAX(qu.quiz_start),0)),'%m/%d/%Y %H:%i:%s') AS last_date
						FROM 
							adhi_courses AS c 
						JOIN 
							adhi_quiz_list AS l 
						ON
							l.course_id 	= c.id
						LEFT JOIN 
							adhi_user_quiz AS qu
						ON 
							(qu.quiz_id = l.id " . $str . ")
						WHERE 
							l.course_id 	= '" . $course_id . "' AND
							l.edition 	= '" . $edition . "' 
						GROUP BY l.id
						ORDER BY 
							l.id";
			
			//AND l.quiz_status='E'
			

			$query = $this->db->query ( $sql );
			
			if ($query->result ())
				return $query->result ();
			else
				return FALSE;
		} else
			return FALSE;
	}
	function getquestionid($id) {
		
		if (isset ( $id ) && '' != $id) {
			$sql = "SELECT c.id ,l.id as ansid,c.questions as question,c.video from  adhi_quiz_questions as c join adhi_quiz_answers as l on 
				c.id = l.question_id  where c.list_id ='" . $id . "' AND l.answer_option='Y' ORDER BY RAND()";

			$query = $this->db->query ( $sql );
			return $query->result_array();
		} else
			return FALSE;
	
	}
	
	function getquestion_ans($id) {
		
		if (isset ( $id ) && '' != $id) {
			$sql = "SELECT c.id, c.questions, c.video, l.answers,l.answer_option ,l.id as ansid from  adhi_quiz_questions as c join adhi_quiz_answers as l on 
				c.id = l.question_id  where c.id ='" . $id . "' order by l.id";
			
			$query = $this->db->query ( $sql );
			return $query->result_array ();
		} else
			return FALSE;
	
	}
	
	function getquestion($id) {
		
		if (isset ( $id ) && '' != $id) {
			
			$this->db->select ( "questions" );
			$this->db->from ( 'adhi_quiz_questions' );
			
			$this->db->where ( 'id', $id );
			
			$query = $this->db->get ();
			
			if ($query->result ())
				return $query->row_array ();
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	
	function getquestionDetail($questionid, $answerid) {
		if (isset ( $questionid ) && '' != $questionid && isset ( $answerid ) && '' != $answerid) {
			
			$sql = "SELECT c.questions,l.answers ,if( l.answer_option='Y',TRUE,FALSE) as correct from  adhi_quiz_questions as c join adhi_quiz_answers as l on 
				c.id = l.question_id  where c.id ='" . $questionid . "' and l.id='" . $answerid . "'";
			
			$query = $this->db->query ( $sql );
			return $query->row_array ();
		}
	}
	
	function getcourse_name($quizid) {
		if (isset ( $quizid ) && '' != $quizid) {
			
			$this->db->select ( "course_name,adhi_courses.id as course_id" );
			$this->db->from ( 'adhi_courses' );
			$this->db->join ( 'adhi_quiz_list', 'adhi_courses.id = adhi_quiz_list.course_id' );
			$this->db->where ( 'adhi_quiz_list.id', $quizid );
			
			$query = $this->db->get ();
			
			if ($query->result ())
				return $query->result ();
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	/**
	 * Get topic name
	 * 
	 * @access public
	 * @param integer $quiz_id
	 * @return string $topic
	 */
	function get_topic_name($quiz_id)
	{
		// Throw an exception if quiz id is not present
		if(!isset($quiz_id) && '' == $quiz_id){
			show_error('get_topic_name(): Missing argument');
		}
		
		$this->db->select("topic");
		$this->db->from('adhi_quiz_list');
		$this->db->where('id', $quiz_id);
		$query = $this->db->get();
		
		$result = $query->result();
		
		if(!empty($result)){
			return $result[0]->topic;
		}
		
		return FALSE;
	}
	
	
	function save_user_quiz($quiz_id, $user_id) {
		
		if (isset ( $quiz_id ) && '' != $quiz_id && isset ( $user_id ) && '' != $user_id) {
			
			$array = array ('quiz_id' => $quiz_id, 'user_id' => $user_id, 'quiz_start' => convert_UTC_to_PST_datetime ( date ( 'Y-m-d H:i:s' ) ), 'quiz_end' => convert_UTC_to_PST_datetime ( date ( 'Y-m-d H:i:s', time () + 9000 ) ) );
			$this->db->set ( $array );
			$this->db->insert ( 'adhi_user_quiz' );
			$id = $this->db->insert_id ();
			if ($id)
				return $id;
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	function check_quiz_status($list_id) {
		
		if (isset ( $list_id ) && '' != $list_id) {
			
			$this->db->select ( "quiz_status" );
			$this->db->from ( 'adhi_quiz_list' );
			$this->db->where ( "id", $list_id );
			$query = $this->db->get ();
			return $query->row ();
		}
		return false;
	}
	function already_quiz_mode($user_id){
		$examend = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
		if(isset($user_id) && '' != $user_id){
		
			$this->db->where('user_id',$user_id);
			$this->db->where('quiz_end >',$examend);
			$this->db->order_by("quiz_end", "desc");
			
			$this->db->select ("id");
			
			$query	=	$this->db->get('adhi_user_quiz');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
				
		}else 
			return FALSE;
	}
	function ajax_quiz_update($id) {
		
		if (isset ( $id ) && $id != '') {
			$array = array ('quiz_time' => convert_UTC_to_PST_timeonly () );
			$this->db->set ( $array );
			
			$this->db->where ( 'id', $id );
			
			$this->db->update ( 'adhi_user_quiz' );
			return true;
		
		} else
			return FALSE;
	
	}
	function check_ajaxupdate_quiz($id) {
		if (isset ( $id ) && '' != $id) {
			
			$this->db->where ( 'id', $id );
			$this->db->where ( 'quiz_status !=', '1' );
			$this->db->select ( "quiz_time,user_id,quiz_id" );
			$query = $this->db->get ( 'adhi_user_quiz' );
			
			if ($row = $query->row ()) { //$time=time()-$row->exam_time;
				

				return $row;
			
			} else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	function update_endquiz_status($id = '', $course_id = '', $detail_id = '') {
		
		$array = array ('quiz_status' => 1, 'quiz_end' => convert_UTC_to_PST_datetime ( date ( 'Y-m-d H:i:s' ) ) );
		$this->db->set ( $array );
		
		if ($detail_id) {
			$this->db->where ( 'id', $detail_id );
		
		} else {
			$this->db->where ( 'user_id', $id );
			
			$this->db->where ( 'quiz_id', $course_id );
		}
		
		$this->db->update ( 'adhi_user_quiz' );
		return true;
		
	/*}else 
			return FALSE;*/
	
	}
	
	function getSingleQuizDetails($id) {
		
		if (isset ( $id ) && '' != $id) {
			$this->db->select ( '*' );
			$this->db->from ( 'adhi_quiz_list' );
			$this->db->where ( "id", $id );
			$query = $this->db->get ();
			return $query->row ();
		}
		return false;
	}
	
	function checkQuizStatus($course_id,$edition) {
		
		if (isset ( $course_id ) && '' != $course_id) {
			
			$this->db->select ( 'id' );
			$this->db->from ( 'adhi_quiz_list' );
			$this->db->where ( 'course_id', $course_id );
			$this->db->where ( 'edition', $edition );
			$this->db->where ( 'quiz_status !=', 'E' );
			$cnt = $this->db->count_all_results ();
			if ($cnt > 0) {
				return $cnt;
			} else
				return FALSE;
		
		}
		return false;
	}
	/**
	 * Function for changing the status of uploading
	 *
	 * @param array $updated_array - array of contents wants to be update
	 * @param string $condition - condition value
	 */
	function changeStatus($updated_array, $condition) {
		$this->db->where ( 's_name', $condition );
		return $this->db->update ( 'cc_settings', $updated_array );
	}
	/**
	 * function to check the total questions in a category matches the weightage for a particular user type
	 *
	 * @param unknown_type $user_type
	 * @return unknown
	 */
	function weightageCheckingByUsertype($user_type) {
		//checks if the questions count in the category in equal to the question count in the question bank
		

		$this->db->select ( "(SELECT COUNT(qb.course_id) FROM adhi_license_course AS qb WHERE qb.course_id = ct.id AND qb.licensetype = " . $user_type . ") AS total_questions", FALSE );
		$this->db->select ( 'ct.id as id, ct.wieght AS sales, ct.wieght AS broker' );
		$query = $this->db->get ( 'adhi_courses AS ct' );
		$result = '';
		if ($query->result ()) {
			$result = $query->result ();
		}
		return $result;
	}
	
	/**
	 * Get correct answer for a question
	 * 
	 * @access public
	 * @param integer $question_id
	 * @return array 
	 */
	function get_correct_ans($question_id) {
		//throw an exception if question_id is not present
		if (! isset ( $question_id ) && '' != $question_id) {
			show_error ( "Parameter question id is missing." );
		}
		
		//Get the record for corresponding id
		$sql = 'SELECT answers from adhi_quiz_answers WHERE question_id = ' . $question_id . ' AND answer_option = "Y"';
		$query = $this->db->query ( $sql );
		
		$result = $query->row ();
		
		// If result is empty return false
		if (empty ( $result )) {
			return FALSE;
		}
		
		return $result->answers;
	
	}
	function fncGetQuestionsOptions($arr_question){
		
		if(isset ($arr_question) && '' != $arr_question){
			$this->db->select("answers, question_id, id AS answer_id");
			$this->db->from('adhi_quiz_answers');
			
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
	}
	function get_quiz_question_ans($id){
		$vido_url = $this->config->item('quiz_video_location');
		if(isset ($id) && '' != $id){
			$sql="SELECT c.id ,c.questions,c.video,concat_ws('','$vido_url',c.video) as video_url,l.answers,l.answer_option ,l.id as ansid from  adhi_quiz_questions as c join adhi_quiz_answers as l on 
				c.id = l.question_id  where c.id ='".$id."'";
				$query= $this->db->query($sql);
				return $query->result_array();
		}else 
			return FALSE;

	}
}