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

class Admin_exam_model extends Model{
	
	function Admin_exam_model (){
		parent::Model ();
	}  
	/**
	 * function to save the exam details
	 *
	 * @return id
	 */
	function saveExamDetails ($xls_url,$course_id,$edition_id) {
		
		if (isset ($xls_url) && '' != $xls_url && isset ($course_id) && '' != $course_id){
		
			$array = array('xls_path' => $xls_url, 'course_id' => $course_id,'edition' => $edition_id);
			$this->db->set($array);
			
			$this->db->insert('adhi_exam_list'); 
			
			$exam_id = $this->db->insert_id ();//getting the inserted id
			
			if($exam_id)
				return $exam_id;
			else 	
				return FALSE;
		}else 	
			return FALSE;
		
	}
/*	function listExam(){
		$this->db->select ("*");
		$this->db->from('adhi_user');
	    $this->db->limit($num,$offset);
		$query	=	$this->db->get();
		return($query->result());
	}*/
	function get_course_license($id){
		
		if(isset ($id) && '' != $id){
			
			$this->db->where('id',$id);
			$this->db->select ("*");
			$query	=	$this->db->get('adhi_courses');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
			
		}else 	
			return FALSE;
	}
	
	function get_course(){
		
		// WHERE cs.parent_course_id=0';
		$past_date	=	convert_UTC_to_PST_datetime(date("Y-m-d H:i:s", time()-(9000)));
		$now_date	=	convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
		
	     $sql="SELECT cs.course_name,cs.id,cs.exam_status,cs.parent_course_id as parent_id , (select count(cc.course_code) from adhi_courses as cc where cc.parent_course_id=cs.id) as child_cnt ,(select count(qn.id) from adhi_exam_questions as qn where qn.course_id = cs.id) as qn_count ,
			(select count(ex.id) from adhi_user_exam as ex where ex.course_id = cs.id and ex.exam_start > '".$past_date."' and ex.exam_end >'" .$now_date."') as ex_count FROM adhi_courses as cs WHERE cs.parent_course_id =0 ORDER BY course_code ";
		$query=$this->db->query($sql);
		
		if($query->result_array())
			return $query->result_array();
		else 
			return FALSE;
	}
	

	function isQuestionExists($newData,$course_id,$edition_id){
        $array = array('questions' => addslashes($newData), 'course_id' => $course_id, 'edition' =>$edition_id);
        $this->db->where("LOWER(questions) = '".trim(strtolower(addslashes($newData)))."'", NULL, FALSE);
        $this->db->where('course_id', $course_id);
        $this->db->where('edition', $edition_id);
        $this->db->from('adhi_exam_questions');
        $query = $this->db->get();
        return ( $query->num_rows() > 0) ? TRUE :  FALSE;
    }

	function saveXls_question($newData,$course_id,$edition_id){

		if(isset ($newData) && '' != $newData && isset ($course_id) && '' != $course_id){
		    if(!$this->isQuestionExists(addslashes($newData),$course_id,$edition_id)){
		        $array = array('questions' => addslashes($newData), 'course_id' => $course_id, 'edition' =>$edition_id);
                $this->db->set($array);
                $this->db->insert('adhi_exam_questions');
                $ques_id = $this->db->insert_id ();//getting the inserted id

                if($ques_id)
                    return $ques_id;
            }
		}
        return FALSE;
		
	}
	
	function saveXls_ans($answer,$question_id){
		
		if(isset ($answer) && '' != $answer && isset ($question_id) && '' != $question_id){
		
			$array = array('answers' => addslashes($answer), 'question_id' => $question_id  );
			$this->db->set($array);
			$this->db->insert('adhi_exam_answers'); 
			$ans_id = $this->db->insert_id ();//getting the inserted id
			
			if($ans_id)
				return $ans_id;
			else 	
				return FALSE;
		}else 	
			return FALSE;
		
		
	}
	function updateXls_ans($answer_opt,$ans_id){
		
		if(isset ($answer_opt) && '' != $answer_opt && isset ($ans_id) && '' != $ans_id){
			
			$array = array('answer_option' => addslashes($answer_opt));
			$this->db->set($array);
			
			$this->db->where('id',$ans_id);
			
			if($this->db->update('adhi_exam_answers'))
				return TRUE;
			else 
				return FALSE;
		}else 
			return FALSE;
		
	}
	
	function get_quest_ans($course_id){
		
		if(isset ($course_id) && '' != $course_id){
			$this->db->select("*");
			$this->db->from('adhi_exam_questions');
			$this->db->join('adhi_exam_answers', 'adhi_exam_questions.id = adhi_exam_answers.question_id');
			$this->db->where('adhi_exam_questions.course_id', $course_id);
			
			$query = $this->db->get();
			
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
		}else 	
			return FALSE;
	}
	
	function get_questions($course_id,$edition_id=''){
		
		if(isset ($course_id) && '' != $course_id){
			$this->db->select("qn.*");
			$this->db->from('adhi_exam_questions qn');
			
			$this->db->where('qn.course_id', $course_id);
			if($edition_id){
				$this->db->where('qn.edition', $edition_id);
				$this->db->where('el.edition', $edition_id);
				$this->db->join('adhi_exam_list el', 'el.course_id = qn.course_id');
			}
			$query = $this->db->get();
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
			
		}else 
			return FALSE;
	}
	
	function get_one_quest_ans($ques_id,$course_id){
		
		if(isset ($ques_id) && '' != $ques_id && isset ($course_id) && '' != $course_id) 
		{
		
			$sql_query= "SELECT c.*,d.id as ansid ,d.answers ,d.answer_option from  adhi_exam_questions as c join adhi_exam_answers as d on 
			c.id = d.question_id  where c.id ='$ques_id' and c.course_id='$course_id' order by d.id ";
			$query= $this->db->query($sql_query);
			
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
			//return $query->result();
			
		}else 
			return FALSE;
		
		
		
/*		$this->db->select("*");
		$this->db->from('adhi_exam_questions');
		$this->db->join('adhi_exam_answers', 'adhi_exam_questions.id = adhi_exam_answers.question_id');
		$this->db->where('adhi_exam_questions.id', $ques_id);
		$this->db->where('adhi_exam_questions.course_id', $course_id);*/
		
		//$query = $this->db->get();
		
		
	}
	
	function update_questions($ques_id,$questions){

		if(isset ($ques_id) && '' != $ques_id && isset ($questions) && '' != $questions){
		
			$array = array('questions' => fncReplaceQuotes_reverese(addslashes($questions)));
			$this->db->set($array);
			
			$this->db->where('id',$ques_id);
			
			if($this->db->update('adhi_exam_questions'))
				return TRUE;
			else 
				return FALSE; 
		}else 
			return FALSE;

	}
	
	function update_answers($ques_id,$ans_id,$answer,$option){
		
		if(isset ($ques_id) && '' != $ques_id && isset ($ans_id) && '' != $ans_id && isset ($answer) && '' != $answer && isset ($option) && '' != $option  ){
		
			$array = array('answers' => fncReplaceQuotes_reverese(addslashes($answer)),'answer_option' => addslashes($option));
			$this->db->set($array);
			
			$this->db->where('id',$ans_id);
			$this->db->where('question_id',$ques_id);
			
			if($this->db->update('adhi_exam_answers'))
				return TRUE;
			else 
				return FALSE;
		}else 
			return FALSE;

	}
	
	function delete_question($ques_id){
		
		if (isset ($ques_id) && $ques_id!='') {
		
			$sql="DELETE c.*,d.* from adhi_exam_questions as c join adhi_exam_answers as d on 
			c.id = d.question_id  where c.id ='$ques_id'";
			
			$query= $this->db->query($sql);
			
			if ($this->db->affected_rows()) 
				return TRUE;
			else 
				return FALSE;
			
		}else
			return FALSE;
	
	}
	
	function delete_course_question($course_id,$edition_id='',$xls_path=''){
			
		if (isset ($course_id) && $course_id!='') {
			$qryCn = $joinCn = '';
			if($edition_id){
				$qryCn = " AND c.edition = $edition_id";
				$qryCn .= " AND el.edition = $edition_id";
				$joinCn = " join adhi_exam_list as el on c.course_id = el.course_id";
			}
				
			$sql="DELETE c.*,d.* from adhi_exam_questions as c join adhi_exam_answers as d on 
			c.id = d.question_id $joinCn where c.course_id ='$course_id' $qryCn";
			//die($sql);
			
			//die();
			$query= $this->db->query($sql);
			$this->delete_examlist($course_id,$edition_id,$xls_path);
			if ($this->db->affected_rows()) 
				return TRUE;
			else 
				return FALSE;
		}else 
			return FALSE;
	
	}
	
	function delete_examlist($course_id,$edition_id='',$xls_path=''){
		//die($course_id);
		if (isset ($course_id) && $course_id!='') {

			if($xls_path)
				$this->db->where('xls_path', $xls_path);	
			
			$this->db->where('course_id', $course_id);
			if($edition_id)
				$this->db->where('edition', $edition_id);
				
			if ($this->db->delete('adhi_exam_list')) {
				if ($this->db->affected_rows())
					return TRUE;
				else 
					return FALSE;			
			}
			else 
				return FALSE;
		
		}else 
			return FALSE;
	
	}
	
		
	function getExamList($course_id,$edition_id='',$xls=''){
		
		if (isset ($course_id) && $course_id!='') {
		
			$this->db->select("*");
			$this->db->from('adhi_exam_list');
			
			if($xls)
				$this->db->where('xls_path  <> ', $xls);
					
			$this->db->where('course_id', $course_id);
			if($edition_id)
				$this->db->where('edition', $edition_id);
			
			$query = $this->db->get();
			
			if($query->result())
				return $query->result();
			else 	
				return FALSE;
			
		}else 
			return FALSE;
		
	}
	
	function add_questions($course_id,$questions,$edition){
		
		if(isset ($course_id) && '' != $course_id && isset ($questions) && '' != $questions) {
			
			$array = array('questions' => addslashes($questions),'course_id' => addslashes($course_id),'edition' => addslashes($edition));
			$this->db->set($array);
			
			$this->db->insert('adhi_exam_questions'); 
			$ans_id = $this->db->insert_id ();//getting the inserted id
			
			if($ans_id)
				return $ans_id;
			else 	
				return FALSE;
			
		}else 
			return FALSE;
 

	}
	function add_answers($ques_id,$answer,$option){
		
		if(isset ($ques_id) && '' != $ques_id && isset ($answer) && '' != $answer && isset ($option) && '' != $option) {
			
			$array = array('answers' => addslashes($answer),'answer_option' => addslashes($option),'question_id'=>addslashes($ques_id));
			$this->db->set($array);
			
			$this->db->insert('adhi_exam_answers'); 
			
			$ans_id = $this->db->insert_id ();//getting the inserted id
			
			if($ans_id)
				return $ans_id;
			else 	
				return FALSE;
			
		}else 
			return FALSE;
		
	}
	
	function changeExamStatus($course_id,$status){
		
		if(isset ($course_id) && '' != $course_id && isset ($status) && '' != $status){
			
			$array = array('exam_status' => addslashes($status));
			$this->db->set($array);
			
			$this->db->where('id',$course_id); 
			if($this->db->update('adhi_courses'))
				return TRUE;
			else 	
				return FALSE;
			 
		}else 
			return FALSE;
		

	}
	
}
