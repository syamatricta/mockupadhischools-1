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


class Admin_quiz_model extends Model {
	
	function Admin_quiz_model() {
		parent::Model ();
	
		//$this->output->enable_profiler();
	}
	/**
	 * function to save the exam details
	 *
	 * @return result array
	 */
	function get_course($course_id) {
		
		if (isset ( $course_id ) && '' != $course_id) {
			$past_date = convert_UTC_to_PST_datetime ( date ( "Y-m-d H:i:s", time () - (9000) ) );
			
			$sql = "SELECT"
				. " lst.quiz_name, lst.quiz_status, lst.id, lst.topic,lst.edition, ed.edition_no,  "
				. " (select count(qn.id) from adhi_quiz_questions as qn where qn.list_id = lst.id) as qn_count, "
				. " (select count(ex.id) from adhi_user_quiz as ex where ex.quiz_id = lst.id and ex.quiz_status ='0') as ex_count "
				. " FROM adhi_quiz_list as lst JOIN adhi_edition_summary ed ON ed.id = lst.edition WHERE lst.course_id='" 
				. $course_id . "'  ORDER BY id  ASC";
			
			$query = $this->db->query ( $sql );
			
			if ($query->result ())
				return $query->result_array ();
			else
				return FALSE;
		} else
			return FALSE;
	}
	
	function changeExamStatus($course_id, $status, $edition_id='') {
		
		if (isset ( $course_id ) && '' != $course_id && isset ( $status ) && '' != $status) {
			
			$array = array ('quiz_status' => addslashes ( $status ) );
			$this->db->set ( $array );
			if($edition_id)
				$this->db->where('edition', $edition_id);
			$this->db->where ( 'id', $course_id );
			if ($this->db->update ( 'adhi_quiz_list' ))
				return TRUE;
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	function getNextQuizNo($course_id,$edition_id) {
		
		if (isset ( $course_id ) && '' != $course_id) {
			
			$this->db->select ( 'id' );
			$this->db->from ( 'adhi_quiz_list' );
			$this->db->where ( 'course_id', $course_id );
			$this->db->where ( 'edition', $edition_id );
			$cnt = $this->db->count_all_results ();
			if ($cnt > 0) {
				
				return $cnt;
			} else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	/**
	 * Get chapter list by course
	 * 
	 * @access public
	 * @param int $course_id
	 * @return mixed $result 
	 */
	function get_chapters_by_course($course_id,$edition=0)
	{
		// Throw an exception if course_id is not present
		if(empty($course_id)){
			//show_error('Missing argument!');
			return FALSE;
		}
		if($edition){
			$this->db->where('edition', $edition);
		}
		$this->db->select('id, quiz_name');
		$this->db->from('adhi_quiz_list');
		$this->db->where('course_id', $course_id);
		$this->db->where('quiz_status', 'E');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
		$result = $query->result();
		
		if($result) {
			return $result;
		} else {
			return FALSE;
			
			//show_error("Something went wrong");
		}
	}
	
	
	
	/*	function getlist_name($course_id){
		
		if(isset ($course_id) && '' != $course_id){
			
			$this->db->select('quiz_name');
			$this->db->from('adhi_quiz_list');
			$this->db->where('course_id',$course_id);
			$query = $this->db->get();
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
			 
		}else 
			return FALSE;
		

	}*/
	
	function savequizDetails($path, $course_id, $quizname, $topic,$edition_id) {
		
		if(isset($path)&& '' != $path 
		   && isset($course_id) && '' != $course_id 
		   && isset($quizname) && '' != $quizname 
		   && isset($topic) && '' != $topic) {
			
			$array = array(
				'xls_path' => addslashes($path), 
				'course_id' => $course_id, 
				'edition' => $edition_id, 
				'quiz_name' => $quizname, 
				'topic' => $topic 
			);
			
			$this->db->set ( $array );
			$this->db->insert ( 'adhi_quiz_list' );
			$list_id = $this->db->insert_id (); //getting the inserted id
			

			if ($list_id)
				return $list_id;
			else
				return FALSE;
		} else {
			return FALSE;
		}
	}
	
	function saveXls_question($newData, $course_id) {
		
		if (isset ( $newData ) && '' != $newData && isset ( $course_id ) && '' != $course_id) {
			
			$array = array ('questions' => addslashes ( $newData ), 'list_id' => $course_id );
			$this->db->set ( $array );
			$this->db->insert ( 'adhi_quiz_questions' );
			$ques_id = $this->db->insert_id (); //getting the inserted id
			

			if ($ques_id)
				return $ques_id;
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	
	/**
	 * 
	 * Save video for question
	 * @param integer $question_id
	 * @param string $video, Can be null
	 */
	function save_xls_question_vedio($question_id, $video = NULL)
	{
		if(isset($question_id) && '' != $question_id &&  isset($video)){
			$data = array('video' => $video);
			
			$this->db->set($data);
			$this->db->where('id', $question_id);
			if($this->db->update('adhi_quiz_questions')) {
				return TRUE;
			}
			
			return FALSE;
		}
	}
	
	function saveXls_ans($answer, $question_id) {
		
		if (isset ( $answer ) && '' != $answer && isset ( $question_id ) && '' != $question_id) {
			
			$array = array ('answers' => addslashes ( $answer ), 'question_id' => $question_id );
			$this->db->set ( $array );
			$this->db->insert ( 'adhi_quiz_answers' );
			$ans_id = $this->db->insert_id (); //getting the inserted id

			if ($ans_id)
				return $ans_id;
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	function updateXls_ans($answer_opt, $ans_id) {
		
		if (isset ( $answer_opt ) && '' != $answer_opt && isset ( $ans_id ) && '' != $ans_id) {
			
			$array = array ('answer_option' => addslashes ( $answer_opt ) );
			$this->db->set ( $array );
			
			$this->db->where ( 'id', $ans_id );
			
			if ($this->db->update ( 'adhi_quiz_answers' ))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	
	function get_questions($quest_id,$edition_id='') {
		
		if (isset ( $quest_id ) && '' != $quest_id) {
			$this->db->select ( "qn.*" );
			$this->db->from ( 'adhi_quiz_questions qn' );
			
			$this->db->where ( 'qn.list_id', $quest_id );
			if($edition_id){
				$this->db->where('el.edition', $edition_id);
				$this->db->join('adhi_quiz_list el', 'el.id = qn.list_id');
			}
			$query = $this->db->get ();
			if ($query->result ())
				return $query->result ();
			else
				return FALSE;
		
		} else
			return FALSE;
	}
	function get_one_quest_ans($ques_id, $list_id) {
		
		if (isset ( $ques_id ) && '' != $ques_id && isset ( $list_id ) && '' != $list_id) {
			
			$sql_query = "SELECT c.questions , c.video,  c.list_id , d.answers , d.answer_option , d.id as ansid from  adhi_quiz_questions as c join adhi_quiz_answers as d on 
							c.id = d.question_id  where c.id ='$ques_id' and c.list_id='$list_id' order by d.id ";
			
			$query = $this->db->query ( $sql_query );
			
			if ($query->result ())
				return $query->result ();
			else
				return FALSE;
		
		//return $query->result();
		

		} else
			return FALSE;
	
	}
	function update_questions($ques_id, $questions, $video = '') {
		
		if (isset ( $ques_id ) && '' != $ques_id && isset ( $questions ) && '' != $questions) {
			
			$array = array ('questions' => addslashes($questions), 'video' => $video );
			$this->db->set ( $array );
			
			$this->db->where ( 'id', $ques_id );
			
			if ($this->db->update ( 'adhi_quiz_questions' ))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	
	function update_answers($ques_id, $ans_id, $answer, $option) {
		
		if (isset ( $ques_id ) && '' != $ques_id && isset ( $ans_id ) && '' != $ans_id && isset ( $answer ) && '' != $answer && isset ( $option ) && '' != $option) {
			
			$array = array ('answers' => addslashes ( $answer ), 'answer_option' => addslashes ( $option ) );
			$this->db->set ( $array );
			
			$this->db->where ( 'id', $ans_id );
			$this->db->where ( 'question_id', $ques_id );
			
			if ($this->db->update ( 'adhi_quiz_answers' ))
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	
	function delete_question($ques_id) {
		
		if (isset ( $ques_id ) && $ques_id != '') {
			
			$sql = "DELETE c.*,d.* from adhi_quiz_questions as c join adhi_quiz_answers as d on 
			c.id = d.question_id  where c.id ='$ques_id'";
			
			$query = $this->db->query ( $sql );
			
			if ($this->db->affected_rows ())
				return TRUE;
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	function delete_course_question($list_id, $edition_id='', $xls_path = '') {
		
		if (isset ( $list_id ) && $list_id != '') {
			$qryCn = $joinCn = '';
			if($edition_id){
				$qryCn = " AND el.edition = $edition_id";
				$joinCn = " join adhi_quiz_list as el on el.id = c.list_id";
			}
			
			$sql = "DELETE c.*,d.* from adhi_quiz_questions as c join adhi_quiz_answers as d on 
			c.id = d.question_id $joinCn where c.list_id ='$list_id' $qryCn";
			
			$query = $this->db->query ( $sql );
			
			$this->delete_quizlist ( $list_id, $edition_id, $xls_path );
			
			if ($this->db->affected_rows ())
				return TRUE;
			else
				return FALSE;
		} else
			return FALSE;
	
	}
	
	function delete_quizlist($list_id,$edition_id='', $xls_path = '') {
		
		if (isset ( $list_id ) && $list_id != '') {
			
			if ($xls_path)
				$this->db->where ( 'xls_path', $xls_path );
			
			$this->db->where ( 'id', $list_id );
			if($edition_id)
				$this->db->where('edition', $edition_id);
			//updates the delete status
			

			if ($this->changeExamStatus ( $list_id, 'DEL', $edition_id )) {
				return TRUE;
			} else {
				return FALSE;
			}
			
		/*if ($this->db->delete('adhi_quiz_list')) {
				
				if ($this->db->affected_rows())
					return TRUE;
				else 
					return FALSE;
			
			}
			else 
				return FALSE;*/
		
		} else
			return FALSE;
	
	}
	
	function delete_raw_quizlist($list_id, $xls_path = '') {
		
		if (isset ( $list_id ) && $list_id != '') {
			
			if ($xls_path)
				$this->db->where ( 'xls_path', $xls_path );
			
			$this->db->where ( 'id', $list_id );
			
			if ($this->db->delete ( 'adhi_quiz_list' )) {
				
				if ($this->db->affected_rows ())
					return TRUE;
				else
					return FALSE;
			
			} else
				return FALSE;
		}
	
	}
	
	function getQuizList($list_id, $xls = '') {
		
		if (isset ( $list_id ) && $list_id != '') {
			
			$this->db->select ( "*" );
			$this->db->from ( 'adhi_quiz_list' );
			
			if ($xls)
				$this->db->where ( 'xls_path  <> ', $xls );
			
			$this->db->where ( 'id', $list_id );
			
			$query = $this->db->get ();
			
			if ($query->result ())
				return $query->result ();
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	function add_questions($listid, $questions, $video = '') {
		
		if (isset ( $listid ) && '' != $listid && isset ( $questions ) && '' != $questions) {
			
			$array = array (
				'questions' => addslashes($questions), 
				'list_id' => addslashes($listid),
				'video' => addslashes($video)
			);
			
			$this->db->set ( $array );
			
			$this->db->insert ( 'adhi_quiz_questions' );
			$ans_id = $this->db->insert_id (); //getting the inserted id
			

			if ($ans_id)
				return $ans_id;
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	function add_answers($ques_id, $answer, $option) {
		
		if (isset ( $ques_id ) && '' != $ques_id && isset ( $answer ) && '' != $answer && isset ( $option ) && '' != $option) {
			
			$array = array ('answers' => addslashes ( $answer ), 'answer_option' => addslashes ( $option ), 'question_id' => addslashes ( $ques_id ) );
			$this->db->set ( $array );
			
			$this->db->insert ( 'adhi_quiz_answers' );
			
			$ans_id = $this->db->insert_id (); //getting the inserted id
			

			if ($ans_id)
				return $ans_id;
			else
				return FALSE;
		
		} else
			return FALSE;
	
	}
	
	function get_course_lst($id = '') {
		
		$sql = "SELECT c.course_name , c.id , c.parent_course_id , 0 as count_sub FROM `adhi_courses` as c  where parent_course_id='0' order by course_code ";
		$query = $this->db->query ( $sql );
		
		if ($query->result ())
			return $query->result ();
		else
			return FALSE;
	}
	
	
	function get_course_lst_by_user($user_id) 
	{
		if(empty($user_id) || '' == $user_id) {
			return FALSE;
		}
		
		$sql = "SELECT c.course_name , c.id , c.parent_course_id , 0 as count_sub FROM `adhi_courses` as c "
			  . " JOIN adhi_user_course auc on auc.courseid = c.id"
		      . " where parent_course_id = '0' AND auc.userid = '" . $user_id . "'" 
		      . " order by course_code ";
		$query = $this->db->query ( $sql );
		
		if ($query->result ())
			return $query->result ();
		else
			return FALSE;
	}
	
	function check_user_course_list($course_id, $user_id) 
	{
		if((empty($user_id) || '' == $user_id)
		  || (empty($course_id) || '' == $course_id)) {
			return FALSE;
		}
		
		$sql = "SELECT c.id FROM `adhi_courses` as c "
			  . " JOIN adhi_user_course auc on auc.courseid = c.id"
		      . " where parent_course_id = '0' AND auc.userid = '" . $user_id . "'"
		      . " AND auc.courseid = " . $course_id 
		      . " order by course_code ";
		$query = $this->db->query ( $sql );
		
		if ($query->result ())
			return TRUE;
		else
			return FALSE;
	}
	
	
	
	function checkUserTakingQuiz($quiz_id) {
		
		if (isset ( $quiz_id ) && '' != $quiz_id) {
			
			$this->db->select ( 'id' );
			$this->db->from ( 'adhi_user_quiz' );
			$this->db->where ( 'quiz_id', $quiz_id );
			$this->db->where ( 'quiz_status', 0 );
			$cnt = $this->db->count_all_results ();
			if ($cnt > 0) {
				return $cnt;
			} else
				return FALSE;
		
		}
		return false;
	
	}
	
	/**
	 * update topic 
	 * @access public
	 * @param int $list_id, string $topic
	 * @return int $list_id;
	 */
	function updateTopic($listId, $topic)
	{
		// validate arguments, if missing throw an exception
		if(!isset($listId) || !isset($topic) ){
			show_error('Missing arguments!');
		}

		// Updating to db
		$this->db->set(array('topic' => $topic));
		$this->db->where('id', $listId);
		$result = $this->db->update('adhi_quiz_list');
		
		if(!$result){
			show_error('Something went wrong!');
		}
		
		return true;
	}
        
        function getQuestions($list_id) {
		
            if (isset ( $list_id ) && '' != $list_id) {
                $sql = "SELECT q.id, q.questions as question, q.video 
                        FROM adhi_quiz_questions as q 
                        WHERE q.list_id = " . $list_id;

                $query = $this->db->query ( $sql );
                return $query->result_array();
            } else
                return FALSE;
	
	}
        function getQuestionOptions($question_id) {
		
            if (isset ( $question_id ) && '' != $question_id) {
                $sql = "SELECT a.id, a.answers as answer, a.answer_option 
                        FROM adhi_quiz_answers as a 
                        WHERE a.question_id = " . $question_id . " ORDER BY a.id ASC";

                $query = $this->db->query ( $sql );
                return $query->result_array();
            } else
                return FALSE;
	
	}
	
}