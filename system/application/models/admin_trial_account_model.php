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


class Admin_trial_account_model extends Model {
	
	function Admin_trial_account_model() {
		parent::Model ();
	
		//$this->output->enable_profiler();
	}
        
        function getSettings(){
            $result = $this->db->get('adhi_trial_settings');
            return $result->row();
        }
        
        function getQuizDetails($list_id){
            $this->db->select('ql.course_id, ql.id as chapter_id, ql.edition, ql.quiz_name, ql.topic, cv.video, cv.description as video_desc, c.course_name');
            $this->db->where('ql.id', $list_id);
            $this->db->join('adhi_classroom_videos cv', 'cv.quiz_id=ql.id', 'left');
            $this->db->join('adhi_courses c', 'c.id=ql.course_id', 'left');
            $result = $this->db->get('adhi_quiz_list ql');
            return ($result) ? $result->row() : FALSE;
        }
        function updateSettings($data){
            $this->db->where('id', 1);
            $this->db->set($data);
            $result = $this->db->update('adhi_trial_settings');
            return ($result) ? TRUE : FALSE;
        }
        
        function totalTrialUserCount($type = 'all'){
            $this->db->select('count(id) as count');
            if('adhi_user' == $type){
                $this->db->where('reg_user_id', 0, FALSE);
            }
            $result = $this->db->get('adhi_trial_users');
            return ($row = $result->row()) ? $row->count: 0;
        }
        
	function freezeTrialUser($id, $data){		
            $this->db->where('id', $id);
            $update_data	= array(
                                    'status'        => 4,
                                    'reason'        => $data['reason'], 
                                    'updated_date'  => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                    );
            $updates	= $this->db->update('adhi_trial_users', $update_data);

            if($updates > 0 ){
                return TRUE;
            }else {
                return FALSE;

            }
	}
        
	function unfreezeTrialUser($id, $data){
		
            $this->db->where('id', $id);
            $update_data	= array(
                                    'status'        => 1,
                                    'updated_date'  => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                    );
            $updates	= $this->db->update('adhi_trial_users', $update_data);

            if($updates > 0 ){
                return TRUE;
            }else {
                return FALSE;

            }
	}
}